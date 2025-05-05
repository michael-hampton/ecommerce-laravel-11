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
        $query = $this->getQuery();

        if (empty($searchParams['ignore_active'])) {
            $query->where('active', true);
        }

        $query->when(! empty($searchParams['name']), function (Builder $query) use ($searchParams) {
            $query->where('name', 'like', "%{$searchParams['name']}%");
        });

        return $query;
    }
}
