<?php

namespace App\Repositories;

use App\Models\Address;
use App\Models\Brand;
use App\Repositories\Interfaces\IAddressRepository;
use Illuminate\Database\Eloquent\Builder;

class AddressRepository extends BaseRepository implements IAddressRepository
{
    public function __construct(Address $address) {
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
