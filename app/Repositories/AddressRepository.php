<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Address;
use App\Repositories\Interfaces\IAddressRepository;
use Illuminate\Database\Eloquent\Builder;

class AddressRepository extends BaseRepository implements IAddressRepository
{
    public function __construct(Address $address)
    {
        parent::__construct($address);
    }

    protected function applyFilters(array $searchParams = []): Builder
    {
        $builder = $this->getQuery();

        $builder->when(! empty($searchParams['customer_id']), function (Builder $builder) use ($searchParams): void {
            $builder->where('customer_id', $searchParams['customer_id']);
        });

        return $builder;
    }
}
