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
    public function __construct(private IAttributeRepository $attributeRepository) {}

    /**
     * @param  Request  $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Http\JsonResponse|object
     *
     * @throws \Exception
     */
    public function index(SearchRequest $request)
    {
        $attributes = $this->attributeRepository->getPaginated(
            $request->integer('limit'),
            $request->string('sortBy'),
            $request->string('sortDir'),
            ['name' => $request->get('searchText')]
        );

        return $this->sendPaginatedResponse($attributes, AttributeResource::collection($attributes));
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAttributeRequest $request, CreateAttribute $createAttribute)
    {
        $result = $createAttribute->handle($request->all());

        if (! $result) {
            return $this->error('Unable to create Attribute');
        }

        return $this->success($result, 'Attribute created');

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
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAttributeRequest $request, $id, UpdateAttribute $updateAttribute)
    {
        $result = $updateAttribute->handle($request->except(['_token', '_method']), $id);

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
