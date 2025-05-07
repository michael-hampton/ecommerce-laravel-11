<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Brand\ActivateBrand;
use App\Actions\Brand\CreateBrand;
use App\Actions\Brand\DeleteBrand;
use App\Actions\Brand\UpdateBrand;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Http\Resources\BrandResource;
use App\Repositories\Interfaces\IBrandRepository;
use Illuminate\Http\Request;

class BrandController extends ApiController
{
    public function __construct(private IBrandRepository $brandRepository) {}

    /**
     * @param Request $searchRequest
     */
    public function index(SearchRequest $searchRequest): \Illuminate\Http\JsonResponse
    {
        $brands = $this->brandRepository->getPaginated(
            $searchRequest->integer('limit'),
            $searchRequest->string('sortBy'),
            $searchRequest->string('sortDir'),
            ['name' => $searchRequest->get('searchText'), 'ignore_active' => true]
        );

        return $this->sendPaginatedResponse($brands, BrandResource::collection($brands));
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBrandRequest $storeBrandRequest, CreateBrand $createBrand)
    {
        $brand = $createBrand->handle($storeBrandRequest->all());

        if (! $brand) {
            return $this->error('Unable to create Brand');
        }

        return $this->success($brand, 'Brand created');
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
    public function update(UpdateBrandRequest $updateBrandRequest, int $id, UpdateBrand $updateBrand)
    {
        $result = $updateBrand->handle($updateBrandRequest->except(['_token', '_method']), $id);

        if (! $result) {
            return $this->error('Unable to update Brand');
        }

        return $this->success($result, 'Brand updated');
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id, DeleteBrand $deleteBrand)
    {
        $result = $deleteBrand->handle($id);

        if (! $result) {
            return $this->error('Unable to delete Brand');
        }

        return $this->success($result, 'Brand deleted');

    }

    public function toggleActive(int $id, ActivateBrand $activateBrand)
    {
        $result = $activateBrand->handle($id);

        if (! $result) {
            return $this->error('Unable to update Brand');
        }

        return $this->success($result, 'Brand updated');
    }
}
