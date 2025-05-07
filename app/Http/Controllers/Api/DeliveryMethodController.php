<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\DeliveryMethod\CreateDeliveryMethod;
use App\Actions\DeliveryMethod\DeleteDeliveryMethod;
use App\Actions\DeliveryMethod\UpdateDeliveryMethod;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\StoreDeliveryMethodRequest;
use App\Http\Requests\UpdateDeliveryMethodRequest;
use App\Http\Resources\DeliveryCountryResource;
use App\Http\Resources\DeliveryMethodResource;
use App\Repositories\DeliveryMethodRepository;
use App\Repositories\Interfaces\ICountryRepository;
use Illuminate\Http\Request;

class DeliveryMethodController extends ApiController
{
    public function __construct(
        private readonly ICountryRepository $countryRepository,
        private readonly DeliveryMethodRepository $deliveryMethodRepository,
    ) {}

    /**
     * @param Request $searchRequest
     */
    public function index(SearchRequest $searchRequest): \Illuminate\Http\JsonResponse
    {
        $countries = $this->countryRepository->setRequiredRelationships(['deliveryMethods'])->getPaginated(
            $searchRequest->integer('limit'),
            $searchRequest->string('sortBy'),
            $searchRequest->string('sortDir'),
            ['name' => $searchRequest->get('searchText'), 'shipping_active' => true]
        );

        return $this->sendPaginatedResponse($countries, DeliveryCountryResource::collection($countries));
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDeliveryMethodRequest $storeDeliveryMethodRequest, CreateDeliveryMethod $createDeliveryMethod)
    {
        $result = $createDeliveryMethod->handle($storeDeliveryMethodRequest->all());

        if (! $result) {
            return $this->error('Unable to create Delivery Method');
        }

        return $this->success($result, 'Delivery Method created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $delivery = $this->deliveryMethodRepository->getAll(null, 'country_id', 'desc', ['country_id' => $id]);

        return response()->json(DeliveryMethodResource::collection($delivery));
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDeliveryMethodRequest $updateDeliveryMethodRequest, int $id, UpdateDeliveryMethod $updateDeliveryMethod)
    {
        $result = $updateDeliveryMethod->handle($updateDeliveryMethodRequest->all(), $id);

        if (! $result) {
            return $this->error('Unable to update Delivery Method');
        }

        return $this->success($result, 'Delivery Method updated');
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id, DeleteDeliveryMethod $deleteDeliveryMethod)
    {
        $result = $deleteDeliveryMethod->handle($id);

        if (! $result) {
            return $this->error('Unable to create Delivery Method');
        }

        return $this->success($result, 'Delivery Method deleted');

    }
}
