<?php

namespace App\Http\Controllers\Api;

use App\Actions\AttributeValue\CreateAttributeValue;
use App\Actions\AttributeValue\DeleteAttributeValue;
use App\Actions\AttributeValue\UpdateAttributeValue;
use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\StoreAttributeValueRequest;
use App\Http\Requests\UpdateAttributeValueRequest;
use App\Http\Resources\AttributeValueResource;
use App\Repositories\Interfaces\IAttributeValueRepository;
use Illuminate\Http\Request;
use Psy\Util\Str;
use Yajra\DataTables\Facades\DataTables;

class AttributeValueController extends ApiController
{
    public function __construct(
        private IAttributeValueRepository $attributeValueRepository
    ) {

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(SearchRequest $request)
    {
        $attributeValues = $this->attributeValueRepository->getPaginated(
            $request->integer('limit'),
            $request->string('sortBy'),
            $request->string('sortDir'),
            ['name' => $request->get('searchText')]
        );

        return $this->sendPaginatedResponse($attributeValues, AttributeValueResource::collection($attributeValues));
    }

    /**
     * @param StoreAttributeValueRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAttributeValueRequest $request, CreateAttributeValue $createAttributeValue)
    {
        $result = $createAttributeValue->handle($request->except(['_token', '_method']));

        if (!$result) {
            return $this->error('Unable to create Attribute Value');
        }

        return $this->success($result, 'Attribute Value created');
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
     * @param UpdateAttributeValueRequest $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAttributeValueRequest $request, $id, UpdateAttributeValue $updateAttributeValue)
    {
        $result = $updateAttributeValue->handle($request->except(['_token', '_method']), $id);

        if (!$result) {
            return $this->error('Unable to update Attribute Value');
        }

        return $this->success($result, 'Attribute Value updated');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id, DeleteAttributeValue $deleteAttributeValue)
    {
        $result = $deleteAttributeValue->handle($id);

        if (!$result) {
            return $this->error('Unable to create Attribute Value');
        }

        return $this->success($result, 'Attribute Value deleted');
    }
}
