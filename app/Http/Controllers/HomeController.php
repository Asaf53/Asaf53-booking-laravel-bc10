<?php

namespace App\Http\Controllers;

use App\Models\city;
use App\Models\country;
use App\Models\property_type;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    function index() {
        $countries = country::all();
        $types = property_type::all();
        // dd($types);
        return view('home', ['countries' => $countries, 'types' => $types]);
    }

    public function city($id)
    {
        $cities = city::where('country_id', '=', $id)->pluck('name', 'id');
        return json_encode($cities);
    }
}
