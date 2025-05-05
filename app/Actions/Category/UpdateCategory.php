<?php

namespace App\Actions\Category;

use App\Helper;
use App\Models\Category;
use App\Models\CategoryAttributes;
use App\Models\ProductAttribute;
use App\Repositories\Interfaces\ICategoryRepository;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class UpdateCategory
{
    public function __construct(private ICategoryRepository $repository)
    {

    }

    private function saveAttributes($attributes, Category $category): void
    {
        $attributeIds = explode(',', $attributes);
        $productAttributes = ProductAttribute::whereIn('id', $attributeIds)->get();

        foreach ($productAttributes as $productAttribute) {
            $flight = CategoryAttributes::firstOrCreate(
                ['category_id' => $category->id, 'attribute_id' => $productAttribute->id],
                ['category_id' => $category->id, 'attribute_id' => $productAttribute->id]
            );
        }
    }

    public function handle(array $data, int $id)
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

        if (!empty($data['attributes'])) {
            $this->saveAttributes($data['attributes'], $category);
            unset($data['attributes']);
        }

        return $this->repository->update($id, $data);
    }

}
