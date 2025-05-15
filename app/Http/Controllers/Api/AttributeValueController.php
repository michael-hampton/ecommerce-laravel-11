<?php

namespace App\Http\Controllers\Api;

use App\Actions\AttributeValue\CreateAttributeValue;
use App\Actions\AttributeValue\DeleteAttributeValue;
use App\Actions\AttributeValue\UpdateAttributeValue;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\StoreAttributeValueRequest;
use App\Http\Requests\UpdateAttributeValueRequest;
use App\Http\Resources\AttributeValueResource;
use App\Repositories\Interfaces\IAttributeValueRepository;
use Illuminate\Http\Request;

class AttributeValueController extends ApiController
{
    public function __construct(
        private readonly IAttributeValueRepository $attributeValueRepository
    ) {}

    /**
     * @param  Request  $searchRequest
     */
    public function index(SearchRequest $searchRequest): \Illuminate\Http\JsonResponse
    {
         $attributeValues = $this->attributeValueRepository->setRequiredRelationships(['attribute'])->getPaginatedWithFilters(
            $searchRequest->integer('limit'),
            $searchRequest->string('sortBy'),
            $searchRequest->string('sortDir'),
            $searchRequest->array('searchFilters')
        );

        return $this->sendPaginatedResponse($attributeValues, AttributeValueResource::collection($attributeValues));
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAttributeValueRequest $storeAttributeValueRequest, CreateAttributeValue $createAttributeValue)
    {
        $attributeValue = $createAttributeValue->handle($storeAttributeValueRequest->except(['_token', '_method']));

        if (! $attributeValue) {
            return $this->error('Unable to create Attribute Value');
        }

        return $this->success($attributeValue, 'Attribute Value created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id): void
    {
        //
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAttributeValueRequest $updateAttributeValueRequest, int $id, UpdateAttributeValue $updateAttributeValue)
    {
        $result = $updateAttributeValue->handle($updateAttributeValueRequest->except(['_token', '_method']), $id);

        if (! $result) {
            return $this->error('Unable to update Attribute Value');
        }

        return $this->success($result, 'Attribute Value updated');
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id, DeleteAttributeValue $deleteAttributeValue)
    {
        $result = $deleteAttributeValue->handle($id);

        if (! $result) {
            return $this->error('Unable to create Attribute Value');
        }

        return $this->success($result, 'Attribute Value deleted');
    }
}
