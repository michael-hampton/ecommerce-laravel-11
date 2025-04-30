<?php

namespace App\Services;

use App\Helper;
use App\Models\Category;
use App\Models\CategoryAttributes;
use App\Models\ProductAttribute;
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
        $category = $this->repository->create($data);

        if(!empty($data['attributes'])) {
            $this->saveAttributes($data['attributes'], $category);
         }

         return $category;
    }

    private function saveAttributes($attributes, Category $category) {
        $attributeIds = explode(',', $attributes);
        $productAttributes = ProductAttribute::whereIn('id', $attributeIds)->get();
       
        foreach( $productAttributes as $productAttribute ) {
            $flight = CategoryAttributes::firstOrCreate(
                ['category_id' => $category->id, 'attribute_id' => $productAttribute->id],
                ['category_id' => $category->id,  'attribute_id' => $productAttribute->id]
            );
        }
    }

    public function updateCategory(array $data, int $id)
    {
        $category = $this->repository->getById($id);
        $data['slug'] = Str::slug($data['name']);

        if (empty($data['parent_id'])) {
            $data['parent_id'] = 0;
        }

        if (!empty($data['image'])) {
            if (File::exists(public_path('uploads/categories/' . $category->image))) {
                File::delete(public_path('uploads/categories/' . $category->image));
            }

            $image = $data['image'];
            $filename = time() . '.' . $image->getClientOriginalExtension();

            $image->storeAs('categories', $filename, 'public');

            // Thumbnail
            Helper::generateThumbnailImage($data['image'], $filename, 'categories');

            $data['image'] = $filename;
        }

        if(!empty($data['attributes'])) {
            $this->saveAttributes($data['attributes'], $category);
            unset($data['attributes']);
         }

        return $this->repository->update($id, $data);
    }

    public function deleteCategory(int $id)
    {
        $category = $this->repository->getById($id);

        /*if (File::exists(public_path('images/categories/' . $category->image))) {
            File::delete(public_path('images/categories/' . $category->image));
        }*/

        return $this->repository->delete($id);
    }

    public function toggleActive(int $id)
    {
        $category = $this->repository->getById($id);
        $data = ['active' => $category->active === true ? false : true];
        return $category->update($data);
    }
}
