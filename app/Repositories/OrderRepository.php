<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Interfaces\IOrderRepository;
use Illuminate\Database\Eloquent\Builder;

class OrderRepository extends BaseRepository implements IOrderRepository
{
    public function __construct(Order $order)
    {
        parent::__construct($order);
    }

    public function getOrderDetails(int $orderId, int $sellerId)
    {
        return $this->model->where('id', $orderId)->firstOrFail()->orderItems->where('seller_id', $sellerId)->all();
    }

    protected function applyFilters(array $searchParams = []): Builder
    {
        $builder = $this->getQuery();

        $builder->when(! empty($searchParams['seller_id']), function (Builder $builder) use ($searchParams): void {
            $builder->whereHas('orderItems', function (Builder $builder) use ($searchParams): void {
                $builder->where('seller_id', $searchParams['seller_id']);
            });
        });

        $query->when(! empty($searchParams['customer_id']), function (Builder $builder) use ($searchParams): void {
            $builder->where('customer_id', $searchParams['customer_id']);
        });

        return $builder;
    }
}
