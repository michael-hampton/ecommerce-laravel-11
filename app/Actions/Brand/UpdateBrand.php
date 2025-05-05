<?php

declare(strict_types=1);

namespace App\Actions\Brand;

use App\Helper;
use App\Repositories\Interfaces\IBrandRepository;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class UpdateBrand
{
    public function __construct(private IBrandRepository $repository) {}

    public function handle(array $data, int $id)
    {
        $brand = $this->repository->getById($id);
        $data['slug'] = Str::slug($data['name']);

        if (! empty($data['image'])) {
            if (File::exists(public_path('uploads/brands/'.$brand->image))) {
                File::delete(public_path('uploads/brands/'.$brand->image));
            }

            $image = $data['image'];
            $filename = time().'.'.$image->getClientOriginalExtension();

            $data['image']->storeAs('brands', $filename, 'public');

            // Thumbnail
            Helper::generateThumbnailImage($data['image'], $filename, 'brands');

            $data['image'] = $filename;
        }

        return $this->repository->update($id, $data);
    }
}
