<?php

namespace App\Services;

use App\Repositories\DeliveryMethodRepository;
use App\Services\Interfaces\IDeliveryMethodService;

class DeliveryMethodService implements IDeliveryMethodService
{

    public function __construct(private DeliveryMethodRepository $repository)
    {

    }

    public function createDeliveryMethod(array $data)
    {
        return $this->repository->create($data);
    }

    public function updateDeliveryMethod(array $data, int $id)
    {
        $this->repository->update($id, $data);
    }

    public function deleteDeliveryMethod(int $id)
    {
        $this->repository->delete($id);
    }

    public function getAvailiableMethods($items)
    {
        $availiableMethods = $items->map(function ($item) {
            return $item->getShippingId();
        })->flatten();

        if ($availiableMethods->count() === 0) {
            return [];
        }

//        echo '<pre>';
//        print_r($availiableMethods);
//        die;

        $order = ["Large", "Medium", "Small"];

        // Get the largest package size in the cart
        $orderedBySize = $availiableMethods->sortBy(function ($item) use ($order) {
            return array_search($item['name'], $order);
        })->groupBy("name");

        if ($orderedBySize->keys()->count() > 1) {
            return [];
        }

        return $orderedBySize->first();
    }
}
