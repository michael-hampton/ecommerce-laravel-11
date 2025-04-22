<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Http\Resources\BrandResource;
use App\Repositories\Interfaces\IBrandRepository;
use App\Services\Interfaces\IBrandService;
use Illuminate\Http\Request;
use Psy\Util\Str;
use Yajra\DataTables\Facades\DataTables;

class BrandController extends Controller
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
        $brands = $this->brandRepository->getAll(null, 'id', 'desc');
        $collection = BrandResource::collection($brands)->resolve();

        if ($request->ajax()) {
            return DataTables::of($collection)->filter(function ($instance) use ($request) {
                if (!empty($request->get('search'))) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        if (\Illuminate\Support\Str::contains(Str::lower($row['name']), Str::lower($request->get('search')))) {
                            return true;
                        }
                        return false;

                    });

                };
            })->make(true);
        }

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
