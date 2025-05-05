<?php

namespace App\Actions\Product;

use App\Helper;
use App\Repositories\Interfaces\IProductRepository;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Log;

class CreateProduct extends SaveProduct
{
    public function __construct(private IProductRepository $repository)
    {

    }

    public function handle(array $data)
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

}
