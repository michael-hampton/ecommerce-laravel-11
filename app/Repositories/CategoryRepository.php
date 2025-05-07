<?php

declare(strict_types=1);

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
        $builder = $this->getQuery();

        if (empty($searchParams['ignore_active'])) {
            $builder->where('active', true);
        }

        $builder->when(! empty($searchParams['ignore_children']), function (Builder $builder): void {
            $builder->where('parent_id', '=', 0)->orWhere('parent_id', '=', null);
        });

        $builder->when(! empty($searchParams['is_featured']), function (Builder $builder) use ($searchParams): void {
            $builder->where('is_featured', '=', $searchParams['is_featured']);
        });

        $builder->when(! empty($searchParams['name']), function (Builder $builder) use ($searchParams): void {
            $builder->where('name', 'like', sprintf('%%%s%%', $searchParams['name']));
        });

        $builder->when(! empty($searchParams['menu_status']), function (Builder $builder) use ($searchParams): void {
            $builder->where('menu_status', $searchParams['menu_status']);
        });

        return $builder;
    }

    public function getCategoryAttributeValues(Category $category)
    {
        $values = $category->products->map(function ($product) {
            return $product->productAttributes()
                ->with('productAttributeValue')
                ->get();
        })->flatten();

        return $values->groupBy('product_attribute_id');
    }
}
