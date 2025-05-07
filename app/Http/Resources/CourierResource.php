<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourierResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'active' => $this->active,
            'countries_active' => collect(explode(',', $this->countries_active))->map(fn ($item) => CountryResource::make(Country::whereId($item)->first())),
        ];
    }
}
