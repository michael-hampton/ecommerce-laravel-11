<?php

declare(strict_types=1);

namespace App\Actions\Coupon;

use App\Models\Coupon;
use App\Repositories\Interfaces\ICouponRepository;

class CreateCoupon
{
    public function __construct(private ICouponRepository $repository) {}

    public function handle(array $data): Coupon
    {
        if (! empty($data['categories'])) {
            $data['categories'] = implode(',', $data['categories']);
        }

        if (! empty($data['brands'])) {
            $data['brands'] = implode(',', $data['brands']);
        }

        $data['seller_id'] = auth()->id();

        return $this->repository->create($data);
    }
}
