<?php

namespace App\Repositories;

use App\Models\Attribute;
use App\Models\ProductAttribute;
use App\Repositories\Interfaces\IBaseRepository;
use App\Repositories\Interfaces\IAttributeRepository;
use Illuminate\Database\Eloquent\Builder;

class AttributeRepository extends BaseRepository implements IAttributeRepository
{

    public function __construct(ProductAttribute $attribute) {
        parent::__construct($attribute);
    }

    protected function applyFilters(array $searchParams = []): Builder
    {
        $query = $this->getQuery();

        $query->when(!empty($searchParams['name']), function (Builder $query) use ($searchParams) {
            $query->where('name', 'like', "%{$searchParams['name']}%");
        });

        return $query;
    }
}
