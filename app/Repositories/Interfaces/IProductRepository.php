<?php

namespace App\Repositories\Interfaces;

interface IProductRepository extends IBaseRepository
{
    public function getHotDeals();
    public function getFeaturedProducts();
}
