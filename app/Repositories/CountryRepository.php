<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Country;
use App\Repositories\Interfaces\ICountryRepository;
use Illuminate\Database\Eloquent\Builder;

class CountryRepository extends BaseRepository implements ICountryRepository
{
    public function __construct(Country $country)
    {
        parent::__construct($country);
    }

    protected function applyFilters(array $searchParams = []): Builder
    {
        $builder = $this->getQuery();

        $builder->when(! empty($searchParams['name']), function (Builder $builder) use ($searchParams): void {
            $builder->where('name', 'like', sprintf('%%%s%%', $searchParams['name']));
        });

        $builder->when(! empty($searchParams['shipping_active']), function (Builder $builder) use ($searchParams): void {
            $builder->where('shipping_active', $searchParams['shipping_active']);
        });

        return $builder;
    }
}
