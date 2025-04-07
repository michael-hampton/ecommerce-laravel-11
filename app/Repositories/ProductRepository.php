<?php

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

    public function getHotDeals() {
        return $this->model->onSale()->whereRelation('seller', function (Builder $query) {
            $query->where('approved', true);
        })->where('quantity', '>', 0)->orderBy('name')->inRandomOrder()->get();
    }

    public function getFeaturedProducts() {
        return $this->model->featured()->whereRelation('seller', function (Builder $query) {
            $query->where('approved', true);
        })->where('quantity', '>', 0)->orderBy('name')->inRandomOrder()->get();
    }

    /**
     * @param array $searchParams
     * @return Builder
     */
    protected function applyFilters(array $searchParams = []): Builder
    {
        $query = $this->getQuery();

        $query->when(!empty($searchParams['seller_id']), function (Builder $query) use ($searchParams) {
            $query->where('seller_id', '=', $searchParams['seller_id']);
        });

        $query->whereRelation('seller', function(Builder $query) use ($searchParams) {
            $query->where('approved', true);
        });

        $query->when(!empty($searchParams['brandIds']), function (Builder $query) use ($searchParams) {
            $query->whereIn('brand_id', explode(',', $searchParams['brandIds']));
        });

        $query->when(!empty($searchParams['categoryIds']), function (Builder $query) use ($searchParams) {
            // get children
            $children = Category::whereIn('parent_id', explode(',', $searchParams['categoryIds']))->get();

            $childrenIds = $children->pluck('id')->toArray();
            $parentIds = array_map('intval', explode(',', $searchParams['categoryIds']));
            $ids = !empty($childrenIds) ? array_merge($parentIds, $childrenIds) : $parentIds;

            $query->whereIn('category_id', $ids);

        });

        $query->when(!empty($searchParams['minPrice']), function (Builder $query) use ($searchParams) {
            $query->where('regular_price', '>=', $searchParams['minPrice']);
        });

        $query->when(!empty($searchParams['maxPrice']), function (Builder $query) use ($searchParams) {
            $query->where('regular_price', '<=', $searchParams['maxPrice']);
        });

        $query->when(isset($searchParams['name']), function (Builder $query) use ($searchParams) {
            $query->where('name', 'like', "%{$searchParams['name']}%");
        });

        return $query;
    }
}
