<?php



namespace App\Http\Controllers\Api;

use App\Http\Requests\MassDestroyArticleRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\StoreFaqArticleRequest;
use App\Http\Requests\UpdateFaqArticleRequest;
use App\Http\Resources\Support\ArticleResource;
use App\Models\FaqArticle;
use App\Repositories\Interfaces\Support\IArticleRepository;

class FaqArticleController extends ApiController
{
    public function __construct(private readonly IArticleRepository $iArticleRepository) {}

    public function index(SearchRequest $searchRequest): \Illuminate\Http\JsonResponse
    {
        $values = $this->iArticleRepository->getPaginated(
            $searchRequest->integer('limit'),
            $searchRequest->string('sortBy'),
            $searchRequest->string('sortDir'),
            ['title' => $searchRequest->get('searchText')]
        );

        return $this->sendPaginatedResponse($values, ArticleResource::collection($values));
    }

    public function store(StoreFaqArticleRequest $storeFaqArticleRequest)
    {
        $article = FaqArticle::create($storeFaqArticleRequest->all());
        $article->tags()->sync($storeFaqArticleRequest->input('tags', []));

        if (! $article) {
            return $this->error('Unable to create Article');
        }

        return $this->success($article, 'Article created');
    }

    public function update(UpdateFaqArticleRequest $updateFaqArticleRequest)
    {
        $article = FaqArticle::findOrFail($updateFaqArticleRequest->id);
        $article->update($updateFaqArticleRequest->all());
        $article->tags()->sync($updateFaqArticleRequest->input('tags', []));

        if (! $article) {
            return $this->error('Unable to update Article');
        }

        return $this->success($article, 'Article updated');
    }

    public function destroy(FaqArticle $faqArticle)
    {
        $result = $faqArticle->delete();

        if (! $result) {
            return $this->error('Unable to delete Article');
        }

        return $this->success($result, 'Article deleted');
    }

    public function massDestroy(MassDestroyArticleRequest $massDestroyArticleRequest)
    {
        $result = FaqArticle::whereIn('id', request(key: 'ids'))->delete();

        return response()->json($result);
    }
}
