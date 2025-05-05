<?php

declare(strict_types=1);

namespace App\Actions\DeliveryMethod;

use App\Models\DeliveryMethod;
use App\Repositories\DeliveryMethodRepository;

class UpdateDeliveryMethod
{
    public function __construct(private DeliveryMethodRepository $repository) {}

    public function handle(array $data, int $id): bool
    {
        $create = [];
        $update = [];
        $delete = [];

        $array = array_map(function ($item) use ($data): array {
            return $item + ['country_id' => $data['country_id']];
        }, $data['methods']);

        $current = DeliveryMethod::where('country_id', $data['country_id'])->get();

        foreach ($current as $item) {
            $found = false;

            foreach ($array as $key => $value) {
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

        if (! empty($create)) {
            $this->repository->insert($create);
        }

        if (! empty($update)) {
            foreach ($update as $item) {
                $this->repository->update($item['id'], $item);
            }
        }

        if (! empty($delete)) {
            foreach ($delete as $item) {
                $this->repository->delete($item);
            }
        }

        return true;
    }
}
