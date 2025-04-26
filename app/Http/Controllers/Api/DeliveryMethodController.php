<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreDeliveryMethodRequest;
use App\Http\Requests\UpdateDeliveryMethodRequest;
use App\Http\Resources\DeliveryCountryResource;
use App\Http\Resources\DeliveryMethodResource;
use App\Models\Country;
use App\Repositories\DeliveryMethodRepository;
use App\Repositories\Interfaces\ICountryRepository;
use App\Repositories\Interfaces\IDeliveryMethodRepository;
use App\Services\Interfaces\IDeliveryMethodService;
use Illuminate\Http\Request;

class DeliveryMethodController extends ApiController
{
    public function __construct(private IDeliveryMethodService $deliveryMethodService, private ICountryRepository $countryRepository) {

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $countries = $this->countryRepository->setRequiredRelationships(['deliveryMethods'])->getPaginated(
            $request->integer('limit'),
            $request->string('sortBy'),
            $request->boolean('sortAsc') === true ? 'asc' : 'desc',
            ['name' => $request->get('searchText'), 'shipping_active' => true]
        );

        return $this->sendPaginatedResponse($countries, DeliveryCountryResource::collection($countries));
    }


    /**
     * @param StoreDeliveryMethodRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreDeliveryMethodRequest $request)
    {
        $result = $this->deliveryMethodService->createDeliveryMethod($request->all());

        return response()->json($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * @param UpdateDeliveryMethodRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateDeliveryMethodRequest $request, $id)
    {
        $result = $this->deliveryMethodService->updateDeliveryMethod($request->all(), $id);

        return response()->json($result);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        $result = $this->deliveryMethodService->deleteDeliveryMethod($id);

        return response()->json($result);

    }
}
