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
    )
    {

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $coupons = $this->couponRepository->getPaginated(
            $request->integer('limit'),
            $request->string('sortBy'),
            $request->boolean('sortAsc') === true ? 'asc' : 'desc',
            ['name' => $request->get('searchText')]
        );

        return $this->sendPaginatedResponse($coupons, CouponResource::collection($coupons));
    }

    /**
     * @param StoreCouponRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreCouponRequest $request)
    {
        $result = $this->couponService->createCoupon($request->all());
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
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $result = $this->couponService->updateCoupon($request->except(['_token', '_method']), $id);

        return response()->json($result);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $result = $this->couponService->deleteCoupon($id);

        return response()->json($result);
    }
}
