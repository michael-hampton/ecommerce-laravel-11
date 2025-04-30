<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\BrandResource;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Repositories\Interfaces\ICategoryRepository;
use App\Services\Interfaces\ICategoryService;
use Illuminate\Http\Request;
use Psy\Util\Str;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends ApiController
{
    public function __construct(private ICategoryService $categoryService, private ICategoryRepository $categoryRepository) {

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = $this->categoryRepository->getPaginated(
            $request->integer('limit'),
            $request->string('sortBy'),
            $request->boolean('sortAsc') === true ? 'asc' : 'desc',
            ['name' => $request->get('searchText')]
        );

        return $this->sendPaginatedResponse($categories, CategoryResource::collection($categories));
    }


    /**
     * @param StoreCategoryRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreCategoryRequest $request)
    {
        $result = $this->categoryService->createCategory($request->all());

        return response()->json($result);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * @param UpdateCategoryRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateCategoryRequest $request, int $id)
    {
        $result = $this->categoryService->updateCategory($request->except(['_token', '_method']), $id);

        return response()->json($result);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        $result = $this->categoryService->deleteCategory($id);

        return response()->json($result);
    }

    public function toggleActive(int $id)
    {
       $result = $this->categoryService->toggleActive($id);
       return response()->json($result);
    }
}
