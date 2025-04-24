<?php

namespace App\Services;

use App\Helper;
use App\Repositories\Interfaces\ICategoryRepository;
use App\Services\Interfaces\ICategoryService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CategoryService implements ICategoryService
{
    public function __construct(private ICategoryRepository $repository)
    {

    }

    public function createCategory(array $data)
    {
        $data['slug'] = Str::slug($data['name']);
        if (empty($data['parent_id'])) {
            $data['parent_id'] = 0;
        }
        $image = $data['image'];
        $filename = time() . '.' . $image->getClientOriginalExtension();

        $image->storeAs('categories', $filename, 'public');

        // Thumbnail
        Helper::generateThumbnailImage($data['image'], $filename, 'categories');

        $data['image'] = $filename;
        $this->repository->create($data);
    }

    public function updateCategory(array $data, int $id)
    {
        $product = $this->repository->getById($id);
        $data['slug'] = Str::slug($data['name']);

        if (empty($data['parent_id'])) {
            $data['parent_id'] = 0;
        }

        if (!empty($data['image'])) {
            if (File::exists(public_path('uploads/categories/' . $product->image))) {
                File::delete(public_path('uploads/categories/' . $product->image));
            }

            $image = $data['image'];
            $filename = time() . '.' . $image->getClientOriginalExtension();

            $image->storeAs('categories', $filename, 'public');

            // Thumbnail
            Helper::generateThumbnailImage($data['image'], $filename, 'categories');

            $data['image'] = $filename;
        }

        $this->repository->update($id, $data);
    }

    public function deleteCategory(int $id)
    {
        $category = $this->repository->getById($id);

        /*if (File::exists(public_path('images/categories/' . $category->image))) {
            File::delete(public_path('images/categories/' . $category->image));
        }*/

        $this->repository->delete($id);
    }
}
