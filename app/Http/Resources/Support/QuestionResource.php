<?php

namespace App\Http\Resources\Support;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            'question' => $this->question,
            'answer' => $this->answer,
            'category' => CategoryResource::make($this->category),
            'category_id' => $this->category_id,
        ];
    }
}
