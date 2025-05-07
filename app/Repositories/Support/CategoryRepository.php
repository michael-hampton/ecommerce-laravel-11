<?php

declare(strict_types=1);

namespace App\Repositories\Support;

use App\Models\FaqCategory;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Support\ICategoryRepository;
use Illuminate\Database\Eloquent\Builder;

class CategoryRepository extends BaseRepository implements ICategoryRepository
{
    public function __construct(FaqCategory $faqCategory)
    {
        parent::__construct($faqCategory);
    }

    protected function applyFilters(array $searchParams = []): Builder
    {
        $builder = $this->getQuery();

        $builder->when(! empty($searchParams['name']), function (Builder $builder) use ($searchParams): void {
            $builder->where('name', 'like', sprintf('%%%s%%', $searchParams['name']));
        });

        return $builder;
    }
}
