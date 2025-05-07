<?php

declare(strict_types=1);

namespace App\Actions\Product;

use App\Repositories\Interfaces\IProductRepository;

class DeleteProduct
{
    public function __construct(private IProductRepository $productRepository) {}

    public function handle(int $id)
    {
        $this->productRepository->getById($id);

        /*if (File::exists(public_path('images/products/' . $product->image))) {
            File::delete(public_path('images/products/' . $product->image));
        }*/

        return $this->productRepository->delete($id);
    }
}
