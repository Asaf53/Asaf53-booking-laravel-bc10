<?php

namespace App\Http\Controllers;

use App\Models\country;
use App\Models\property;
use App\Models\property_images;
use App\Models\property_type;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $dateRange = $request->daterange;
        // $dateParts = explode('-', $dateRange);
        // $startDate = trim($dateParts[0]);
        // $endDate = trim($dateParts[1]);
        /** @var \App\Models\User */
        $user = Auth::user();
        if ($user->hasRole('partner')) {
            $properties = property::where('user_id', $user->id)->get();
            return view('property.index', ['properties' => $properties]);
        } elseif ($user->hasRole('admin')) {
            $properties = property::all();
            return view('property.index', ['properties' => $properties]);
        } else {
            return redirect()->back()->with('status', 'You don`t have access to this page!!!');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        /** @var \App\Models\User */
        $user = Auth::user();
        if (!$user->hasRole('partner')) return redirect()->back()->with('status', 'You don`t have access to this page!!!');

        $countries = country::all();
        $types = property_type::all();
        return view('property.create', ['countries' => $countries, 'types' => $types]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        /** @var \App\Models\User */
        $user = Auth::user();
        if (!$user->hasRole('partner')) return redirect()->back()->with('status', 'You don`t have access to this page!!!');

        $request->validate([
            'name' => 'required|string|max:100',
            'types' => 'required',
            'address' => 'required|string|max:150',
            'country_id' => 'required',
            'city_id' => 'required',
        ]);

        $property = property::create([
            'user_id' => $user->id,
            'property_type_id' => $request->types,
            'name' => $request->name,
            'locations' => $request->address,
            'country_id' => $request->country_id,
            'city_id' => $request->city_id,
        ]);

        foreach ($request->file('images', []) as $image) {
            if ($image->isValid() && $image->getClientOriginalExtension()) {
                $imageName = uniqid('property_') . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/images/property-images', $imageName);

                property_images::create([
                    'property_id' => $property->id,
                    'image' => $imageName,
                ]);
            }
        }
        if ($property) {
            return redirect()->route('properties.index')->with('status', 'Property created successfully.');
        }
        return redirect()->route('properties.index')->with('status', 'Failed to update property.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        /** @var \App\Models\User */
        $user = Auth::user();
        if ($user->hasRole('partner')) {
            $property = property::findOrFail($id);
            $countries = country::all();
            $types = property_type::all();
            return view('property.edit', ['property' => $property, 'countries' => $countries, 'types' => $types]);
        } elseif ($user->hasRole('admin')) {
            $property = property::findOrFail($id);
            $countries = country::all();
            $users = User::all();
            $types = property_type::all();
            return view('property.edit', ['property' => $property, 'countries' => $countries, 'users' => $users, 'types' => $types]);
        } else {
            return redirect()->back()->with('status', 'You don`t have access to this page!!!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        /** @var \App\Models\User */
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:100',
            'types' => 'required',
            'address' => 'required|string|max:150',
            'country_id' => 'required',
            'city_id' => 'required',
        ]);

        if ($user->hasRole('partner')) {
            $property = property::findOrFail($id);
            $property->name = $request->name;
            $property->property_type_id = $request->types;
            $property->user_id = $user->id;
            $property->locations = $request->address;
            $property->country_id = $request->country_id;
            $property->city_id = $request->city_id;


            $property_images = property_images::where('property_id', '=', $id)->get();
            foreach ($property_images as $property_image) {
                $filePath = 'storage/images/property-images/' . $property_image->image;
                unlink($filePath);
                $property_image->delete();
            }

            $images = $request->file('images');
            foreach ($images as $image) {
                $imageName = uniqid('property_') . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/images/property-images', $imageName);

                property_images::create([
                    'property_id' => $property->id,
                    'image' => $imageName,
                ]);
            }


            if ($property->save()) return redirect()->route('properties.index')->with('status', 'Property updated successfully.');
            return redirect()->route('properties.index')->with('status', 'Failed to update property.');
        }

        $property = property::findOrFail($id);
        $property->name = $request->name;
        $property->property_type_id = $request->types;
        $property->user_id = $request->user_id;
        $property->locations = $request->address;
        $property->country_id = $request->country_id;
        $property->city_id = $request->city_id;
        foreach ($request->file('images', []) as $image) {
            if ($image->isValid() && $image->getClientOriginalExtension()) {
                $imageName = uniqid('property_') . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/images/property-images', $imageName);

                property_images::create([
                    'property_id' => $property->id,
                    'image' => $imageName,
                ]);
            }
        }
        if ($property->update($request->except('_token'))) return redirect()->route('properties.index')->with('status', 'Property updated successfully.');
        return redirect()->route('properties.index')->with('status', 'Failed to update property.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        /** @var \App\Models\User */
        $checkUser = Auth::user();
        if (!$checkUser->hasRole('admin|partner')) return redirect()->back()->with('status', 'You don`t have access to this page!!!');
        $property = property::findOrFail($id);
        if ($property->delete()) return redirect()->back()->with('status', 'Property deleted successfully.');
        return redirect()->back()->with('status', 'Failed to delete property');
    }
}
