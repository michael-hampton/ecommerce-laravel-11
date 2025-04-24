<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ISellerRepository;
use App\Repositories\Interfaces\IUserRepository;
use App\Services\Interfaces\ISellerService;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    function __construct(
        private ISellerRepository $sellerRepository,
        private IUserRepository $userRepository,
        private ISellerService $sellerService
    )
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
        $result = $this->sellerService->createSeller($request->all());

        return response()->json($result);
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
        $result = $this->sellerService->updateSeller($request->all(), $id);

        return response()->json($result);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = $this->sellerService->deleteSeller($id);

        return response()->json($result);
    }
}
