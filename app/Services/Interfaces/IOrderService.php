<?php

namespace App\Services\Interfaces;

interface IOrderService
{
    public function createOrder(array $data);
    public function updateOrder(array $data, int $id);
    public function deleteOrder(array $data);
    public function updateOrderLine(array $data, int $id);
    public function approveOrder(int $orderId);
}
