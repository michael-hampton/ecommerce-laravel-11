<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Repositories\Interfaces\ICategoryRepository;
use App\Repositories\Interfaces\IProductRepository;
use App\Services\Cart\Facade\Cart;
use App\Services\ProductService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
