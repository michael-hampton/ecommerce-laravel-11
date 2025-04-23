<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Http\Resources\AttributeValueResource;
use App\Http\Resources\BrandResource;
use App\Repositories\Interfaces\IBrandRepository;
use App\Services\Interfaces\IBrandService;
use Illuminate\Http\Request;
use Psy\Util\Str;
use Yajra\DataTables\Facades\DataTables;

class BrandController extends ApiController
{
    public function __construct(private IBrandService $brandService, private IBrandRepository $brandRepository) {

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $brands = $this->brandRepository->getPaginated(
            $request->integer('limit'),
            $request->string('sortBy'),
            $request->boolean('sortAsc') === true ? 'asc' : 'desc',
            ['name' => $request->get('searchText')]
        );

        return $this->sendPaginatedResponse($brands, BrandResource::collection($brands));
    }


    /**
     * @param StoreBrandRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreBrandRequest $request)
    {
        $result = $this->brandService->createBrand($request->all());

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
     * @param UpdateBrandRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateBrandRequest $request, $id)
    {
        $result = $this->brandService->updateBrand($request->except(['_token', '_method']), $id);

        return response()->json($result);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        $result = $this->brandService->deleteBrand($id);

        return response()->json($result);

    }
}
