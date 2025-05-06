<?php



namespace App\Actions\Coupon;

use App\Repositories\Interfaces\ICouponRepository;

class DeleteCoupon
{
    public function __construct(private ICouponRepository $repository) {}

    public function handle(int $id)
    {
        return $this->repository->delete($id);
    }
}
