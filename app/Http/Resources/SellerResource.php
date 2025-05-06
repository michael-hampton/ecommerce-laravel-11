<?php



namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SellerResource extends JsonResource
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
            'profile_picture' => asset('images/sellers').'/'.$this->profile_picture,
            'phone' => $this->phone,
            'email' => $this->email,
            'biography' => $this->biography,
            'city' => $this->city,
            'state' => $this->state,
            'zip' => $this->zip,
            'address1' => $this->address1,
            'address2' => $this->address2,
            'website' => $this->website,
            'active' => $this->active,
            'username' => $this->username,
            'balance_activated' => $this->balance_activated
        ];
    }
}
