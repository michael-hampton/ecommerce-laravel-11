<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\ProductAddedToWishlist;
use App\Notifications\ProductInWishlistSold;
use App\Repositories\Interfaces\IProductRepository;
use App\Services\Cart\Facade\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class WishListController extends Controller
{
    public function __construct(private IProductRepository $productRepository) {
    }

    public function index()
    {
        $items = Cart::instance('wishlist')->content();
        $currency = config('shop.currency');

        return view('front.wishlist', ['items' => $items, 'currency' => $currency]);
    }

    public function addToWishList(Request $request)
    {
        Cart::instance('wishlist')->add(
            $request->id,
            $request->name,
            $request->quantity,
            $request->price
        )->associate(\App\Models\Product::class);

        $item = $this->productRepository->setRequiredRelationships(['seller'])->getById($request->id);
        $item->seller->notify(new ProductAddedToWishlist($item->seller, $item));

        if ($request->ajax()) {
            return response()->json([
                'count' => Cart::instance('wishlist')->content()->count(),
                'view' => View::make('front.partials.wishlist-header', [
                    'items' => Cart::instance('wishlist')->content(),
                    'currency' => config('shop.currency'),
                ])->render(),
            ]);
        }

        return redirect()->back();
    }

    public function removeFromWishList(string $rowId)
    {
        Cart::instance('wishlist')->remove($rowId);

        return redirect()->back();
    }

    public function emptyWishList()
    {
        Cart::instance('wishlist')->destroy();

        return response()->json(['success' => true, 'count'=> Cart::instance('')->content()->count()]);
    }

    public function moveToCart(string $rowId)
    {
        $item = Cart::instance('wishlist')->get($rowId);

        Cart::instance('cart')->add(
            $item->id,
            $item->name,
            $item->qty,
            $item->price
        )->associate(\App\Models\Product::class);
        Cart::instance('wishlist')->remove($rowId);

        return redirect()->back();
    }
}
