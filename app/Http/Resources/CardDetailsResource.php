<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CardDetailsResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'card_type' => $this->card_type,
            'card_sort_code' => $this->sort_code,
            'card_cvv' => $this->card_cvv,
            'card_name' => $this->card_name,
            'card_expiry_date' => $this->card_expiry_date,
            'card_number' =>substr($this->card_number, -4),
            'formatted_card_number' => substr($this->card_number, 0, 4).str_repeat('*', strlen($this->card_number) - 8).substr($this->card_number, -4),
        ];
    }
}
