<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
        private IAttributeRepository $attributeRepository,
        private IAttributeValueService $attributeValueService,
        private IAttributeValueRepository $attributeValueRepository
    ) {

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Http\JsonResponse|object
     * @throws \Exception
     */
    public function index(Request $request)
    {
        $attributeValues = $this->attributeValueRepository->getPaginated(
            $request->integer('limit'),
            $request->string('sortBy'),
            $request->boolean('sortAsc') === true ? 'asc' : 'desc',
        );

        return $this->sendPaginatedResponse($attributeValues, AttributeValueResource::collection($attributeValues));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $attributes = $this->attributeRepository->getAll(null, 'id', 'desc');
        return view('admin.attribute-values.create', compact('attributes'));
    }

    /**
     * @param StoreAttributeValueRequest $request
     * @return void
     */
    public function store(StoreAttributeValueRequest $request)
    {
        $result = $this->attributeValueService->createAttributeValue($request->except(['_token', '_method']));

        return redirect()->route('admin.attributeValues')->with('success', 'AttributeValue created successfully.');
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $attributes = $this->attributeRepository->getAll(null, 'id', 'desc');
        $attributeValue = $this->attributeValueRepository->getById($id);
        return view('admin.attribute-values.edit', compact('attributeValue', 'attributes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAttributeValueRequest $request, $id)
    {
        $result = $this->attributeValueService->updateAttributeValue($request->except(['_token', '_method']), $id);

        return redirect()->route('admin.attributeValues')->with('success', 'AttributeValue updated successfully.');
    }

    /**
     * @param int $id
     * @return void
     */
    public function destroy(int $id)
    {
        $result = $this->attributeValueService->deleteAttributeValue($id);

        return redirect()->route('admin.attributeValues')->with('success', 'AttributeValue deleted successfully.');
    }
}
