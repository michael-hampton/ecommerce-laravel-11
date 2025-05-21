<?php



namespace App\Http\Controllers\Api\Support;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\MassDestroyFaqCategoryRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\StoreFaqCategoryRequest;
use App\Http\Requests\UpdateFaqCategoryRequest;
use App\Http\Resources\Support\CategoryResource;
use App\Models\FaqCategory;
use App\Repositories\Interfaces\Support\ICategoryRepository;

class FaqCategoryController extends ApiController
{
    public function __construct(private readonly ICategoryRepository $categoryRepository)
    {
    }

    public function search(SearchRequest $searchRequest): \Illuminate\Http\JsonResponse
    {
        $values = $this->categoryRepository->getPaginatedWithFilters(
            $searchRequest->integer('limit'),
            $searchRequest->string('sortBy'),
            $searchRequest->string('sortDir'),
            $searchRequest->array('searchFilters')
        );

        return $this->sendPaginatedResponse($values, CategoryResource::collection($values));
    }

    public function index()
    {
        return $this->success(CategoryResource::collection($this->categoryRepository->getAll(null, 'name', 'asc')), 'Results');
    }

    public function store(StoreFaqCategoryRequest $storeFaqCategoryRequest)
    {
        $faqCategory = FaqCategory::create($storeFaqCategoryRequest->all());

        if (!$faqCategory) {
            return $this->error('Unable to create Category');
        }

        return $this->success($faqCategory, 'Category created');
    }

    public function update(UpdateFaqCategoryRequest $updateFaqCategoryRequest, FaqCategory $faqCategory)
    {
        $faqCategory->update($updateFaqCategoryRequest->all());

        if (!$faqCategory) {
            return $this->error('Unable to update Category');
        }

        return $this->success($faqCategory, 'Category updated');
    }

    public function destroy(FaqCategory $faqCategory)
    {
        $result = $faqCategory->delete();

        if (!$result) {
            return $this->error('Unable to delete Category');
        }

        return $this->success($result, 'Category deleted');
    }

    public function massDestroy(MassDestroyFaqCategoryRequest $massDestroyFaqCategoryRequest)
    {
        $result = FaqCategory::whereIn('id', request('ids'))->delete();

        return response()->json($result);
    }
}
