<?php



namespace App\Actions\Category;

use App\Helper;
use App\Models\Category;
use App\Models\CategoryAttributes;
use App\Models\ProductAttribute;
use App\Repositories\Interfaces\ICategoryRepository;
use Illuminate\Support\Str;

class CreateCategory
{
    public function __construct(private ICategoryRepository $repository) {}

    public function handle(array $data): Category
    {
        $data['slug'] = Str::slug($data['name']);
        if (empty($data['parent_id'])) {
            $data['parent_id'] = 0;
        }

        if (! empty($data['image'])) {

            $image = $data['image'];
            $filename = time().'.'.$image->getClientOriginalExtension();

            $image->storeAs('categories', $filename, 'public');

            // Thumbnail
            Helper::generateThumbnailImage($data['image'], $filename, 'categories');

            $data['image'] = $filename;
        }

        $category = $this->repository->create($data);

        if (! empty($data['attributes'])) {
            $this->saveAttributes($data['attributes'], $category);
        }

        return $category;
    }

    private function saveAttributes($attributes, Category $category)
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
}
