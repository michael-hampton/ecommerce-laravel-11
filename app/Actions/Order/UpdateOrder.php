<?php

declare(strict_types=1);

namespace App\Actions\Order;

use App\Events\OrderStatusUpdated;
use App\Models\Order;
use App\Repositories\Interfaces\IAddressRepository;
use App\Repositories\Interfaces\IOrderRepository;

use function auth;

class UpdateOrder
{
    public function __construct(private IOrderRepository $repository, private IAddressRepository $addressRepository) {}

    public function handle(array $data, int $id): Order
    {
        $orderData = ['status' => $data['status']];

        if ($data['status'] === 'delivered') {
            $orderData['delivered_date'] = now();
        }

        if ($data['status'] === 'cancelled') {
            $orderData['cancelled_date'] = now();
        }

        if (! empty($data['tracking_number'])) {
            $orderData['tracking_number'] = $data['tracking_number'];
        }

        if ($data['courier_id']) {
            $orderData['courier_id'] = $data['courier_id'];
        }

        $this->repository->update($id, $orderData);

        if ($data['status'] === 'delivered') {
            $order = $this->repository->getById($id);
            $transaction = $order->transaction->where('seller_id', auth()->id())->first();
            $transaction->payment_status = $data['status'] === 'delivered' ? 'approved' : 'refunded';
            $transaction->save();
        }

        $order = $this->repository->getById($id);

        event(new OrderStatusUpdated($order, $order->orderItems, $data));

        return $order;
    }
}
