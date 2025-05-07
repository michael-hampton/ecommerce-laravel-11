<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Brand;
use App\Repositories\Interfaces\IBrandRepository;
use Illuminate\Database\Eloquent\Builder;

class BrandRepository extends BaseRepository implements IBrandRepository
{
    public function __construct(Brand $brand)
    {
        parent::__construct($brand);
    }

    protected function applyFilters(array $searchParams = []): Builder
    {
        $builder = $this->getQuery();

        if (empty($searchParams['ignore_active'])) {
            $builder->where('active', true);
        }

        $builder->when(! empty($searchParams['name']), function (Builder $builder) use ($searchParams): void {
            $builder->where('name', 'like', sprintf('%%%s%%', $searchParams['name']));
        });

        return $builder;
    }
}
