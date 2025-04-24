<?php

namespace App\Services\Interfaces;

interface ISellerService
{
    public function createSeller(array $data);
    public function updateSeller(array $data, int $id);
    public function deleteSeller(int $id);
}
