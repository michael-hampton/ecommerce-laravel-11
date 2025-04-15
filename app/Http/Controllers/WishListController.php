<?php

namespace App\Http\Controllers;

use App\Services\Cart\Facade\Cart;
use Illuminate\Http\Request;

class WishListController extends Controller
{
    public function index()
    {
        $items = Cart::instance('wishlist')->content();
        $currency = config('shop.currency');
        return view('wishlist', compact('items', 'currency'));
    }

    public function addToWishList(Request $request)
    {
        Cart::instance('wishlist')->add(
            $request->id,
            $request->name,
            $request->quantity,
            $request->price
        )->associate('App\Models\Product');

        if ($request->ajax()) {
            return response()->json(['count' => Cart::instance('wishlist')->content()->count()]);
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
        return redirect()->back();
    }

    public function moveToCart(string $rowId)
    {
        $item = Cart::instance('wishlist')->get($rowId);

        Cart::instance('cart')->add(
            $item->id,
            $item->name,
            $item->qty,
            $item->price
        )->associate('App\Models\Product');
        Cart::instance('wishlist')->remove($rowId);
        return redirect()->back();
    }
}
