<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Repositories\Interfaces\IBrandRepository;
use App\Services\BrandService;
use App\Services\Interfaces\IBrandService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Psy\Util\Str;

class BrandController extends Controller
{
    public function __construct(private IBrandService $brandService, private IBrandRepository $brandRepository) {

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = $this->brandRepository->getPaginated(10, 'id', 'desc');
        return view('admin.brands.index', compact('brands'));
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
