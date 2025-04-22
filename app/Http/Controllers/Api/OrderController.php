<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOrderStatusRequest;
use App\Http\Resources\CouponResource;
use App\Http\Resources\OrderResource;
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
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $orders = $this->orderRepository->getPaginated(
            $request->integer('limit'),
            $request->string('sortBy'),
            $request->boolean('sortAsc') === true ? 'asc' : 'desc',
            ['seller_id' => auth('sanctum')->user()->id]
        );

        return $this->sendPaginatedResponse($orders, OrderResource::collection($orders));
    }

    public function orderDetails(int $orderId)
    {
        $items = $this->orderRepository->getOrderDetails($orderId, auth()->id());
        $order = $this->orderRepository->getById($orderId);
        $transaction = $order->transaction()->where('seller_id', auth()->id())->first();

        return view('admin.orders.details', compact('items', 'order', 'transaction'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
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
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(UpdateOrderStatusRequest $request, $id)
    {
        $this->orderService->updateOrder($request->except(['_token', '_method']), $id);
        return back()->with('success', 'Order updated successfully');
    }

    public function updateItemDetails(UpdateOrderStatusRequest $request, $id)
    {
        $this->orderService->updateOrderLine($request->except(['_token', '_method']), $id);
        return back()->with('success', 'Order Line updated successfully');
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
