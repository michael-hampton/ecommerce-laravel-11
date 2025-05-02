<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\MassDestroyFaqQuestionRequest;
use App\Http\Requests\StoreFaqQuestionRequest;
use App\Http\Requests\UpdateFaqQuestionRequest;
use App\Http\Resources\Support\QuestionResource;
use App\Models\FaqQuestion;
use App\Repositories\Interfaces\Support\IQuestionRepository;
use Illuminate\Http\Request;

class FaqQuestionController extends ApiController
{
    public function __construct(private IQuestionRepository $questionRepository) {
    }
    public function index(Request $request)
    {
        $values = $this->questionRepository->getPaginated(
            $request->integer('limit'),
            $request->string('sortBy'),
            $request->boolean('sortAsc') === true ? 'asc' : 'desc',
            ['name' => $request->get('searchText')]
        );

        return $this->sendPaginatedResponse($values, QuestionResource::collection($values));
    }

    public function store(StoreFaqQuestionRequest $request)
    {
        $faqQuestion = FaqQuestion::create($request->all());

        return response()->json($faqQuestion);
    }

    public function update(UpdateFaqQuestionRequest $request, FaqQuestion $faqQuestion)
    {
        $result = $faqQuestion->update($request->all());

        return response()->json($result);
    }

    public function destroy(FaqQuestion $faqQuestion)
    {
        $result = $faqQuestion->delete();

        return response()->json($result);
    }

    public function massDestroy(MassDestroyFaqQuestionRequest $request)
    {
        $result = FaqQuestion::whereIn('id', request('ids'))->delete();

        return response()->json($result);
    }
}
