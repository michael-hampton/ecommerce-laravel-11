<?php

namespace App\Actions\Brand;

use App\Helper;
use App\Repositories\Interfaces\IBrandRepository;

class ActivateBrand
{
    public function __construct(private IBrandRepository $repository)
    {

    }


    public function handle(int $id)
    {
        $brand = $this->repository->getById($id);

        return $brand->update(['active' => $brand->active === true ? false : true]);
    }
}
