<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\MassDestroyFaqQuestionRequest;
use App\Http\Requests\SearchRequest;
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
    public function index(SearchRequest $request)
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

        if (!$faqQuestion) {
            return $this->error('Unable to create Question');
        }

        return $this->success($faqQuestion, 'Question created');
    }

    public function update(UpdateFaqQuestionRequest $request, FaqQuestion $faqQuestion)
    {
        $result = $faqQuestion->update($request->all());

        if (!$result) {
            return $this->error('Unable to create Question');
        }

        return $this->success($result, 'Question updated');
    }

    public function destroy(FaqQuestion $faqQuestion)
    {
        $result = $faqQuestion->delete();

        if (!$result) {
            return $this->error('Unable to delete Question');
        }

        return $this->success($result, 'Question deleted');
    }

    public function massDestroy(MassDestroyFaqQuestionRequest $request)
    {
        $result = FaqQuestion::whereIn('id', request('ids'))->delete();

        return response()->json($result);
    }
}
