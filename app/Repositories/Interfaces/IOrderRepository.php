<?php

namespace App\Repositories\Interfaces;

interface IOrderRepository extends IBaseRepository
{
    public function getOrderDetails(int $orderId, int $sellerId);
}
