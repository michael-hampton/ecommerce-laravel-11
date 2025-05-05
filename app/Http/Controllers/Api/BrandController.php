<?php

namespace App\Http\Controllers\Api;

use App\Actions\Brand\ActivateBrand;
use App\Actions\Brand\CreateBrand;
use App\Actions\Brand\DeleteBrand;
use App\Actions\Brand\UpdateBrand;
use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Http\Resources\AttributeValueResource;
use App\Http\Resources\BrandResource;
use App\Repositories\Interfaces\IBrandRepository;
use Illuminate\Http\Request;
use Psy\Util\Str;
use Yajra\DataTables\Facades\DataTables;

class BrandController extends ApiController
{
    public function __construct(private IBrandRepository $brandRepository) {

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(SearchRequest $request)
    {
        $brands = $this->brandRepository->getPaginated(
            $request->integer('limit'),
            $request->string('sortBy'),
            $request->string('sortDir'),
            ['name' => $request->get('searchText'), 'ignore_active' => true]
        );

        return $this->sendPaginatedResponse($brands, BrandResource::collection($brands));
    }


    /**
     * @param StoreBrandRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBrandRequest $request, CreateBrand $createBrand)
    {
        $result = $createBrand->handle($request->all());

        if (!$result) {
            return $this->error('Unable to create Brand');
        }

        return $this->success($result, 'Brand created');
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
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBrandRequest $request, $id, UpdateBrand $updateBrand)
    {
        $result = $updateBrand->handle($request->except(['_token', '_method']), $id);

        if (!$result) {
            return $this->error('Unable to update Brand');
        }

        return $this->success($result, 'Brand updated');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id, DeleteBrand $deleteBrand)
    {
        $result = $deleteBrand->handle($id);

        if (!$result) {
            return $this->error('Unable to delete Brand');
        }

        return $this->success($result, 'Brand deleted');

    }

    public function toggleActive(int $id, ActivateBrand $activateBrand)
    {
       $result = $activateBrand->handle($id);

       if (!$result) {
        return $this->error('Unable to update Brand');
    }

    return $this->success($result, 'Brand updated');
    }
}
