<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOrderStatusRequest;
use App\Http\Resources\CouponResource;
use App\Http\Resources\OrderDetailResource;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderLog;
use App\Repositories\Interfaces\IOrderRepository;
use App\Services\Interfaces\IOrderService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends ApiController
{
    public function __construct(private IOrderRepository $orderRepository, private IOrderService $orderService)
    {
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $orders = $this->orderRepository->getPaginated(
            $request->integer('limit'),
            $request->string('sortBy'),
            $request->boolean('sortAsc') === true ? 'asc' : 'desc',
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateOrderStatusRequest $request, $id)
    {
        $result = $this->orderService->updateOrder($request->except(['_token', '_method']), $id);

        return response()->json($result);
    }

    /**
     * @param UpdateOrderStatusRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateItemDetails(UpdateOrderStatusRequest $request, $id)
    {
        $result = $this->orderService->updateOrderLine($request->except(['_token', '_method']), $id);

        return response()->json($result);
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
