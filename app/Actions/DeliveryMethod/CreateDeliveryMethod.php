<?php

declare(strict_types=1);

namespace App\Actions\DeliveryMethod;

use App\Models\Country;
use App\Models\Courier;
use App\Repositories\DeliveryMethodRepository;

class CreateDeliveryMethod
{
    public function __construct(private readonly DeliveryMethodRepository $deliveryMethodRepository)
    {
    }

    public function handle(array $data): bool
    {
        $rows = array_map(fn($item): array => $item + ['country_id' => $data['country_id']], $data['methods']);

        Country::whereId($data['country_id'])->first()->update(['shipping_active' => true]);

        $result = $this->deliveryMethodRepository->insert($rows);

        $couriers = Courier::all();

        foreach ($rows as $row) {
            $courier = $couriers->where('id', $row['courier_id'])->first();

            Courier::create([
                'country_id' => $data['country_id'],
                'name' => $courier->name,
                'code' => $courier->code
            ]);

            return $result;
        }
    }
}
