<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\SearchRequest;
use App\Http\Requests\StoreAttributeRequest;
use App\Http\Requests\UpdateAttributeRequest;
use App\Http\Resources\AttributeResource;
use App\Repositories\Interfaces\IAttributeRepository;
use App\Services\Interfaces\IAttributeService;
use Illuminate\Http\Request;
use Psy\Util\Str;
use Yajra\DataTables\Facades\DataTables;

class AttributeController extends ApiController
{
    public function __construct(private IAttributeService $attributeService, private IAttributeRepository $attributeRepository)
    {

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Http\JsonResponse|object
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
     * @param StoreAttributeRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAttributeRequest $request)
    {
        $result = $this->attributeService->createAttribute($request->all());

        if (!$result) {
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
     * @param UpdateAttributeRequest $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAttributeRequest $request, $id)
    {
        $result = $this->attributeService->updateAttribute($request->except(['_token', '_method']), $id);

        if (!$result) {
            return $this->error('Unable to update Attribute');
        }

        return $this->success($result, 'Attribute updated');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $result = $this->attributeService->deleteAttribute($id);

        if (!$result) {
            return $this->error('Unable to delete Attribute');
        }

        return $this->success($result, 'Attribute deleted');
    }
}
