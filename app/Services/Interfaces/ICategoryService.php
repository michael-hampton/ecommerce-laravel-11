<?php

namespace App\Services\Interfaces;

interface ICategoryService
{
    public function createCategory(array $data);
    public function updateCategory(array $data, int $id);
    public function deleteCategory(int $id);
}
