<?php

namespace App\Repositories\Support;

use App\Models\FaqCategory;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Support\ICategoryRepository;
use Illuminate\Database\Eloquent\Builder;

class CategoryRepository extends BaseRepository implements ICategoryRepository
{
    public function __construct(FaqCategory $address) {
        parent::__construct($address);
    }

    protected function applyFilters(array $searchParams = []): Builder
    {
        $query = $this->getQuery();

        $query->when(!empty($searchParams['customer_id']), function (Builder $query) use ($searchParams) {
            $query->where('customer_id', $searchParams['customer_id']);
        });

        return $query;
    }
}
