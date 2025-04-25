<?php

namespace App\Services;

use App\Helper;
use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use App\Models\SellerBalance;
use App\Repositories\Interfaces\IProductRepository;
use App\Services\Interfaces\IProductService;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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

        $current_timestamp = Carbon::now()->timestamp;
        if (!empty($data['image'])) {

            $filename = time() . '.' . $data['image']->getClientOriginalExtension();
            $data['image']->storeAs('products', $filename, 'public');

            // Thumbnail
            Helper::generateThumbnailImage($data['image'], $filename, 'products');
            $data['image'] = $filename;
        }

        $gallery_arr = array();
        $gallery_images = "";
        $counter = 1;
        if ($data['images']) {
            $allowedfileExtension = ['jpg', 'png', 'jpeg'];
            $files = $data['images'];
            foreach ($files as $file) {
                $gextension = $file->getClientOriginalExtension();
                $check = in_array($gextension, $allowedfileExtension);
                if ($check) {
                    $gfilename = $current_timestamp . "-" . $counter . "." . $gextension;
                    $file->storeAs('products', $gfilename, 'public');
                    Helper::generateThumbnailImage($file, $gfilename, 'products');
                    array_push($gallery_arr, $gfilename);
                    $counter = $counter + 1;
                }
            }
            $gallery_images = implode(',', $gallery_arr);
        }
        $data['images'] = $gallery_images;

        $this->updateSellerBalance($data);

        $product = $this->repository->create($data);

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
        $current_timestamp = Carbon::now()->timestamp;

        if (!empty($data['subcategory_id'])) {
            $data['category_id'] = $data['subcategory_id'];
            unset($data['subcategory_id']);
        }

        if (!empty($data['attribute_values'])) {
            $attributeValues = $data['attribute_values'];
            unset($data['attribute_values']);
        }

        if (!empty($data['image'])) {
            $file_extention = $data['image']->getClientOriginalExtension();
            $file_name = $current_timestamp . '.' . $file_extention;

            $data['image']->storeAs('products', $file_name, 'public');

            // Thumbnail
            Helper::generateThumbnailImage($data['image'], $file_name, 'products');

            $data['image'] = $file_name;
        }
        $gallery_arr = array();
        $gallery_images = "";
        $counter = 1;
        if (!empty($data['images'])) {
            $allowedfileExtension = ['jpg', 'png', 'jpeg'];
            $files = $data['images'];
            foreach ($files as $file) {
                $gextension = $file->getClientOriginalExtension();
                $check = in_array($gextension, $allowedfileExtension);
                if ($check) {
                    $gfilename = $current_timestamp . "-" . $counter . "." . $gextension;
                    $file->storeAs('products', $gfilename, 'public');
                    Helper::generateThumbnailImage($file, $gfilename, 'products');
                    array_push($gallery_arr, $gfilename);
                    $counter = $counter + 1;
                }
            }
            $gallery_images = implode(', ', $gallery_arr);
        }
        $data['images'] = $gallery_images;

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

    private function updateSellerBalance(array $data)
    {
        if (empty($data['charge_featured'])) {
            return false;
        }

        $sellerBalance = SellerBalance::where('seller_id', auth()->id())->first();

        if ($sellerBalance) {
            SellerBalance::where('seller_id', auth()->id())->decrement('balance', $data['charge_featured']);
        } else {
            SellerBalance::create(['balance' => $data['charge_featured'], 'seller_id' => auth()->id()]);
        }

        return true;
    }
}
