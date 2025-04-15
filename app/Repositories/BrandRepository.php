<?php

namespace App\Repositories;

use App\Models\Brand;
use App\Repositories\Interfaces\IBaseRepository;
use App\Repositories\Interfaces\IBrandRepository;

class BrandRepository extends BaseRepository implements IBrandRepository
{

    public function __construct(Brand $brand) {
        parent::__construct($brand);
    }
}
