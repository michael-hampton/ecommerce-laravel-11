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

        $query->where('active', true);

        $query->when(!empty($searchParams['ignore_children']), function (Builder $query) use ($searchParams) {
            $query->where('parent_id', '=', 0)->orWhere('parent_id', '=', null);
        });

        $query->when(!empty($searchParams['is_featured']), function (Builder $query) use ($searchParams) {
            $query->where('is_featured', '=', $searchParams['is_featured']);
        });

        $query->when(!empty($searchParams['name']), function (Builder $query) use ($searchParams) {
            $query->where('name', 'like', "%{$searchParams['name']}%");
        });

        $query->when(!empty($searchParams['menu_status']), function (Builder $query) use ($searchParams) {
            $query->where('menu_status', $searchParams['menu_status']);
        });

        return $query;
    }
}
