<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Order\UpdateOrder;
use App\Actions\Order\UpdateOrderLine;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\UpdateOrderStatusRequest;
use App\Http\Resources\OrderDetailResource;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Repositories\Interfaces\IOrderRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends ApiController
{
    public function __construct(private IOrderRepository $orderRepository) {}

    /**
     * @param Request $searchRequest
     */
    public function index(SearchRequest $searchRequest): \Illuminate\Http\JsonResponse
    {
        $orders = $this->orderRepository->getPaginated(
            $searchRequest->integer('limit'),
            $searchRequest->string('sortBy'),
            $searchRequest->string('sortDir'),
            ['seller_id' => auth('sanctum')->user()->id, 'name' => $searchRequest->get('searchText')]
        );

        return $this->sendPaginatedResponse($orders, OrderResource::collection($orders));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): void
    {
        //
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $orderId)
    {
        $order = Order::with(['logs', 'transaction', 'orderItems', 'customer', 'address'])->whereId($orderId)->firstOrFail();

        $orderDetailResource = OrderDetailResource::make($order);

        return response()->json($orderDetailResource);
    }

    /**
     * @return Response
     */
    public function update(UpdateOrderStatusRequest $updateOrderStatusRequest, int $id, UpdateOrder $updateOrder)
    {
        $order = $updateOrder->handle($updateOrderStatusRequest->except(['_token', '_method']), $id);

        if (! $order) {
            return $this->error('Unable to update Order');
        }

        return $this->success($order, 'Order updated');
    }

    /**
     * @return Response
     */
    public function updateItemDetails(UpdateOrderStatusRequest $updateOrderStatusRequest, int $id, UpdateOrderLine $updateOrderLine)
    {
        $result = $updateOrderLine->handle($updateOrderStatusRequest->except(['_token', '_method']), $id);

        if (! $result) {
            return $this->error('Unable to update Order');
        }

        return $this->success($result, 'Order updated');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function logs(int $orderId)
    {
        $order = Order::with(['orderItems', 'logs'])->where('id', $orderId)->firstOrFail();

        $orderLogs = $order->logs->sortByDesc('created_at');

        $orderItemLogs = $order->orderItems->map(fn ($item) => $item->logs)->flatten()->sortByDesc('created_at');

        return \response()->json($orderLogs->mergeRecursive($orderItemLogs), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id): void
    {
        //
    }
}
