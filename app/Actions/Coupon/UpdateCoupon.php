<?php



namespace App\Actions\Coupon;

use App\Repositories\Interfaces\ICouponRepository;

class UpdateCoupon
{
    public function __construct(private ICouponRepository $repository) {}

    public function handle(array $data, int $id)
    {
        if (! empty($data['categories'])) {
            $data['categories'] = implode(',', $data['categories']);
        }

        if (! empty($data['brands'])) {
            $data['brands'] = implode(',', $data['brands']);
        }

        $data['seller_id'] = auth()->id();

        return $this->repository->update($id, $data);
    }
}
