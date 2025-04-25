<?php

namespace App\Services;

use App\Helper;
use App\Repositories\Interfaces\IBrandRepository;
use App\Services\Interfaces\IBrandService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BrandService implements IBrandService
{
    public function __construct(private IBrandRepository $repository)
    {

    }


    /**
     * @param array $data
     * @return mixed
     */
    public function createBrand(array $data) {
        $data['slug'] = Str::slug($data['name']);
        $filename = time() . '.' . $data['image']->getClientOriginalExtension();
        $data['image']->storeAs('brands', $filename, 'public');

        // Thumbnail
        Helper::generateThumbnailImage($data['image'], $filename, 'brands');
        $data['image'] = $filename;

        return $this->repository->create($data);
    }

    public function updateBrand(array $data, int $id) {
        $brand = $this->repository->getById($id);
        $data['slug'] = Str::slug($data['name']);

        if(!empty($data['image'])) {
            if(File::exists(public_path('uploads/brands/' . $brand->image))){
                File::delete(public_path('uploads/brands/' . $brand->image));
            }

            $image = $data['image'];
            $filename = time() . '.' . $image->getClientOriginalExtension();

            $data['image']->storeAs('brands', $filename, 'public');

            // Thumbnail
            Helper::generateThumbnailImage($data['image'], $filename, 'brands');

            $data['image'] = $filename;
        }

        return $this->repository->update($id, $data);
    }

    public function deleteBrand(int $id) {
        $brand = $this->repository->getById($id);

        /*if(File::exists(public_path('images/brands/' . $brand->image))){
            File::delete(public_path('images/brands/' . $brand->image));
        }*/

        return $this->repository->delete($id);
    }
}
