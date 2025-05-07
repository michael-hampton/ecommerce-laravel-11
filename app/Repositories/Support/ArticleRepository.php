<?php

declare(strict_types=1);

namespace App\Repositories\Support;

use App\Models\FaqArticle;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Support\IArticleRepository;
use Illuminate\Database\Eloquent\Builder;

class ArticleRepository extends BaseRepository implements IArticleRepository
{
    public function __construct(FaqArticle $faqArticle)
    {
        parent::__construct($faqArticle);
    }

    protected function applyFilters(array $searchParams = []): Builder
    {
        $builder = $this->getQuery();

        $builder->when(! empty($searchParams['customer_id']), function (Builder $builder) use ($searchParams): void {
            $builder->where('customer_id', $searchParams['customer_id']);
        });

        return $builder;
    }
}
