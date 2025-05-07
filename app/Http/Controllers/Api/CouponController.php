<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Coupon\CreateCoupon;
use App\Actions\Coupon\DeleteCoupon;
use App\Actions\Coupon\UpdateCoupon;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\StoreCouponRequest;
use App\Http\Resources\CouponResource;
use App\Repositories\Interfaces\ICouponRepository;
use Illuminate\Http\Request;

class CouponController extends ApiController
{
    public function __construct(
        private readonly ICouponRepository $couponRepository,
    ) {}

    /**
     * @param  Request  $searchRequest
     */
    public function index(SearchRequest $searchRequest): \Illuminate\Http\JsonResponse
    {
        $coupons = $this->couponRepository->getPaginated(
            $searchRequest->integer('limit'),
            $searchRequest->string('sortBy'),
            $searchRequest->string('sortDir'),
            ['name' => $searchRequest->get('searchText')]
        );

        return $this->sendPaginatedResponse($coupons, CouponResource::collection($coupons));
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCouponRequest $storeCouponRequest, CreateCoupon $createCoupon)
    {
        $coupon = $createCoupon->handle($storeCouponRequest->all());

        if (! $coupon) {
            return $this->error('Unable to create Coupon');
        }

        return $this->success($coupon, 'Coupon created');

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
    public function update(Request $request, int $id, UpdateCoupon $updateCoupon)
    {
        $result = $updateCoupon->handle($request->except(['_token', '_method']), $id);

        if (! $result) {
            return $this->error('Unable to update Coupon');
        }

        return $this->success($result, 'Coupon updated');
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id, DeleteCoupon $deleteCoupon)
    {
        $result = $deleteCoupon->handle($id);

        if (! $result) {
            return $this->error('Unable to delete Coupon');
        }

        return $this->success($result, 'Coupon deleted');
    }
}
