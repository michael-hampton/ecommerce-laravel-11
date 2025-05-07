<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\ProductAttribute;
use App\Repositories\Interfaces\IAttributeRepository;
use Illuminate\Database\Eloquent\Builder;

class AttributeRepository extends BaseRepository implements IAttributeRepository
{
    public function __construct(ProductAttribute $productAttribute)
    {
        parent::__construct($productAttribute);
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
