<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

interface IProductRepository extends IBaseRepository
{
    public function getHotDeals();

    public function getFeaturedProducts();

    public function getProductsForShop(int $paged = 15, string $orderBy = 'created_at', string $sort = 'desc', $search = []);

}
