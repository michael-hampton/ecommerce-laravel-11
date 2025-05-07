<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Attribute\CreateAttribute;
use App\Actions\Attribute\DeleteAttribute;
use App\Actions\Attribute\UpdateAttribute;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\StoreAttributeRequest;
use App\Http\Requests\UpdateAttributeRequest;
use App\Http\Resources\AttributeResource;
use App\Repositories\Interfaces\IAttributeRepository;
use Illuminate\Http\Request;

class AttributeController extends ApiController
{
    public function __construct(private readonly IAttributeRepository $attributeRepository) {}

    /**
     * @param  Request  $searchRequest
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Http\JsonResponse|object
     *
     * @throws \Exception
     */
    public function index(SearchRequest $searchRequest): \Illuminate\Http\JsonResponse
    {
        $attributes = $this->attributeRepository->getPaginated(
            $searchRequest->integer('limit'),
            $searchRequest->string('sortBy'),
            $searchRequest->string('sortDir'),
            ['name' => $searchRequest->get('searchText')]
        );

        return $this->sendPaginatedResponse($attributes, AttributeResource::collection($attributes));
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAttributeRequest $storeAttributeRequest, CreateAttribute $createAttribute)
    {
        $productAttribute = $createAttribute->handle($storeAttributeRequest->all());

        if (! $productAttribute) {
            return $this->error('Unable to create Attribute');
        }

        return $this->success($productAttribute, 'Attribute created');

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
    public function update(UpdateAttributeRequest $updateAttributeRequest, int $id, UpdateAttribute $updateAttribute)
    {
        $result = $updateAttribute->handle($updateAttributeRequest->except(['_token', '_method']), $id);

        if (! $result) {
            return $this->error('Unable to update Attribute');
        }

        return $this->success($result, 'Attribute updated');
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id, DeleteAttribute $deleteAttribute)
    {
        $result = $deleteAttribute->handle($id);

        if (! $result) {
            return $this->error('Unable to delete Attribute');
        }

        return $this->success($result, 'Attribute deleted');
    }
}
