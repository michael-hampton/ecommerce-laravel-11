<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\SearchRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Repositories\Interfaces\IProductRepository;
use App\Services\Interfaces\IProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends ApiController
{
    public function __construct(
        private IProductService $productService,
        private IProductRepository $productRepository
    ) {

    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(SearchRequest $request)
    {
        $products = $this->productRepository->getPaginated(
            $request->integer('limit'),
            $request->string('sortBy'),
            $request->string('sortDir'),
            [
                'seller_id' => auth('sanctum')->user()->id,
                'name' => $request->get('searchText'),
                'ignore_active' => true
            ]
        );

        return $this->sendPaginatedResponse($products, ProductResource::collection($products));

    }

    /**
     * @param StoreProductRequest $request
     * @return Response
     */
    public function store(StoreProductRequest $request)
    {
        $result = $this->productService->createProduct($request->all());

        if (!$result) {
            return $this->error('Unable to create Product');
        }

        return $this->success($result, 'Product created');
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
     * @return Response
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $result = $this->productService->updateProduct($request->except(['_token', '_method', 'attr', 'charge_featured']), $id);

        if (!$result) {
            return $this->error('Unable to update Product');
        }

        return $this->success($result, 'Product updated');
    }

    /**
     * @param int $id
     * @return Response
     */
    public function destroy(int $id)
    {
        $result = $this->productService->deleteProduct($id);

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

    public function toggleActive(int $id)
    {
        $result = $this->productService->toggleActive($id);

        if (!$result) {
            return $this->error('Unable to update Category');
        }
    }
}
