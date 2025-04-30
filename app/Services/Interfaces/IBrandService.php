<?php

namespace App\Services\Interfaces;

interface IBrandService
{
    public function createBrand(array $data);
    public function updateBrand(array $data, int $id);
    public function deleteBrand(int $id);
    public function toggleActive(int $id);
}
