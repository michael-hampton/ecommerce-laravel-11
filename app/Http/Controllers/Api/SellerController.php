<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ISellerRepository;
use App\Repositories\Interfaces\IUserRepository;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    function __construct(private ISellerRepository $sellerRepository, private IUserRepository $userRepository)
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $result = $this->sellerRepository->getCollectionByColumn(auth('sanctum')->user()->id, 'user_id', 1)->first();

        if (empty($result)) {
            $result = $this->userRepository->getById(auth('sanctum')->user()->id);
        }

        return response()->json($result);
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
