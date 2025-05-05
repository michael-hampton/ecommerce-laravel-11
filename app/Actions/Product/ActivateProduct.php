<?php

namespace App\Actions\Product;

use App\Repositories\Interfaces\IProductRepository;

class ActivateProduct
{
    public function __construct(private IProductRepository $repository)
    {

    }

    public function handle(int $id)
    {
        $product = $this->repository->getById($id);
        $data = ['active' => $product->active === true ? false : true];
        return $product->update($data);
    }
}
