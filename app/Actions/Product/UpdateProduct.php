<?php

declare(strict_types=1);

namespace App\Actions\Product;

use App\Helper;
use App\Models\ProductAttributeValue;
use App\Repositories\Interfaces\IProductRepository;
use Carbon\Carbon;
use Illuminate\Support\Str;

class UpdateProduct extends SaveProduct
{
    public function __construct(private IProductRepository $repository) {}

    public function handle(array $data, int $id)
    {
        $product = $this->repository->getById($id);
        $product->fill($data);
        $data['slug'] = Str::slug($data['name']);
        $currentTimestamp = Carbon::now()->timestamp;

        if (! empty($data['subcategory_id'])) {
            $data['category_id'] = $data['subcategory_id'];
            unset($data['subcategory_id']);
        }

        if (! empty($data['attribute_values'])) {
            $attributeValues = $data['attribute_values'];
            unset($data['attribute_values']);
        }

        if (! empty($data['image'])) {
            $fileExtension = $data['image']->getClientOriginalExtension();
            $filename = $currentTimestamp.'.'.$fileExtension;

            $data['image']->storeAs('products', $filename, 'public');

            // Thumbnail
            Helper::generateThumbnailImage($data['image'], $filename, 'products');

            $data['image'] = $filename;
        }
        $galleryArr = [];
        $galleryImages = '';
        $counter = 1;
        if (! empty($data['images'])) {
            $allowedfileExtension = ['jpg', 'png', 'jpeg'];
            $files = $data['images'];
            foreach ($files as $file) {
                $gextension = $file->getClientOriginalExtension();
                $check = in_array($gextension, $allowedfileExtension);
                if ($check) {
                    $gfilename = $currentTimestamp.'-'.$counter.'.'.$gextension;
                    $file->storeAs('products', $gfilename, 'public');
                    Helper::generateThumbnailImage($file, $gfilename, 'products');
                    array_push($galleryArr, $gfilename);
                    $counter++;
                }
            }
            $galleryImages = implode(', ', $galleryArr);
        }
        $data['images'] = $galleryImages;

        $bumpDays = $data['bump_days'];
        unset($data['bump_days']);

        if (! empty($bumpDays)) {
            $this->updateSellerBalance($bumpDays, $product);
        }

        $this->repository->update($id, $data);

        ProductAttributeValue::where('product_id', $id)->forceDelete();

        if (! empty($attributeValues)) {
            $this->saveAttributes($attributeValues, $product);
        }

        return $product;
    }
}
