<?php

declare(strict_types=1);

namespace App\Actions\Brand;

use App\Repositories\Interfaces\IBrandRepository;

class DeleteBrand
{
    public function __construct(private readonly IBrandRepository $brandRepository) {}

    public function handle(int $id)
    {
        $this->brandRepository->getById($id);

        /*if(File::exists(public_path('images/brands/' . $brand->image))){
            File::delete(public_path('images/brands/' . $brand->image));
        }*/

        return $this->brandRepository->delete($id);
    }
}
