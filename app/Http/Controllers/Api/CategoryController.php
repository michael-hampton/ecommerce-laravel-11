<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\SearchRequest;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Repositories\Interfaces\ICategoryRepository;
use App\Services\Interfaces\ICategoryService;

class CategoryController extends ApiController
{
    public function __construct(private ICategoryService $categoryService, private ICategoryRepository $categoryRepository) {

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SearchRequest $request)
    {
        $categories = $this->categoryRepository->getPaginated(
            $request->integer('limit'),
            $request->string('sortBy'),
            $request->string('sortDir'),
            ['name' => $request->get('searchText'), 'ignore_active' => true]
        );

        return $this->sendPaginatedResponse($categories, CategoryResource::collection($categories));
    }


    /**
     * @param StoreCategoryRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        $result = $this->categoryService->createCategory($request->all());

        if (!$result) {
            return $this->error('Unable to create Category');
        }

        return $this->success($result, 'Category created');

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
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, int $id)
    {
        $result = $this->categoryService->updateCategory($request->except(['_token', '_method']), $id);

        if (!$result) {
            return $this->error('Unable to update Category');
        }

        return $this->success($result, 'Category updated');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $result = $this->categoryService->deleteCategory($id);

        if (!$result) {
            return $this->error('Unable to delete Category');
        }

        return $this->success($result, 'Category deleted');
    }

    public function toggleActive(int $id)
    {
       $result = $this->categoryService->toggleActive($id);

       if (!$result) {
        return $this->error('Unable to update Category');
    }

    return $this->success($result, 'Category updated');
    }
}
