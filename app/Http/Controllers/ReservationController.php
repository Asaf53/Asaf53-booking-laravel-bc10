<?php

namespace App\Http\Controllers;

use App\Models\property_rooms;
use App\Models\reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /** @var \App\Models\User */
        $user = Auth::user();
        if (!$user->hasRole('client|partner')) return redirect()->back()->with('status', 'You don`t have access to this page!!!');
        if ($user->hasRole('client')) {
            $reservation = reservation::where('user_id', '=', $user->id)->get();
        } else {
            $userId = $user->id;
            $reservation = reservation::whereHas('property', function ($query) use ($userId) {
                $query->where('user_id', '=', $userId);
            })->get();
            // dd($reservation);
        }

        return view('reservation.index', ['reservation' => $reservation]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        request()->validate([
            'country_id' => 'required',
            'city_id' => 'required',
            'countAdults' => 'nullable',
            'countChild' => 'nullable',
            'daterange' => 'required',
        ]);
        $country_id = request()->query('country_id');
        $city_id = request()->query('city_id');
        $adult = request()->query('countAdults');
        $child = request()->query('countChild');
        $people = $adult + $child;
        $property_rooms = property_rooms::where('capacity', '>=', $people)->whereHas('property', function ($query) use ($country_id, $city_id) {
            $query->where('country_id', '=', $country_id);
            $query->where('city_id', $city_id);
        })->get();
        return view('reservation.create', ['property_rooms' => $property_rooms]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /** @var \App\Models\User */
        $user = Auth::user();
        if (!$user->hasRole('client|partner')) return redirect()->back()->with('status', 'You don`t have access to this page!!!');

        $dateRange = $request->daterange;
        $dateParts = explode('-', $dateRange);
        $startDate = trim($dateParts[0]);
        $endDate = trim($dateParts[1]);

        $startDateTime = Carbon::createFromFormat('m/d/Y', $startDate);
        $endDateTime = Carbon::createFromFormat('m/d/Y', $endDate);

        $formattedStartDate = $startDateTime->format('Y-m-d');
        $formattedEndDate = $endDateTime->format('Y-m-d');

        $intervalInDays = $startDateTime->diffInDays($endDateTime);

        $price = $request->price * $intervalInDays;
        reservation::create([
            'user_id' => $user->id,
            'property_id' => $request->property_id,
            'property_room_id' => $request->property_room_id,
            'country_id' => $request->country_id,
            'city_id' => $request->city_id,
            'address' => $request->address,
            'price' => $price,
            'check-in' => $formattedStartDate,
            'check-out' => $formattedEndDate,
            'people' => $request->adult + $request->child,
        ]);

        return redirect()->route('home')->with('status', 'Reserved successfully.');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        /** @var \App\Models\User */
        $user = Auth::user();
        if (!$user->hasRole('partner')) return redirect()->back()->with('status', 'You don`t have access to this page!!!');

        $reservation = reservation::findOrFail($id);
        if ($request->has('confirm')) {
            $reservation->status = 'confirmed';
            $status = 'confirmed';
        } elseif ($request->has('reject')) {
            $reservation->status = 'rejected';
            $status = 'reject';
        }

        if ($reservation->save()) return redirect()->back()->with('status', $status);
        return redirect()->back()->with('status', 'Failed to change status');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        /** @var \App\Models\User */
        $user = Auth::user();
        if (!$user->hasRole('partner')) return redirect()->back()->with('status', 'You don`t have access to this page!!!');

        $reservation = reservation::findOrFail($id);
        if ($reservation->delete()) return redirect()->back()->with('status', 'Reservation deleted successfully.');
        return redirect()->back()->with('status', 'Failed to delete Reservation');
    }
}
