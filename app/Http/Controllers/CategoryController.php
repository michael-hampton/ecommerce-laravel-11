<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\Interfaces\ICategoryRepository;
use App\Services\CategoryService;
use App\Services\Interfaces\ICategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Psy\Util\Str;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function __construct(private ICategoryService $categoryService, private ICategoryRepository $categoryRepository) {

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->categoryRepository->getAll(null, 'id', 'desc');
        $request = request();

        if (\request()->ajax()) {
            return DataTables::of($categories)->filter(function ($instance) use ($request) {
                if (!empty($request->get('search'))) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        if (\Illuminate\Support\Str::contains(Str::lower($row['name']), Str::lower($request->get('search')))) {
                            return true;
                        }
                        return false;

                    });

                };
            })->make(true);
        }

        return view('admin.categories.index', compact('categories'));
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
