<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\MassDestroyFaqCategoryRequest;
use App\Http\Requests\StoreFaqCategoryRequest;
use App\Http\Requests\UpdateFaqCategoryRequest;
use App\Http\Resources\Support\CategoryResource;
use App\Models\FaqCategory;
use App\Repositories\Interfaces\Support\ICategoryRepository;
use Illuminate\Http\Request;

class FaqCategoryController extends ApiController
{
    public function __construct(private ICategoryRepository $categoryRepository){}

    public function index(Request $request)
    {
        $values = $this->categoryRepository->getPaginated(
            $request->integer('limit'),
            $request->string('sortBy'),
            $request->boolean('sortAsc') === true ? 'asc' : 'desc',
            ['name' => $request->get('searchText')]
        );

        return $this->sendPaginatedResponse($values, CategoryResource::collection($values));
    }

    public function store(StoreFaqCategoryRequest $request)
    {
        $faqCategory = FaqCategory::create($request->all());

        return response()->json($faqCategory);
    }

    public function update(UpdateFaqCategoryRequest $request, FaqCategory $faqCategory)
    {
        $faqCategory->update($request->all());

        return response()->json($faqCategory);
    }

    public function destroy(FaqCategory $faqCategory)
    {
        $result = $faqCategory->delete();

        return response()->json($result);
    }

    public function massDestroy(MassDestroyFaqCategoryRequest $request)
    {
        $result = FaqCategory::whereIn('id', request('ids'))->delete();

        return response()->json($result);
    }
}
