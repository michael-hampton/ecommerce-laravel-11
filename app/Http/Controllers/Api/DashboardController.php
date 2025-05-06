<?php



namespace App\Http\Controllers\Api;

use App\Http\Resources\DashboardResource;
use Illuminate\Support\Facades\DB;

class DashboardController
{
    public function get()
    {
        $dashboardData = DB::select("Select sum((price + shipping_price)) AS TotalAmount,
                            sum(if(orders.status='ordered', (price + shipping_price), 0)) as TotalOrderedAmount,
                            sum(if(orders.status='delivered', (price + shipping_price), 0)) as TotalDeliveredAmount,
                            sum(if(orders.status='cancelled', (price + shipping_price), 0)) as TotalCancelledAmount,
                              sum(if(orders.status='ordered', 1, 0)) as TotalOrdered,
                            sum(if(orders.status='delivered', 1, 0)) as TotalDelivered,
                            sum(if(orders.status='cancelled', 1, 0)) as TotalCancelled,
                            COUNT(*) AS Total
                            FROM orders
                            INNER JOIN order_items ON order_items.order_id = orders.id
                            WHERE seller_id = ".auth('sanctum')->user()->id.'
                            ');

        return response()->json(DashboardResource::make($dashboardData[0]));
    }
}
