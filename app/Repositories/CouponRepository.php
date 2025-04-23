<?php

namespace App\Repositories;

use App\Models\Coupon;
use App\Repositories\Interfaces\ICategoryRepository;
use App\Repositories\Interfaces\ICouponRepository;
use Illuminate\Database\Eloquent\Builder;

class CouponRepository extends BaseRepository implements ICouponRepository
{
    public function __construct(Coupon $coupon) {
        parent::__construct($coupon);
    }

    /**
     * @param array $searchParams
     * @return Builder
     */
    protected function applyFilters(array $searchParams = []): Builder
    {
        $query = $this->getQuery();

        $query->when(!empty($searchParams['expiry_date']), function (Builder $query) use ($searchParams) {
            $query->where('expires_at', '>=', $searchParams['expiry_date']);
        });

        $query->when(!empty($searchParams['cart_value']), function (Builder $query) use ($searchParams) {
            $query->where('cart_value', '<=', $searchParams['cart_value']);
        });

        $query->when(!empty($searchParams['code']), function (Builder $query) use ($searchParams) {
            $query->where('code', '=', $searchParams['code']);
        });

        $query->when(!empty($searchParams['maxPrice']), function (Builder $query) use ($searchParams) {
            $query->where('regular_price', '<=', $searchParams['maxPrice']);
        });

        $query->when(isset($searchParams['name']), function (Builder $query) use ($searchParams) {
            $query->where('code', 'like', "%{$searchParams['name']}%");
        });

        return $query;
    }
}
