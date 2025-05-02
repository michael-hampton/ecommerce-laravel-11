<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\MassDestroyArticleRequest;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\StoreFaqArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Http\Requests\UpdateFaqArticleRequest;
use App\Http\Resources\Support\ArticleResource;
use App\Models\FaqArticle;
use App\Models\FaqCategory;
use App\Models\FaqTag;
use App\Repositories\Interfaces\Support\IArticleRepository;
use Illuminate\Http\Request;

class FaqArticleController extends ApiController
{
    public function __construct(private IArticleRepository $iArticleRepository) {
    }

    public function index(Request $request)
    {
        $values = $this->iArticleRepository->getPaginated(
            $request->integer('limit'),
            $request->string('sortBy'),
            $request->boolean('sortAsc') === true ? 'asc' : 'desc',
            ['title' => $request->get('searchText')]
        );

        return $this->sendPaginatedResponse($values, ArticleResource::collection($values));
    }

    public function store(StoreFaqArticleRequest $request)
    {
        $article = FaqArticle::create($request->all());
        $article->tags()->sync($request->input('tags', []));

        return response()->json($article);
    }

    public function update(UpdateFaqArticleRequest $request)
    {
        $article = FaqArticle::findOrFail($request->id);
        $article->update($request->all());
        $article->tags()->sync($request->input('tags', []));

        return response()->json($article);
    }

    public function destroy(FaqArticle $article)
    {
        $result = $article->delete();

        return response()->json($result);
    }

    public function massDestroy(MassDestroyArticleRequest $request)
    {
        $result = FaqArticle::whereIn('id', request(key: 'ids'))->delete();

        return response()->json($result);
    }
}
