<?php

namespace App\Repositories;

use App\Models\AttributeValue;
use App\Repositories\Interfaces\IBaseRepository;
use App\Repositories\Interfaces\IAttributeValueRepository;
use Illuminate\Database\Eloquent\Builder;

class AttributeValueRepository extends BaseRepository implements IAttributeValueRepository
{

    public function __construct(AttributeValue $attributeValue) {
        parent::__construct($attributeValue);
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
