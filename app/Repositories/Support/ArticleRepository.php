<?php

declare(strict_types=1);

namespace App\Repositories\Support;

use App\Models\FaqArticle;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Support\IArticleRepository;
use Illuminate\Database\Eloquent\Builder;

class ArticleRepository extends BaseRepository implements IArticleRepository
{
    public function __construct(FaqArticle $address)
    {
        parent::__construct($address);
    }

    protected function applyFilters(array $searchParams = []): Builder
    {
        $query = $this->getQuery();

        $query->when(! empty($searchParams['customer_id']), function (Builder $query) use ($searchParams) {
            $query->where('customer_id', $searchParams['customer_id']);
        });

        return $query;
    }
}
