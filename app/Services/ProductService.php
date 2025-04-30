<?php

namespace App\Services;

use App\Helper;
use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\ProductAttributeValue;
use App\Models\SellerBalance;
use App\Models\WithdrawalEnum;
use App\Models\WithdrawalTypeEnum;
use App\Repositories\Interfaces\IProductRepository;
use App\Services\Interfaces\IProductService;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Log;

class ProductService implements IProductService
{
    public function __construct(private IProductRepository $repository)
    {

    }

    public function createProduct(array $data)
    {
        $data['slug'] = Str::slug($data['name']);
        $data['seller_id'] = auth()->user()->id;

        if (!empty($data['subcategory_id'])) {
            $data['category_id'] = $data['subcategory_id'];
        }

        unset($data['subcategory_id']);

        $currentTimestamp = Carbon::now()->timestamp;
        if (!empty($data['image'])) {

            $filename = time() . '.' . $data['image']->getClientOriginalExtension();
            $data['image']->storeAs('products', $filename, 'public');

            // Thumbnail
            Helper::generateThumbnailImage($data['image'], $filename, 'products');
            $data['image'] = $filename;
        }

        $galleryArr = [];
        $galleryImages = "";
        $counter = 1;
        if ($data['images']) {
            $allowedfileExtension = ['jpg', 'png', 'jpeg'];
            $files = $data['images'];
            foreach ($files as $file) {
                $gextension = $file->getClientOriginalExtension();
                $check = in_array($gextension, $allowedfileExtension);
                if ($check) {
                    $gfilename = $currentTimestamp . "-" . $counter . "." . $gextension;
                    $file->storeAs('products', $gfilename, 'public');
                    Helper::generateThumbnailImage($file, $gfilename, 'products');
                    array_push($galleryArr, $gfilename);
                    $counter++;
                }
            }

            $galleryImages = implode(',', $galleryArr);
        }

        $data['images'] = $galleryImages;

        $bumpDays = $data['bump_days'];
        unset($data['bump_days']);

        $product = $this->repository->create($data);

        if (!empty($bumpDays) && $product->featured === false) {
            $this->updateSellerBalance($bumpDays, $product);
        }

        if (!empty($data['attribute_values'])) {
            $this->saveAttributes($data['attribute_values'], $product);
        }

        return $product;
    }

    private function saveAttributes(array $data, Product $product)
    {
        $productAttributeValues = AttributeValue::all()->keyBy('id');

        foreach ($data as $attributeValueId) {

            $attributeValue = $productAttributeValues->get($attributeValueId);

            $data = [
                'product_attribute_id' => $attributeValue->attribute_id,
                'attribute_value_id' => $attributeValue->id,
                'product_id' => $product->id,
            ];

            $attributeValue = new ProductAttributeValue;
            $attributeValue->fill($data);
            $attributeValue->save();
        }
    }

    public function updateProduct(array $data, int $id)
    {
        $product = $this->repository->getById($id);
        $product->fill($data);
        $data['slug'] = Str::slug($data['name']);
        $currentTimestamp = Carbon::now()->timestamp;

        if (!empty($data['subcategory_id'])) {
            $data['category_id'] = $data['subcategory_id'];
            unset($data['subcategory_id']);
        }

        if (!empty($data['attribute_values'])) {
            $attributeValues = $data['attribute_values'];
            unset($data['attribute_values']);
        }

        if (!empty($data['image'])) {
            $fileExtension = $data['image']->getClientOriginalExtension();
            $filename = $currentTimestamp . '.' . $fileExtension;

            $data['image']->storeAs('products', $filename, 'public');

            // Thumbnail
            Helper::generateThumbnailImage($data['image'], $filename, 'products');

            $data['image'] = $filename;
        }
        $galleryArr = [];
        $galleryImages = "";
        $counter = 1;
        if (!empty($data['images'])) {
            $allowedfileExtension = ['jpg', 'png', 'jpeg'];
            $files = $data['images'];
            foreach ($files as $file) {
                $gextension = $file->getClientOriginalExtension();
                $check = in_array($gextension, $allowedfileExtension);
                if ($check) {
                    $gfilename = $currentTimestamp . "-" . $counter . "." . $gextension;
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

        if (!empty($bumpDays)) {
            $this->updateSellerBalance($bumpDays, $product);
        }

        $this->repository->update($id, $data);

        ProductAttributeValue::where('product_id', $id)->forceDelete();

        if (!empty($attributeValues)) {
            $this->saveAttributes($attributeValues, $product);
        }

        return $product;
    }

    public function deleteProduct(int $id)
    {
        $product = $this->repository->getById($id);

        /*if (File::exists(public_path('images/products/' . $product->image))) {
            File::delete(public_path('images/products/' . $product->image));
        }*/

        return $this->repository->delete($id);
    }

    private function updateSellerBalance(int $bumpDays, Product $product): bool
    {
        if (empty($bumpDays)) {
            return false;
        }

        $costs = config('shop.bump');

        $price = $costs[$bumpDays];

        (new WithdrawalService(
            auth()->id(),
            $price,
            WithdrawalTypeEnum::BumpProduct,
            WithdrawalEnum::Decrease,
            $product->id
        ))->updateBalance();

        return true;
    }
}
