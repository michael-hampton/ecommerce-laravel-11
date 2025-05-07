<?php

declare(strict_types=1);

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

    public function index(SearchRequest $searchRequest): \Illuminate\Http\JsonResponse
    {
        $values = $this->categoryRepository->getPaginated(
            $searchRequest->integer('limit'),
            $searchRequest->string('sortBy'),
            $searchRequest->string('sortDir'),
            ['name' => $searchRequest->get('searchText')]
        );

        return $this->sendPaginatedResponse($values, CategoryResource::collection($values));
    }

    public function store(StoreFaqCategoryRequest $storeFaqCategoryRequest)
    {
        $faqCategory = FaqCategory::create($storeFaqCategoryRequest->all());

        if (! $faqCategory) {
            return $this->error('Unable to create Category');
        }

        return $this->success($faqCategory, 'Category created');
    }

    public function update(UpdateFaqCategoryRequest $updateFaqCategoryRequest, FaqCategory $faqCategory)
    {
        $faqCategory->update($updateFaqCategoryRequest->all());

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

    public function massDestroy(MassDestroyFaqCategoryRequest $massDestroyFaqCategoryRequest)
    {
        $result = FaqCategory::whereIn('id', request('ids'))->delete();

        return response()->json($result);
    }
}
