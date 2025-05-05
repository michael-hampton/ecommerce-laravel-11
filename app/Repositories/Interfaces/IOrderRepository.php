<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

interface IOrderRepository extends IBaseRepository
{
    public function getOrderDetails(int $orderId, int $sellerId);
}
