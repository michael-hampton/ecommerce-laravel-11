<?php



namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\CategoryAttributes;
use App\Repositories\Interfaces\IBrandRepository;
use App\Repositories\Interfaces\ICategoryRepository;
use App\Repositories\Interfaces\IProductRepository;
use App\Services\Cart\Facade\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class ShopController extends Controller
{
    private array $showOptions = [16, 24, 48, 102];

    private array $sortOptions = [
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
        private readonly IProductRepository $productRepository,
        private readonly IBrandRepository $brandRepository,
        private readonly ICategoryRepository $categoryRepository,
    ) {
        //
    }

    public function index(Request $request)
    {
        $brandIds = $request->get('brandId') ?? '';
        $categoryIds = $request->get('categoryId') ?? '';
        $showCategory = count(array_filter(explode(',', (string) $categoryIds))) == 1;
        $showBrand = count(array_filter(explode(',', (string) $brandIds))) == 1 && $showCategory === false;

        $brands = $this->brandRepository->setRequiredRelationships(['products'])->getAll(null, 'name', 'asc');
        $brandIds = $request->get('brandId') ?? '';
        $brand = $showBrand ? $brands->where('id', (int) $brandIds)->first() : null;

        $categories = $this->categoryRepository->setRequiredRelationships(['products', 'subcategories'])->getAll(null, 'name', 'asc');
        $categoryIds = $request->get('categoryId') ?? '';
        $category = $showCategory ? $categories->where('id', (int) $categoryIds)->first() : null;

        $size = (int) $request->get('size', 16) ?? 16;
        $orderBy = $request->get('orderBy') ?? -1;
        $orderByColumn = 'created_at';
        $orderDir = 'desc';
        $minPrice = $request->get('minPrice') ?? 1;
        $maxPrice = $request->get('maxPrice') ?? 5000;
        $attributeValueIds = $request->get('attributeValueIds');

        foreach ($this->sortOptions as $sortOption) {
            if ($sortOption['name'] == $orderBy) {
                $orderByColumn = $sortOption['column'];
                $orderDir = $sortOption['direction'];
                break;
            }
        }

        $products = $this->productRepository->setRequiredRelationships(['category', 'brand', 'reviews', 'seller'])->getProductsForShop(
            $size,
            $orderByColumn,
            $orderDir,
            [
                'brandIds' => $brandIds,
                'categoryIds' => $categoryIds,
                'minPrice' => $minPrice,
                'maxPrice' => $maxPrice,
                'attributeValueIds' => $attributeValueIds,
            ]
        );

        $foundBrandIds = $products->pluck('brand_id')->unique();
        $availiableBrands = $brands->whereIn('id', $foundBrandIds);

        if (Auth::check()) {
            // Cart::instance('cart')->store(Auth::user()->email);
            Cart::instance('wishlist')->store(Auth::user()->email);
        }

        Cart::instance('wishlist')->loadWishlistProducts();

        $categoryAttributes = [];
        $categoryAttributeValues = [];

        if (!empty($category)) {
            $categoryAttributes = CategoryAttributes::with('attribute')->where('category_id', $category->id)->get();

            $categoryAttributeValues = $this->categoryRepository->getCategoryAttributeValues($category);
        }

        $viewData = [
            'products' => $products,
            'categoryAttributes' => $categoryAttributes,
            'categoryAttributeValues' => $categoryAttributeValues,
            'category' => $category,
            'brand' => $brand,
            'brands' => $availiableBrands,
            'attributeValueIds' => $attributeValueIds,
            'categories' => $categories,
            'brandId' => $brandIds,
            'categoryId' => $categoryIds,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
            'size' => $size,
            'orderBy' => $orderBy,
            'showOptions' => $this->showOptions,
            'sortOptions' => $this->sortOptions,
            'currency' => config('shop.currency'),
            'cart' => Cart::instance('cart')->content(),
            'wishlist' => Cart::instance('wishlist')->content(),
        ];

        if ($request->ajax()) {
            return response()->json([
                'list' => View::make('front.partials.product-search', $viewData)->render(),
                'breadcrumbs' => View::make('front.partials.shop-topbar', $viewData)->render(),
            ]);
        }

        return view('front.shop', $viewData);
    }

    public function details(string $slug)
    {
        $product = $this->productRepository->setRequiredRelationships(['seller'])->getItemByColumn($slug);

        $productAttributes = $product->productAttributes()->with(['productAttributeValue', 'productAttribute'])->get();
        $attributes = $productAttributes->pluck('productAttribute')->unique();
        $attributeValues = $productAttributes->pluck('productAttributeValue')->groupBy('attribute_id');

        $relatedProducts = $this->productRepository->getCollectionByColumn($product->category_id, 'category_id', 8);
        $otherSellerProducts = $this->productRepository->getPaginated(4, 'created_at', 'desc', ['seller_id' => auth()->id()]);

        return view('front.details', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'currency' => config('shop.currency'),
            'otherSellerProducts' => $otherSellerProducts,
            'attributes' => $attributes,
            'attributeValues' => $attributeValues
        ]);
    }
}
