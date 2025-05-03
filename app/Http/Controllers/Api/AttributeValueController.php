<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\StoreAttributeValueRequest;
use App\Http\Requests\UpdateAttributeValueRequest;
use App\Http\Resources\AttributeValueResource;
use App\Repositories\Interfaces\IAttributeRepository;
use App\Repositories\Interfaces\IAttributeValueRepository;
use App\Services\Interfaces\IAttributeValueService;
use Illuminate\Http\Request;
use Psy\Util\Str;
use Yajra\DataTables\Facades\DataTables;

class AttributeValueController extends ApiController
{
    public function __construct(
        private IAttributeValueService $attributeValueService,
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
            $request->boolean('sortAsc') === true ? 'asc' : 'desc',
            ['name' => $request->get('searchText')]
        );

        return $this->sendPaginatedResponse($attributeValues, AttributeValueResource::collection($attributeValues));
    }

    /**
     * @param StoreAttributeValueRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAttributeValueRequest $request)
    {
        $result = $this->attributeValueService->createAttributeValue($request->except(['_token', '_method']));

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
    public function update(UpdateAttributeValueRequest $request, $id)
    {
        $result = $this->attributeValueService->updateAttributeValue($request->except(['_token', '_method']), $id);

        if (!$result) {
            return $this->error('Unable to update Attribute Value');
        }

        return $this->success($result, 'Attribute Value updated');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $result = $this->attributeValueService->deleteAttributeValue($id);

        if (!$result) {
            return $this->error('Unable to create Attribute Value');
        }

        return $this->success($result, 'Attribute Value deleted');
    }
}
