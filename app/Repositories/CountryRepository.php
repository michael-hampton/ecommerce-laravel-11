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
        $query = $this->getQuery();

        $query->when(! empty($searchParams['name']), function (Builder $query) use ($searchParams) {
            $query->where('name', 'like', "%{$searchParams['name']}%");
        });

        $query->when(! empty($searchParams['shipping_active']), function (Builder $query) use ($searchParams) {
            $query->where('shipping_active', $searchParams['shipping_active']);
        });

        return $query;
    }
}
