<?php

declare(strict_types=1);

namespace App\Actions\DeliveryMethod;

use App\Models\Country;
use App\Repositories\DeliveryMethodRepository;

class CreateDeliveryMethod
{
    public function __construct(private readonly DeliveryMethodRepository $deliveryMethodRepository) {}

    public function handle(array $data): bool
    {
        $array = array_map(fn ($item): array => $item + ['country_id' => $data['country_id']], $data['methods']);

        Country::whereId($data['country_id'])->first()->update(['shipping_active' => true]);

        return $this->deliveryMethodRepository->insert($array);
    }
}
