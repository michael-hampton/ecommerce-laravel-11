<?php

declare(strict_types=1);

namespace App\Actions\DeliveryMethod;

use App\Models\Country;
use App\Repositories\DeliveryMethodRepository;

class CreateDeliveryMethod
{
    public function __construct(private DeliveryMethodRepository $repository) {}

    public function handle(array $data)
    {
        $array = array_map(function ($item) use ($data): array {
            return $item + ['country_id' => $data['country_id']];
        }, $data['methods']);

        Country::whereId($data['country_id'])->first()->update(['shipping_active' => true]);

        return $this->repository->insert($array);
    }
}
