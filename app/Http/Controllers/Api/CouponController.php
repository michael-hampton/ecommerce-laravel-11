<?php



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
        private ICouponRepository $couponRepository,
    ) {}

    /**
     * @param  Request  $request
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
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCouponRequest $request, CreateCoupon $createCoupon)
    {
        $result = $createCoupon->handle($request->all());

        if (! $result) {
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, UpdateCoupon $updateCoupon)
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
    public function destroy($id, DeleteCoupon $deleteCoupon)
    {
        $result = $deleteCoupon->handle($id);

        if (! $result) {
            return $this->error('Unable to delete Coupon');
        }

        return $this->success($result, 'Coupon deleted');
    }
}
