<?php

namespace App\Actions\Brand;

use App\Helper;
use App\Repositories\Interfaces\IBrandRepository;

class DeleteBrand
{
    public function __construct(private IBrandRepository $repository)
    {

    }

    public function handle(int $id) {
        $brand = $this->repository->getById($id);

        /*if(File::exists(public_path('images/brands/' . $brand->image))){
            File::delete(public_path('images/brands/' . $brand->image));
        }*/

        return $this->repository->delete($id);
    }

}
