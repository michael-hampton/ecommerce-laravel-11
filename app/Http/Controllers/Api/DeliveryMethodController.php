<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\SearchRequest;
use App\Http\Requests\StoreDeliveryMethodRequest;
use App\Http\Requests\UpdateDeliveryMethodRequest;
use App\Http\Resources\DeliveryCountryResource;
use App\Http\Resources\DeliveryMethodResource;
use App\Repositories\DeliveryMethodRepository;
use App\Repositories\Interfaces\ICountryRepository;
use App\Services\Interfaces\IDeliveryMethodService;
use Illuminate\Http\Request;

class DeliveryMethodController extends ApiController
{
    public function __construct(
        private IDeliveryMethodService $deliveryMethodService, 
        private ICountryRepository $countryRepository,
        private DeliveryMethodRepository $deliveryMethodRepository,
    ) {

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(SearchRequest $request)
    {
        $countries = $this->countryRepository->setRequiredRelationships(['deliveryMethods'])->getPaginated(
            $request->integer('limit'),
            $request->string('sortBy'),
            $request->string('sortDir'),
            ['name' => $request->get('searchText'), 'shipping_active' => true]
        );

        return $this->sendPaginatedResponse($countries, DeliveryCountryResource::collection($countries));
    }


    /**
     * @param StoreDeliveryMethodRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDeliveryMethodRequest $request)
    {
        $result = $this->deliveryMethodService->createDeliveryMethod($request->all());

        if (!$result) {
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
     * @param UpdateDeliveryMethodRequest $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDeliveryMethodRequest $request, $id)
    {
        $result = $this->deliveryMethodService->updateDeliveryMethod($request->all(), $id);

        if (!$result) {
            return $this->error('Unable to update Delivery Method');
        }

        return $this->success($result, 'Delivery Method updated');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $result = $this->deliveryMethodService->deleteDeliveryMethod($id);

        if (!$result) {
            return $this->error('Unable to create Delivery Method');
        }

        return $this->success($result, 'Delivery Method deleted');

    }
}
