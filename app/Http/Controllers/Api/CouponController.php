<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\SearchRequest;
use App\Http\Requests\StoreCouponRequest;
use App\Http\Resources\CouponResource;
use App\Repositories\Interfaces\ICouponRepository;
use App\Services\Interfaces\ICouponService;
use Illuminate\Http\Request;

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
    public function index(SearchRequest $request)
    {
        $coupons = $this->couponRepository->getPaginated(
            $request->integer('limit'),
            $request->string('sortBy'),
            $request->string('sortDir'),
            ['name' => $request->get('searchText')]
        );

        return $this->sendPaginatedResponse($coupons, CouponResource::collection($coupons));
    }

    /**
     * @param StoreCouponRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCouponRequest $request)
    {
        $result = $this->couponService->createCoupon($request->all());

        if (!$result) {
            return $this->error('Unable to create Coupon');
        }

        return $this->success($result, 'Coupon created');

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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $result = $this->couponService->updateCoupon($request->except(['_token', '_method']), $id);

        if (!$result) {
            return $this->error('Unable to update Coupon');
        }

        return $this->success($result, 'Coupon updated');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = $this->couponService->deleteCoupon($id);

        if (!$result) {
            return $this->error('Unable to delete Coupon');
        }

        return $this->success($result, 'Coupon deleted');
    }
}
