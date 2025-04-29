<?php

namespace App\Http\Controllers\Api;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends ApiController
{
    public function index()
    {
        $countries = Country::orderBy('name', 'asc')->get();

        return response()->json($countries);
    }
}
