<?php

declare(strict_types=1);

namespace App\Actions\Coupon;

use App\Repositories\Interfaces\ICouponRepository;

class DeleteCoupon
{
    public function __construct(private ICouponRepository $couponRepository) {}

    public function handle(int $id)
    {
        return $this->couponRepository->delete($id);
    }
}
