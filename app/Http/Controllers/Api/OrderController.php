<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\SearchRequest;
use App\Http\Requests\UpdateOrderStatusRequest;
use App\Http\Resources\OrderDetailResource;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Repositories\Interfaces\IOrderRepository;
use App\Services\Interfaces\IOrderService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends ApiController
{
    public function __construct(private IOrderRepository $orderRepository, private IOrderService $orderService)
    {
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(SearchRequest $request)
    {
        $orders = $this->orderRepository->getPaginated(
            $request->integer('limit'),
            $request->string('sortBy'),
            $request->string('sortDir'),
            ['seller_id' => auth('sanctum')->user()->id, 'name' => $request->get('searchText')]
        );

        return $this->sendPaginatedResponse($orders, OrderResource::collection($orders));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * @param int $orderId
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $orderId)
    {
        $order = Order::with(['logs', 'transaction', 'orderItems', 'customer', 'address'])->whereId($orderId)->firstOrFail();

        $resource = OrderDetailResource::make($order);

        return response()->json($resource);
    }

    /**
     * @param UpdateOrderStatusRequest $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderStatusRequest $request, $id)
    {
        $result = $this->orderService->updateOrder($request->except(['_token', '_method']), $id);

        if (!$result) {
            return $this->error('Unable to update Order');
        }

        return $this->success($result, 'Order updated');
    }

    /**
     * @param UpdateOrderStatusRequest $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function updateItemDetails(UpdateOrderStatusRequest $request, $id)
    {
        $result = $this->orderService->updateOrderLine($request->except(['_token', '_method']), $id);

        if (!$result) {
            return $this->error('Unable to update Order');
        }

        return $this->success($result, 'Order updated');
    }

    /**
     * @param int $orderId
     * @return \Illuminate\Http\JsonResponse
     */
    public function logs(int $orderId) {
        $order = Order::with(['orderItems', 'logs'])->where('id', $orderId)->firstOrFail();

        $orderLogs = $order->logs->sortByDesc('created_at');

        $orderItemLogs = $order->orderItems->map(fn($item) => $item->logs)->flatten()->sortByDesc('created_at');

        return \response()->json($orderLogs->mergeRecursive($orderItemLogs), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
