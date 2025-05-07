<?php



namespace App\Actions\Product;

use App\Helper;
use App\Models\Product;
use App\Models\ProductAttributeValue;
use App\Models\User;
use App\Notifications\ProductInWishlistReduced;
use App\Repositories\Interfaces\IProductRepository;
use App\Services\Cart\Facade\Cart;
use Carbon\Carbon;
use Illuminate\Support\Str;

class UpdateProduct extends SaveProduct
{
    public function __construct(private IProductRepository $repository)
    {
    }

    public function handle(array $data, int $id)
    {
        $product = $this->repository->getById($id);
      
        $data['slug'] = Str::slug($data['name']);
        $currentTimestamp = Carbon::now()->timestamp;

        $priceReduced = $data['sale_price'] !== $product->sale_price;

        $product->fill($data);

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
        $galleryImages = '';
        $counter = 1;
        if (!empty($data['images'])) {
            $allowedfileExtension = ['jpg', 'png', 'jpeg'];
            $files = $data['images'];
            foreach ($files as $file) {
                $gextension = $file->getClientOriginalExtension();
                $check = in_array($gextension, $allowedfileExtension);
                if ($check) {
                    $gfilename = $currentTimestamp . '-' . $counter . '.' . $gextension;
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
            $this->saveAttributes($attributeValues);
        }

        if ($priceReduced) {
            $this->sendNotification($data, $product->fresh());
        }

        return $product;
    }

    private function sendNotification(array $data, Product $product): void
    {
        //if the product has a sale price lower than the regular price (discounted) and the discounted price is not the same as whats already been saved (indicates a change in price) then send notifiaction
        
        if (!empty($data['sale_price']) && $data['sale_price'] < $data['regular_price']) {
            $wishlistItems = collect(Cart::instance('wishlist')->getStoredItems())->filter(function ($item) {
                return in_array($item->id, [(string) $item->id]);
            });

            $wishlistItems->each(function ($item) use ($product) {
                $user = User::where('email', $item->identifier)->firstOrFail();

                $user->notify(new ProductInWishlistReduced($product));
            });
        }
    }
}
