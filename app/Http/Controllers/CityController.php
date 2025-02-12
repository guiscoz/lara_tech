<?php

namespace App\Http\Controllers;

use App\Models\City;

class CityController extends Controller
{
    public function getCities($state_id)
    {
        $cities = City::where('state_id', $state_id)->get();
        return response()->json($cities);
    }
}
