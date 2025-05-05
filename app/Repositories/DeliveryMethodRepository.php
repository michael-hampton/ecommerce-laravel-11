<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\DeliveryMethod;
use App\Repositories\Interfaces\IDeliveryMethodRepository;
use Illuminate\Database\Eloquent\Builder;

class DeliveryMethodRepository extends BaseRepository implements IDeliveryMethodRepository
{
    public function __construct(DeliveryMethod $deliveryMethod)
    {
        parent::__construct($deliveryMethod);
    }

    protected function applyFilters(array $searchParams = []): Builder
    {
        $query = $this->getQuery();

        $query->when(! empty($searchParams['country_id']), function (Builder $query) use ($searchParams) {
            $query->where('country_id', $searchParams['country_id']);
        });

        return $query;
    }
}
