<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Category;
use App\Models\Product;
use App\Repositories\Interfaces\IProductRepository;
use Illuminate\Database\Eloquent\Builder;

class ProductRepository extends BaseRepository implements IProductRepository
{
    public function __construct(Product $product)
    {
        parent::__construct($product);
    }

    public function getHotDeals()
    {
        return $this->model->onSale()
            ->whereRelation('seller', function (Builder $builder): void {
                $builder->where('approved', true);
            })
            ->where('quantity', '>', 0)
            ->where('active', true)
            ->orderBy('name')
            ->limit(4)
            ->inRandomOrder()
            ->get();
    }

    public function getFeaturedProducts()
    {
        return $this->model->featured()
            ->whereRelation('seller', function (Builder $builder): void {
                $builder->where('approved', true);
            })->where('quantity', '>', 0)
            ->where('active', true)
            ->orderBy('name')
            ->inRandomOrder()
            ->limit(4)
            ->get();
    }

    protected function applyFilters(array $searchParams = []): Builder
    {
        $builder = $this->getQuery();

        if (empty($searchParams['ignore_active'])) {
            $builder->where('active', true);
        }

        $builder->when(! empty($searchParams['seller_id']), function (Builder $builder) use ($searchParams): void {
            $builder->where('seller_id', '=', $searchParams['seller_id']);
        });

        $builder->whereRelation('seller', function (Builder $builder): void {
            $builder->where('approved', true);
        });

        $builder->when(! empty($searchParams['brandIds']), function (Builder $builder) use ($searchParams): void {
            $builder->whereIn('brand_id', explode(',', (string) $searchParams['brandIds']));
        });

        $builder->when(! empty($searchParams['attributeValueIds']), function (Builder $builder) use ($searchParams): void {
            $builder->whereHas('productAttributes', function ($query) use ($searchParams): void {
                $query->whereIn('attribute_value_id', explode(',', (string) $searchParams['attributeValueIds']));
            });
        });

        $query->when(! empty($searchParams['categoryIds']), function (Builder $builder) use ($searchParams): void {
            // get children
            $children = Category::whereIn('parent_id', explode(',', (string) $searchParams['categoryIds']))->get();

            $childrenIds = $children->pluck('id')->toArray();
            $parentIds = array_map('intval', explode(',', (string) $searchParams['categoryIds']));
            $ids = empty($childrenIds) ? $parentIds : array_merge($parentIds, $childrenIds);

            $builder->whereIn('category_id', $ids);

        });

        $builder->when(! empty($searchParams['minPrice']), function (Builder $builder) use ($searchParams): void {
            $builder->where('regular_price', '>=', $searchParams['minPrice']);
        });

        $builder->when(! empty($searchParams['maxPrice']), function (Builder $builder) use ($searchParams): void {
            $builder->where('regular_price', '<=', $searchParams['maxPrice']);
        });

        $builder->when(! empty($searchParams['name']), function (Builder $builder) use ($searchParams): void {
            $builder->where('name', 'like', sprintf('%%%s%%', $searchParams['name']));
        });
        
        return $builder;
    }
}
