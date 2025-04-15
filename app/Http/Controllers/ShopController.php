<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\IBrandRepository;
use App\Repositories\Interfaces\ICategoryRepository;
use App\Repositories\Interfaces\IProductRepository;
use App\Services\Cart\Facade\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    private $showOptions = [12, 24, 48, 102];
    private $sortOptions = [
        ['id' => 1, 'name' => 'Featured', 'column' => 'featured', 'direction' => 'desc'],
        ['id' => 2, 'name' => 'Best selling', 'column' => 'featured', 'direction' => 'desc'],
        ['id' => 3, 'name' => 'Alphabetically, A-Z', 'column' => 'name', 'direction' => 'asc'],
        ['id' => 4, 'name' => 'Alphabetically, Z-A', 'column' => 'name', 'direction' => 'desc'],
        ['id' => 5, 'name' => 'Price, low to high', 'column' => 'regular_price', 'direction' => 'asc'],
        ['id' => 6, 'name' => 'Price, high to low', 'column' => 'regular_price', 'direction' => 'desc'],
        ['id' => 7, 'name' => 'Date, old to new', 'column' => 'created_at', 'direction' => 'asc'],
        ['id' => 8, 'name' => 'Date, new to old', 'column' => 'created_at', 'direction' => 'desc'],
    ];

    public function __construct(
        private IProductRepository  $productRepository,
        private IBrandRepository    $brandRepository,
        private ICategoryRepository $categoryRepository,
    )
    {
        //
    }

    public function index(Request $request)
    {
        $size = (int)$request->get('size', 12) ?? 12;
        $orderBy = $request->get('orderBy') ?? -1;
        $brandIds = $request->get('brandId') ?? '';
        $categoryIds = $request->get('categoryId') ?? '';
        $orderByColumn = 'created_at';
        $orderDir = 'desc';
        $minPrice = $request->get('minPrice') ?? 1;
        $maxPrice = $request->get('maxPrice') ?? 5000;

        foreach ($this->sortOptions as $sortOption) {
            if ($sortOption['name'] == $orderBy) {
                $orderByColumn = $sortOption['column'];
                $orderDir = $sortOption['direction'];
                break;
            }
        }

        $products = $this->productRepository->getPaginated(
            $size,
            $orderByColumn,
            $orderDir,
            [
                'brandIds' => $brandIds,
                'categoryIds' => $categoryIds,
                'minPrice' => $minPrice,
                'maxPrice' => $maxPrice,
            ]
        );
        $brands = $this->brandRepository->getAll(null, 'name', 'asc');
        $categories = $this->categoryRepository->getAll(null, 'name', 'asc');

        if (Auth::check()) {
            Cart::instance('cart')->store(Auth::user()->email);
            Cart::instance('wishlist')->store(Auth::user()->email);
        }

        Cart::instance('wishlist')->loadWishlistProducts();

        if($request->ajax()) {
            return view('partials/product-search', [
                'products' => $products,
                'brands' => $brands,
                'categories' => $categories,
                'brandId' => $brandIds,
                'categoryId' => $categoryIds,
                'minPrice' => $minPrice,
                'maxPrice' => $maxPrice,
                'size' => $size,
                'orderBy' => $orderBy,
                'showOptions' => $this->showOptions,
                'sortOptions' => $this->sortOptions,
                'currency' => config('shop.currency')
            ]);
        }

        return view('shop', [
            'products' => $products,
            'brands' => $brands,
            'categories' => $categories,
            'brandId' => $brandIds,
            'categoryId' => $categoryIds,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
            'size' => $size,
            'orderBy' => $orderBy,
            'showOptions' => $this->showOptions,
            'sortOptions' => $this->sortOptions,
            'currency' => config('shop.currency')
        ]);
    }

    public function details(string $slug)
    {
        $product = $this->productRepository->getItemByColumn($slug);

        $relatedProducts = $this->productRepository->getCollectionByColumn($product->category_id, 'category_id', 8);
        $otherSellerProducts = $this->productRepository->getPaginated(4, 'created_at', 'desc', ['seller_id' => auth()->id()]);

        return view('details', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'currency' => config('shop.currency'),
            'otherSellerProducts' => $otherSellerProducts,
        ]);
    }
}
