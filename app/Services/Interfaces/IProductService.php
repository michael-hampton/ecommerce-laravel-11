<?php

namespace App\Services\Interfaces;

interface IProductService
{
    public function createProduct(array $data);
    public function updateProduct(array $data, int $id);
    public function deleteProduct(int $id);
}
