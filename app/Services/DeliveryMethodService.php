<?php

namespace App\Services;

use App\Models\Country;
use App\Models\DeliveryMethod;
use App\Repositories\DeliveryMethodRepository;
use App\Services\Interfaces\IDeliveryMethodService;
use function PHPUnit\Framework\returnArgument;

class DeliveryMethodService implements IDeliveryMethodService
{

    public function __construct(private DeliveryMethodRepository $repository)
    {

    }

    public function createDeliveryMethod(array $data)
    {
        $array = array_map(function ($item) use($data):array { return $item + ['country_id' => $data['country_id']]; }, $data['methods']);

        Country::whereId($data['country_id'])->first()->update(['shipping_active' => true]);

        return $this->repository->insert($array);
    }

    public function updateDeliveryMethod(array $data, int $id)
    {
       $create = [];
       $update = [];
       $delete = [];

       $array = array_map(function ($item) use($data):array { return $item + ['country_id' => $data['country_id']]; }, $data['methods']);

       $current = DeliveryMethod::where('country_id', $data['country_id'])->get();


      foreach ($current as $item) {
        $found = false;

        foreach ($array as $key => $value) {
            if(!empty($value['id']) && $value['id'] === $item['id']) {
                $found = true;
            }
        }

        if(!$found) {
            $delete[] = $item['id'];
        }
      }

       foreach($array as $method) {
        if(!empty($method['id'])) {
            $update[] = $method;
            continue;
       }

       $create[] = $method;
    }

    if(!empty($create)) {
        $this->repository->insert($create);
    }

    if(!empty($update)) {
        foreach ($update as $item) {
            $this->repository->update($item['id'], $item);
        }
    }

    if(!empty($delete)) {
        foreach ($delete as $item) {
        $this->repository->delete($item);
        }
    }
    }

    public function deleteDeliveryMethod(int $id)
    {
        $this->repository->delete($id);
    }

    private function isBulk($items) {
        $bySellers = [];
        $this->shippingSet = [];
        foreach ($items as $item) {
            $bySellers[$item->model->seller_id][] = $item->model->id;
        }

        return count(value: $bySellers) === 1;
    }

    public function getAvailiableMethods($items)
    {
        if($this->isBulk($items)) {
            return [];
        }

        $availiableMethods = $items->map(function ($item) {
            $shipping = $item->getShippingId();
            if(config('shop.show_multiple_delivery_methods') === true) {
                 $shipping->courier->name = $item->model->name . ' - ' . $shipping->courier->name;
            }
           
            return $shipping;
        })->flatten();

        if ($availiableMethods->count() === 0) {
            return [];
        }

        if(config('shop.show_multiple_delivery_methods') === true) {
            return $availiableMethods;
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

        $methods = $orderedBySize->first()->unique();

        if ($items->count() > 1 && $methods->count() === 1) {
            $method = $methods->first();
           $method->price *= $items->count();
           return collect([$method]);
        }

        return $methods;
    }
}
