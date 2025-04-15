<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Interfaces\ICategoryRepository;
use Illuminate\Database\Eloquent\Builder;

class CategoryRepository extends BaseRepository implements ICategoryRepository
{

    public function __construct(Category $category)
    {
        parent::__construct($category);
    }

    protected function applyFilters(array $searchParams = []): Builder
    {
        $query = $this->getQuery();

        $query->when(!empty($searchParams['ignore_children']), function (Builder $query) use ($searchParams) {
            $query->where('parent_id', '=', 0)->orWhere('parent_id', '=', null);
        });

        return $query;
    }
}
