<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Coupon;
use App\Repositories\Interfaces\ICouponRepository;
use Illuminate\Database\Eloquent\Builder;

class CouponRepository extends BaseRepository implements ICouponRepository
{
    public function __construct(Coupon $coupon)
    {
        parent::__construct($coupon);
    }

    protected function applyFilters(array $searchParams = []): Builder
    {
        $builder = $this->getQuery();

        $builder->when(! empty($searchParams['expiry_date']), function (Builder $builder) use ($searchParams): void {
            $builder->where('expires_at', '>=', $searchParams['expiry_date']);
        });

        $builder->when(! empty($searchParams['cart_value']), function (Builder $builder) use ($searchParams): void {
            $builder->where('cart_value', '<=', $searchParams['cart_value']);
        });

        $builder->when(! empty($searchParams['code']), function (Builder $builder) use ($searchParams): void {
            $builder->where('code', '=', $searchParams['code']);
        });

        $builder->when(! empty($searchParams['maxPrice']), function (Builder $builder) use ($searchParams): void {
            $builder->where('regular_price', '<=', $searchParams['maxPrice']);
        });

        $builder->when(isset($searchParams['name']), function (Builder $builder) use ($searchParams): void {
            $builder->where('code', 'like', sprintf('%%%s%%', $searchParams['name']));
        });

        return $builder;
    }
}
