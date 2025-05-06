<?php



namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DashboardResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'totalAmount' => $this->TotalAmount,
            'totalOrderedAmount' => $this->TotalOrderedAmount,
            'totalDeliveredAmount' => $this->TotalDeliveredAmount,
            'totalCancelledAmount' => $this->TotalCancelledAmount,
            'totalOrdered' => $this->TotalOrdered,
            'totalDelivered' => $this->TotalDelivered,
            'totalCancelled' => $this->TotalCancelled,
            'total' => $this->Total,
        ];
    }
}
