<?php

namespace App\Services\Interfaces;

interface IDeliveryMethodService
{
    public function createDeliveryMethod(array $data);
    public function updateDeliveryMethod(array $data, int $id);
    public function deleteDeliveryMethod(int $id);
}
