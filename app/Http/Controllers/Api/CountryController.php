<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\Country;

class CountryController extends ApiController
{
    public function index()
    {
        $countries = Country::orderBy('name', 'asc')->get();

        return response()->json($countries);
    }
}
