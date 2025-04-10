<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordRequest;
use App\Models\Product;
use App\Models\User;
use App\Repositories\Interfaces\ICategoryRepository;
use App\Repositories\Interfaces\IProductRepository;
use App\Services\Cart\Facade\Cart;
use App\Services\ProductService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function __construct(private ICategoryRepository $categoryRepository, private IProductRepository $productRepository)
    {

    }

    public function index()
    {
        $categories = $this->categoryRepository->getPaginated(20, 'name', 'asc');
        $products = $this->productRepository->getHotDeals();
        $featuredProducts = $this->productRepository->getFeaturedProducts();
        $currency = config('shop.currency');

        if(Auth::check()){
            Cart::instance('cart')->restore(Auth::user()->email);
            Cart::instance('wishlist')->restore(Auth::user()->email);

        }

        return view('index', compact('categories', 'products', 'currency', 'featuredProducts'));
    }

    public function changePassword()
    {
        return view('change-password');
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        #Match The Old Password
        if(!Hash::check($request->old_password, auth()->user()->password)){
            return back()->with("error", "Old Password Doesn't match!");
        }


        #Update the new Password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with("status", "Password changed successfully!");
    }
}
