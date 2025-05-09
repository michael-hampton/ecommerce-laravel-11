<?php

declare(strict_types=1);

namespace App\Actions\DeliveryMethod;

use App\Models\Product;

class GetAvailiableDeliveryMethods
{
    /**
     * @var never[]
     */
    public $shippingSet;

    public function handle($items)
    {
        $products = Product::whereIn("id", $items->pluck("id"))->get()->keyBy('id');


        if ($this->isBulk($products)) {
            return [];
        }
        

        $availiableMethods = $items->map(function ($item) use($products) {
            $product = $products->get($item->id);
            $shipping = $item->getShippingId();
            if (config('shop.show_multiple_delivery_methods') === true) {
                $shipping->courier->name = $product->name.' - '.$shipping->courier->name;
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
            $bySellers[$item->seller_id][] = $item->id;
        }

        return count(value: $bySellers) === 1;
    }
}
