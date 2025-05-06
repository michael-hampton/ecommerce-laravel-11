<?php



namespace App\Actions\DeliveryMethod;

use App\Repositories\DeliveryMethodRepository;

class GetAvailiableDeliveryMethods
{
    public function __construct(private DeliveryMethodRepository $repository) {}

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
        $orderedBySize = $availiableMethods->sortBy(function ($item) use ($order) {
            return array_search($item['name'], $order);
        })->groupBy('name');

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
}
