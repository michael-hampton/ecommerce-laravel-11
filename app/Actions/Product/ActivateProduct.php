<?php

declare(strict_types=1);

namespace App\Actions\Product;

use App\Repositories\Interfaces\IProductRepository;

class ActivateProduct
{
    public function __construct(private readonly IProductRepository $productRepository) {}

    public function handle(int $id)
    {
        $product = $this->productRepository->getById($id);
        $data = ['active' => $product->active !== true];

        return $product->update($data);
    }
}
