<?php

namespace App\Http\Controllers\Api;

use App\Actions\Courier\ActivateCourier;
use App\Actions\Courier\CreateCourier;
use App\Actions\Courier\DeleteCourier;
use App\Actions\Courier\UpdateCourier;
use App\Http\Requests\CreateCourierRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\UpdateCourierRequest;
use App\Http\Resources\CourierResource;
use App\Repositories\CourierRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CourierController extends ApiController
{
    public function __construct(private readonly CourierRepository $courierRepository)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(SearchRequest $searchRequest): \Illuminate\Http\JsonResponse
    {
       $couriers = $this->courierRepository->setRequiredRelationships(['country'])->getPaginatedWithFilters(
            $searchRequest->integer('limit'),
            $searchRequest->string('sortBy'),
            $searchRequest->string('sortDir'),
            $searchRequest->array('searchFilters')
        );

        return $this->sendPaginatedResponse($couriers, CourierResource::collection($couriers));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCourierRequest $createCourierRequest, CreateCourier $createCourier): JsonResponse
    {
        $courier = $createCourier->handle($createCourierRequest->all());

        if (!$courier) {
            return $this->error('Unable to create Courier');
        }

        return $this->success($courier, 'Courier created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): void
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourierRequest $updateCourierRequest, string $id, UpdateCourier $updateCourier): JsonResponse
    {
        $result = $updateCourier->handle($updateCourierRequest->all(), $id);

        if (!$result) {
            return $this->error('Unable to update Courier');
        }

        return $this->success($result, 'Courier updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, DeleteCourier $deleteCourier): JsonResponse
    {
        $result = $deleteCourier->handle($id);

        if (!$result) {
            return $this->error('Unable to delete Courier');
        }

        return $this->success($result, 'Courier deleted');
    }

    public function toggleActive(int $id, ActivateCourier $activateCourier): JsonResponse
    {
        $result = $activateCourier->handle($id);

        if (!$result) {
            return $this->error('Unable to update Courier');
        }

        return $this->success($result, 'Courier updated');
    }
}
