<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\AttributeValue;
use App\Models\ProductAttributeValue;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Repositories\BrandRepository;
use App\Repositories\Interfaces\ICategoryRepository;
use App\Repositories\Interfaces\IProductRepository;
use App\Services\Interfaces\IProductService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function __construct(
        private IProductService $productService,
        private IProductRepository $productRepository,
        private ICategoryRepository $categoryRepository,
        private BrandRepository $brandRepository
    ) {

    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $products = $this->productRepository->getPaginated(
            10,
            'id',
            'desc',
            ['seller_id' => auth()->user()->id]
        );
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $categories = $this->categoryRepository->getAll(null, 'name', 'asc', ['ignore_children' => true]);
        $brands = $this->brandRepository->getAll();
        $pattributes = ProductAttribute::all();
        $productAttributeValues = AttributeValue::all()->keyBy('attribute_id');

        return view('admin.products.create', compact('categories', 'brands', 'pattributes', 'productAttributeValues'));
    }

    /**
     * @param StoreProductRequest $request
     * @return void
     */
    public function store(StoreProductRequest $request)
    {
        $result = $this->productService->createProduct($request->all());

        return redirect()->route('admin.products')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit(int $id)
    {
        $categories = $this->categoryRepository->getAll(null, 'name', 'asc', ['ignore_children' => true]);
        $brands = $this->brandRepository->getAll();
        $product = Product::find($id);

           $subcategories = $product->category->parent ? $product->category->parent->subcategories : [];

        $productAttributeValues = ProductAttributeValue::where('product_id', $product->id)->get();
        $productAttributes = ProductAttribute::all();
        return view('admin.products.edit', compact('product', 'categories', 'brands', 'productAttributeValues', 'productAttributeValues', 'productAttributes', 'subcategories'));
    }

    /**
     * @param UpdateProductRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $result = $this->productService->updateProduct($request->except(['_token', '_method', 'attr']), $id);

        return redirect()->route('admin.products')->with('success', 'Product updated successfully.');
    }

    /**
     * @param int $id
     * @return void
     */
    public function destroy(int $id)
    {
        $result = $this->productService->deleteProduct($id);

        return redirect()->route('admin.products')->with('success', 'Product deleted successfully.');
    }

    public function getSubcategories(Request $request) {
        $categories = Category::where('parent_id', $request->input('categoryId'))->get();

       return response()->json($categories);
    }

    public function productSearch(Request $request) {
        $products = $this->productRepository->getAll(null, 'name', 'asc', ['name' => $request->input('query')]);

        return response()->json($products);
    }
}
