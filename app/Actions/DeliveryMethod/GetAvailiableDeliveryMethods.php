<?php

declare(strict_types=1);

namespace App\Actions\DeliveryMethod;

class GetAvailiableDeliveryMethods
{
    /**
     * @var never[]
     */
    public $shippingSet;

    public function handle($items)
    {
        if ($this->isBulk($items)) {
            return [];
        }

        $availiableMethods = $items->map(function ($item) {
            $shipping = $item->getShippingId();
            if (config('shop.show_multiple_delivery_methods') === true) {
                $shipping->courier->name = $item->model->name.' - '.$shipping->courier->name;
            }

            return $shipping;
        })->flatten();

        if ($availiableMethods->count() === 0) {
            return [];
        }

        if (config('shop.show_multiple_delivery_methods') === true) {
            return $availiableMethods;
        }

        //        echo '<pre>';
        //        print_r($availiableMethods);
        //        die;

        $order = ['Large', 'Medium', 'Small'];

        // Get the largest package size in the cart
        $orderedBySize = $availiableMethods->sortBy(fn (array $item): int|false => array_search($item['name'], $order, true))->groupBy('name');

        if ($orderedBySize->keys()->count() > 1) {
            return [];
        }

        $methods = $orderedBySize->first()->unique();

        if ($items->count() > 1 && $methods->count() === 1) {
            $method = $methods->first();
            $method->price *= $items->count();

            return collect([$method]);
        }

        return $methods;
    }

    private function isBulk($items): bool
    {
        $bySellers = [];
        $this->shippingSet = [];
        foreach ($items as $item) {
            $bySellers[$item->model->seller_id][] = $item->model->id;
        }

        return count(value: $bySellers) === 1;
    }
}
