<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCouponRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CouponResource;
use App\Repositories\Interfaces\IBrandRepository;
use App\Repositories\Interfaces\ICategoryRepository;
use App\Repositories\Interfaces\ICouponRepository;
use App\Services\Interfaces\ICouponService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class CouponController extends ApiController
{
    public function __construct(
        private ICouponRepository $couponRepository,
        private ICouponService $couponService,
        private ICategoryRepository $categoryRepository,
        private IBrandRepository $brandRepository,
    )
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $coupons = $this->couponRepository->getPaginated(
            $request->integer('limit'),
            $request->string('sortBy'),
            $request->boolean('sortAsc') === true ? 'asc' : 'desc',
        );

        return $this->sendPaginatedResponse($coupons, CouponResource::collection($coupons));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->categoryRepository->getAll(null, 'name', 'asc');
        $brands = $this->brandRepository->getAll(null, 'name', 'asc');
        return view('admin.coupons.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCouponRequest $request)
    {
        $result = $this->couponService->createCoupon($request->all());

        return redirect()->route('admin.coupons')->with('success', 'Coupon created successfully.');
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
    public function edit($id)
    {
        $coupon = $this->couponRepository->getById($id);
        $categories = $this->categoryRepository->getAll(null, 'name', 'asc');
        $brands = $this->brandRepository->getAll(null, 'name', 'asc');
        return view('admin.coupons.edit', compact('coupon', 'categories', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $result = $this->couponService->updateCoupon($request->except(['_token', '_method']), $id);

        return redirect()->route('admin.coupons')->with('success', 'Coupon updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = $this->couponService->deleteCoupon($id);

        return redirect()->route('admin.coupons')->with('success', 'Coupon deleted successfully.');
    }
}
