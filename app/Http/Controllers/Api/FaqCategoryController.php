<?php



namespace App\Http\Controllers\Api;

use App\Http\Requests\MassDestroyFaqCategoryRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\StoreFaqCategoryRequest;
use App\Http\Requests\UpdateFaqCategoryRequest;
use App\Http\Resources\Support\CategoryResource;
use App\Models\FaqCategory;
use App\Repositories\Interfaces\Support\ICategoryRepository;

class FaqCategoryController extends ApiController
{
    public function __construct(private ICategoryRepository $categoryRepository) {}

    public function index(SearchRequest $request)
    {
        $values = $this->categoryRepository->getPaginated(
            $request->integer('limit'),
            $request->string('sortBy'),
            $request->string('sortDir'),
            ['name' => $request->get('searchText')]
        );

        return $this->sendPaginatedResponse($values, CategoryResource::collection($values));
    }

    public function store(StoreFaqCategoryRequest $request)
    {
        $faqCategory = FaqCategory::create($request->all());

        if (! $faqCategory) {
            return $this->error('Unable to create Category');
        }

        return $this->success($faqCategory, 'Category created');
    }

    public function update(UpdateFaqCategoryRequest $request, FaqCategory $faqCategory)
    {
        $faqCategory->update($request->all());

        if (! $faqCategory) {
            return $this->error('Unable to update Category');
        }

        return $this->success($faqCategory, 'Category updated');
    }

    public function destroy(FaqCategory $faqCategory)
    {
        $result = $faqCategory->delete();

        if (! $result) {
            return $this->error('Unable to delete Category');
        }

        return $this->success($result, 'Category deleted');
    }

    public function massDestroy(MassDestroyFaqCategoryRequest $request)
    {
        $result = FaqCategory::whereIn('id', request('ids'))->delete();

        return response()->json($result);
    }
}
