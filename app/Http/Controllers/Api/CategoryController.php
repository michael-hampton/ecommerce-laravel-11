<?php



namespace App\Http\Controllers\Api;

use App\Actions\Category\ActivateCategory;
use App\Actions\Category\CreateCategory;
use App\Actions\Category\DeleteCategory;
use App\Actions\Category\UpdateCategory;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Repositories\Interfaces\ICategoryRepository;

class CategoryController extends ApiController
{
    public function __construct(private ICategoryRepository $categoryRepository) {}

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
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request, CreateCategory $createCategory)
    {
        $result = $createCategory->handle($request->all());

        if (! $result) {
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
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, int $id, UpdateCategory $updateCategory)
    {
        $result = $updateCategory->handle($request->except(['_token', '_method']), $id);

        if (! $result) {
            return $this->error('Unable to update Category');
        }

        return $this->success($result, 'Category updated');
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id, DeleteCategory $deleteCategory)
    {
        $result = $deleteCategory->handle($id);

        if (! $result) {
            return $this->error('Unable to delete Category');
        }

        return $this->success($result, 'Category deleted');
    }

    public function toggleActive(int $id, ActivateCategory $activateCategory)
    {
        $result = $activateCategory->handle($id);

        if (! $result) {
            return $this->error('Unable to update Category');
        }

        return $this->success($result, 'Category updated');
    }
}
