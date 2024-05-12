<?php

namespace App\Http\Controllers;

use App\Models\property_type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PropertyTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /** @var \App\Models\User */
        $user = Auth::user();
        if (!$user->hasRole('admin')) return redirect()->back()->with('status', 'You don`t have access to this page!!!');

        $types = property_type::all();
        return view('property.type.index', ['types' => $types]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        /** @var \App\Models\User */
        $user = Auth::user();
        if (!$user->hasRole('admin')) return redirect()->back()->with('status', 'You don`t have access to this page!!!');

        return view('property.type.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /** @var \App\Models\User */
        $user = Auth::user();
        if (!$user->hasRole('admin')) return redirect()->back()->with('status', 'You don`t have access to this page!!!');

        $request->validate([
            'name' => 'required|string|max:100',
            'photo' => 'required|file|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        $imageName = null;

        if ($request->hasFile('photo')) {
            $imageFile = $request->file('photo');

            if ($imageFile->isValid() && $imageFile->getClientOriginalExtension()) {
                $imageName = uniqid('property_') . '.' . $imageFile->getClientOriginalExtension();
                $imageFile->storeAs('public/images/property-types', $imageName);
            }
        }

        $type = property_type::create([
            'name' => $request->name,
            'photo' => $imageName,
        ]);
        if ($type) {
            return redirect()->route('property-types.index')->with('status', 'Property Type created successfully.');
        }
        return redirect()->route('property-types.index')->with('status', 'Failed to update property type.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        /** @var \App\Models\User */
        $user = Auth::user();
        if (!$user->hasRole('admin')) return redirect()->back()->with('status', 'You don`t have access to this page!!!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        /** @var \App\Models\User */
        $user = Auth::user();
        if (!$user->hasRole('admin')) return redirect()->back()->with('status', 'You don`t have access to this page!!!');

        $type = property_type::findOrFail($id);
        return view('property.type.edit', ['type' => $type]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        /** @var \App\Models\User */
        $user = Auth::user();
        if (!$user->hasRole('admin')) return redirect()->back()->with('status', 'You don`t have access to this page!!!');

        $type = property_type::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'photo' => 'required|image|mimes:jpeg,jpg,png|max:2048',
        ]);



        $imageName = null;

        if ($request->hasFile('photo')) {
            $imageFile = $request->file('photo');
            if ($imageFile->isValid() && $imageFile->getClientOriginalExtension()) {
                $imageName = uniqid('property_') . '.' . $imageFile->getClientOriginalExtension();
                $imageFile->storeAs('public/images/property-types', $imageName);
            }
            if ($type->photo && Storage::disk('public')->exists('images/property-types' . $type->photo)) {
                Storage::disk('public')->delete('images/property-types' . $type->photo);
            }
        }

        $type->name = $request->name;
        $type->photo = $imageName;
        if ($type->save()) return redirect()->route('property-types.index')->with('status', 'Type updated successfully.');
        return redirect()->route('property-types.index')->with('status', 'Failed to update type.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        /** @var \App\Models\User */
        $user = Auth::user();
        if (!$user->hasRole('admin')) return redirect()->back()->with('status', 'You don`t have access to this page!!!');
        $property_type = property_type::findOrFail($id);
        if ($property_type->delete()) return redirect()->back()->with('status', 'Property Type deleted successfully.');
        return redirect()->back()->with('status', 'Failed to delete property type');
    }
}
