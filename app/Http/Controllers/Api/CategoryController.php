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
        );

        return $this->sendPaginatedResponse($categories, CategoryResource::collection($categories));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->categoryRepository->getAll();
        return view('admin.categories.create', compact('categories'));
    }

    /**
     * @param StoreCategoryRequest $request
     * @return void
     */
    public function store(StoreCategoryRequest $request)
    {
        $result = $this->categoryService->createCategory($request->all());

        return redirect()->route('admin.categories')->with('success', 'Category created successfully.');
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $categories = $this->categoryRepository->getAll();
        $category = Category::find($id);
        return view('admin.categories.edit', compact('category', 'categories'));
    }

    /**
     * @param UpdateCategoryRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateCategoryRequest $request, int $id)
    {
        $result = $this->categoryService->updateCategory($request->except(['_token', '_method']), $id);

        return redirect()->route('admin.categories')->with('success', 'Category updated successfully.');
    }

    /**
     * @param int $id
     * @return void
     */
    public function destroy(int $id)
    {
        $result = $this->categoryService->deleteCategory($id);

        return redirect()->route('admin.categories')->with('success', 'Category deleted successfully.');
    }
}
