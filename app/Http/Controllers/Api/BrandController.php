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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $brands = $this->brandRepository->getPaginated(
            $request->integer('limit'),
            $request->string('sortBy'),
            $request->boolean('sortAsc') === true ? 'asc' : 'desc',
        );

        return $this->sendPaginatedResponse($brands, BrandResource::collection($brands));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.brands.create');
    }

    /**
     * @param StoreBrandRequest $request
     * @return void
     */
    public function store(StoreBrandRequest $request)
    {
        $result = $this->brandService->createBrand($request->all());

        return redirect()->route('admin.brands')->with('success', 'Brand created successfully.');
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
        $brand = $this->brandRepository->getById($id);
        return view('admin.brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBrandRequest $request, $id)
    {
        $result = $this->brandService->updateBrand($request->except(['_token', '_method']), $id);

        return redirect()->route('admin.brands')->with('success', 'Brand updated successfully.');
    }

    /**
     * @param int $id
     * @return void
     */
    public function destroy(int $id)
    {
        $result = $this->brandService->deleteBrand($id);

        return redirect()->route('admin.brands')->with('success', 'Brand deleted successfully.');
    }
}
