<?php

namespace App\Http\Controllers\Api\Seller;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\UpdateSellerActive;
use App\Http\Resources\SellerResource;
use App\Models\Profile;
use App\Repositories\Interfaces\ISellerRepository;
use App\Repositories\Interfaces\IUserRepository;
use App\Services\Interfaces\ISellerService;
use Illuminate\Http\Request;

class SellerController extends ApiController
{
    public function __construct(
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

        if (!$result) {
            return $this->error('Unable to create Seller');
        }

        return $this->success($result, 'Seller created');
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

        return response()->json(SellerResource::make($result));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $result = $this->sellerService->updateSeller($request->all(), $id);

        if (!$result) {
            return $this->error('Unable to update Seller');
        }

        return $this->success($result, 'Seller updated');
    }

    /**
     * @param UpdateSellerActive $request
     * @return \Illuminate\Http\Response
     */
    public function toggleActive(UpdateSellerActive $request) {
        $result = Profile::whereId($request->integer('sellerId'))->update(['active' => $request->boolean('active')]);

        if (!$result) {
            return $this->error('Unable to create Seller');
        }

        return $this->success($result, 'Seller deleted');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = $this->sellerService->deleteSeller($id);

        if (!$result) {
            return $this->error('Unable to create Seller');
        }

        return $this->success($result, 'Seller deleted');
    }
}
