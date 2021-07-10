<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function getCountries()
    {
        $countries = array_values(config('constants.country_codes'));
        return response()->json($countries);
    }
}
