<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSellerActive;
use App\Http\Requests\UpdateSellerBankDetails;
use App\Http\Requests\UpdateSellerCardDetails;
use App\Http\Resources\SellerResource;
use App\Http\Resources\SlideResource;
use App\Models\Profile;
use App\Models\SellerBankDetails;
use App\Repositories\Interfaces\ISellerRepository;
use App\Repositories\Interfaces\IUserRepository;
use App\Services\Interfaces\ISellerService;
use Illuminate\Http\Request;

class SellerController extends ApiController
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
    public function index(Request $request)
    {
        $slides = $this->sellerRepository->getPaginated(
            $request->integer('limit'),
            $request->string('sortBy'),
            $request->boolean('sortAsc') === true ? 'asc' : 'desc',
            ['name' => $request->get('searchText')]
        );

        return $this->sendPaginatedResponse($slides, SellerResource::collection($slides));
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
     * @param UpdateSellerActive $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleActive(UpdateSellerActive $request) {
        $result = Profile::whereId($request->integer('sellerId'))->update(['active' => $request->boolean('active')]);

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
