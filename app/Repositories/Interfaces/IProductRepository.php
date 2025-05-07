<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

interface IProductRepository extends IBaseRepository
{
    public function getHotDeals();

    public function getFeaturedProducts();
}
