<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use App\Repositories\BrandRepository;
use App\Repositories\Interfaces\ICategoryRepository;
use App\Repositories\Interfaces\IProductRepository;
use App\Services\Interfaces\IProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends ApiController
{
    public function __construct(
        private IProductService     $productService,
        private IProductRepository  $productRepository
    )
    {

    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $products = $this->productRepository->getPaginated(
            $request->integer('limit'),
            $request->string('sortBy'),
            $request->boolean('sortAsc') === true ? 'asc' : 'desc',
            [
                'seller_id' => auth('sanctum')->user()->id,
                'name' => $request->get('searchText')
            ]
        );

        return $this->sendPaginatedResponse($products, ProductResource::collection($products));

    }

    /**
     * @param StoreProductRequest $request
     * @return JsonResponse
     */
    public function store(StoreProductRequest $request)
    {
        $result = $this->productService->createProduct($request->all());

        return response()->json($result);
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
     * @param UpdateProductRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $result = $this->productService->updateProduct($request->except(['_token', '_method', 'attr', 'charge_featured']), $id);

        return response()->json($result);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id)
    {
        $result = $this->productService->deleteProduct($id);

        return response()->json($result);
    }

    public function getSubcategories(Request $request)
    {
        $categories = Category::where('parent_id', $request->input('categoryId'))->get();

        return response()->json($categories);
    }

    public function productSearch(Request $request)
    {
        $products = $this->productRepository->getAll(null, 'name', 'asc', ['name' => $request->input('query')]);

        return response()->json($products);
    }
}
