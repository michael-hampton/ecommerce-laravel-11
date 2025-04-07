<?php

namespace App\Services\Interfaces;

interface ICouponService
{
    public function createCoupon(array $data);
    public function updateCoupon(array $data, int $id);
    public function deleteCoupon(int $id);
    public function applyCoupon(string $couponCode);
}
