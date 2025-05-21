<?php



namespace App\Http\Controllers\Api\Support;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\MassDestroyFaqQuestionRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\StoreFaqQuestionRequest;
use App\Http\Requests\UpdateFaqQuestionRequest;
use App\Http\Resources\Support\QuestionResource;
use App\Models\FaqQuestion;
use App\Repositories\Interfaces\Support\IQuestionRepository;

class FaqQuestionController extends ApiController
{
    public function __construct(private readonly IQuestionRepository $questionRepository) {}

    public function index(SearchRequest $searchRequest): \Illuminate\Http\JsonResponse
    {
        $values = $this->questionRepository->getPaginatedWithFilters(
            $searchRequest->integer('limit'),
            $searchRequest->string('sortBy'),
            $searchRequest->string('sortDir'),
            $searchRequest->array('searchFilters')
         );

        return $this->sendPaginatedResponse($values, QuestionResource::collection($values));
    }

    public function store(StoreFaqQuestionRequest $storeFaqQuestionRequest)
    {
        $faqQuestion = FaqQuestion::create($storeFaqQuestionRequest->all());

        if (! $faqQuestion) {
            return $this->error('Unable to create Question');
        }

        return $this->success($faqQuestion, 'Question created');
    }

    public function update(UpdateFaqQuestionRequest $updateFaqQuestionRequest, FaqQuestion $faqQuestion)
    {
        $result = $faqQuestion->update($updateFaqQuestionRequest->all());

        if (! $result) {
            return $this->error('Unable to create Question');
        }

        return $this->success($result, 'Question updated');
    }

    public function destroy(FaqQuestion $faqQuestion)
    {
        $result = $faqQuestion->delete();

        if (! $result) {
            return $this->error('Unable to delete Question');
        }

        return $this->success($result, 'Question deleted');
    }

    public function massDestroy(MassDestroyFaqQuestionRequest $massDestroyFaqQuestionRequest)
    {
        $result = FaqQuestion::whereIn('id', request('ids'))->delete();

        return response()->json($result);
    }
}
