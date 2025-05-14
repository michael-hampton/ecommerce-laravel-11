<?php

namespace App\Http\Controllers\Api;

use App\Actions\Product\ActivateProduct;
use App\Actions\Product\CreateProduct;
use App\Actions\Product\DeleteProduct;
use App\Actions\Product\UpdateProduct;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Repositories\Interfaces\IProductRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends ApiController
{
    public function __construct(
        private readonly IProductRepository $productRepository
    ) {
    }

    /**
     * @param  Request  $searchRequest
     */
    public function index(SearchRequest $searchRequest): JsonResponse
    {
        $searchFilters = $searchRequest->array('searchFilters');
        $searchFilters[] = ['column' => 'seller_id', 'value' => auth('sanctum')->user()->id, 'operator' => '='];

        $products = $this->productRepository->setRequiredRelationships(['orderItems', 'category', 'brand', 'productAttributes'])->getPaginatedWithFilters(
            $searchRequest->integer('limit'),
            $searchRequest->string('sortBy'),
            $searchRequest->string('sortDir'),
            $searchFilters
        );

        return $this->sendPaginatedResponse($products, ProductResource::collection($products));

    }

    /**
     * @return Response
     */
    public function store(StoreProductRequest $storeProductRequest, CreateProduct $createProduct)
    {
        $result = $createProduct->handle($storeProductRequest->all());

        if (!$result) {
            return $this->error('Unable to create Product');
        }

        return $this->success($result, 'Product created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id): void
    {
        //
    }

    /**
     * @return Response
     */
    public function update(UpdateProductRequest $updateProductRequest, int $id, UpdateProduct $updateProduct)
    {
        $result = $updateProduct->handle($updateProductRequest->except(['_token', '_method', 'attr', 'charge_featured']), $id);

        if (!$result) {
            return $this->error('Unable to update Product');
        }

        return $this->success(ProductResource::make($result), 'Product updated');
    }

    /**
     * @return Response
     */
    public function destroy(int $id, DeleteProduct $deleteProduct)
    {
        $result = $deleteProduct->handle($id);

        if (!$result) {
            return $this->error('Unable to delete Product');
        }

        return $this->success($result, 'Product deleted');
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

    public function toggleActive(int $id, ActivateProduct $activateProduct): ?JsonResponse
    {
        $result = $activateProduct->handle($id);

        if (!$result) {
            return $this->error('Unable to update Product');
        }

        return $this->success($result, 'Product updated');
    }
}
