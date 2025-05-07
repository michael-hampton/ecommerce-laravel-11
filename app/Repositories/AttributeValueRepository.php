<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\AttributeValue;
use App\Repositories\Interfaces\IAttributeValueRepository;
use Illuminate\Database\Eloquent\Builder;

class AttributeValueRepository extends BaseRepository implements IAttributeValueRepository
{
    public function __construct(AttributeValue $attributeValue)
    {
        parent::__construct($attributeValue);
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
