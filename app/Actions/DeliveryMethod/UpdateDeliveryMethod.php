<?php

declare(strict_types=1);

namespace App\Actions\DeliveryMethod;

use App\Models\DeliveryMethod;
use App\Repositories\DeliveryMethodRepository;

class UpdateDeliveryMethod
{
    public function __construct(private readonly DeliveryMethodRepository $deliveryMethodRepository) {}

    public function handle(array $data, int $id): bool
    {
        $create = [];
        $update = [];
        $delete = [];

        $array = array_map(fn($item): array => $item + ['country_id' => $data['country_id']], $data['methods']);

        $current = DeliveryMethod::where('country_id', $data['country_id'])->get();

        foreach ($current as $item) {
            $found = false;

            foreach ($array as $value) {
                if (! empty($value['id']) && $value['id'] === $item['id']) {
                    $found = true;
                }
            }

            if (! $found) {
                $delete[] = $item['id'];
            }
        }

        foreach ($array as $method) {
            if (! empty($method['id'])) {
                $update[] = $method;

                continue;
            }

            $create[] = $method;
        }

        if ($create !== []) {
            $this->deliveryMethodRepository->insert($create);
        }

        foreach ($update as $item) {
            $this->deliveryMethodRepository->update($item['id'], $item);
        }

        foreach ($delete as $item) {
            $this->deliveryMethodRepository->delete($item);
        }

        return true;
    }
}
