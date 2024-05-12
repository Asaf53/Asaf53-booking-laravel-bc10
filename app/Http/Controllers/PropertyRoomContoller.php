<?php

namespace App\Http\Controllers;

use App\Models\property_room_images;
use App\Models\property_rooms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PropertyRoomContoller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /** @var \App\Models\User */
        $user = Auth::user();
        if (!$user->hasRole('admin|partner')) return redirect()->back()->with('status', 'You don`t have access to this page!!!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        /** @var \App\Models\User */
        $user = Auth::user();
        if (!$user->hasRole('partner')) return redirect()->back()->with('status', 'You don`t have access to this page!!!');

        return view('property.rooms.create');
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
            'capacity.*' => 'required',
            'price.*' => 'required',
            'number.*' => 'required',
            'singel_beds.*' => 'required',
            'double_beds.*' => 'required',
        ]);

        foreach ($request->capacity as $index => $cap) {
            $property_room = new property_rooms();
            $property_room->property_id = $request->property_id;
            $property_room->capacity = $cap;
            $property_room->price = $request->price[$index];
            $property_room->number = $request->number[$index];
            $property_room->singel_beds = $request->singel_beds[$index];
            $property_room->double_beds = $request->double_beds[$index];

            // dd($property_room->all());
            $property_room->save();
        }

        return redirect()->route('properties.index')->with('status', 'Rooms added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        /** @var \App\Models\User */
        $user = Auth::user();
        if (!$user->hasRole('admin|partner|client')) return redirect()->back()->with('status', 'You don`t have access to this page!!!');

        if ($user->hasRole('admin|partner')) {
            $property_rooms = property_rooms::where('property_id', '=', $id)->get();
            return view('property.rooms.index', ['property_rooms' => $property_rooms]);
        }
        if ($user->hasRole('client')) {
            $property_room = property_rooms::findOrFail($id);
            $property_images = $property_room->property->property_images;
            return view('property.rooms.show', ['property_room' => $property_room, 'property_images' => $property_images]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        /** @var \App\Models\User */
        $user = Auth::user();
        if (!$user->hasRole('admin|partner')) return redirect()->back()->with('status', 'You don`t have access to this page!!!');

        $property_rooms = property_rooms::findOrFail($id);
        return view('property.rooms.edit', ['property_rooms' => $property_rooms]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        /** @var \App\Models\User */
        $user = Auth::user();
        if (!$user->hasRole('admin|partner')) return redirect()->back()->with('status', 'You don`t have access to this page!!!');

        $request->validate([
            'capacity' => 'required',
            'price' => 'required',
            'number' => 'required',
            'singel_beds' => 'required',
            'double_beds' => 'required',
        ]);
        $property_room = property_rooms::findOrFail($id);
        $property_room->property_id = $request->property_id;
        $property_room->capacity = $request->capacity;
        $property_room->price = $request->price;
        $property_room->number = $request->number;
        $property_room->singel_beds = $request->singel_beds;
        $property_room->double_beds = $request->double_beds;
        $property_room->save();

        return redirect()->route('properties.index')->with('status', 'Rooms updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        /** @var \App\Models\User */
        $user = Auth::user();
        if (!$user->hasRole('admin|partner')) return redirect()->back()->with('status', 'You don`t have access to this page!!!');

        $property_room = property_rooms::findOrFail($id);
        if ($property_room->delete()) return redirect()->back()->with('status', 'Rooms deleted successfully.');
        return redirect()->back()->with('status', 'Failed to delete rooms');
    }
}
