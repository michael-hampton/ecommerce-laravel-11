<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourierResource;
use App\Repositories\CourierRepository;
use App\Repositories\Interfaces\ICourierRepository;
use Illuminate\Http\Request;

class CourierController extends Controller
{
    public function __construct(private readonly CourierRepository $courierRepository)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(
            CourierResource::collection($this->courierRepository->getAll(null, 'name', 'asc'))
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
