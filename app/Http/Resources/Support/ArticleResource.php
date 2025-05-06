<?php



namespace App\Http\Resources\Support;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
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
            'title' => $this->title,
            'category_id' => $this->category_id,
            'short_text' => $this->short_text,
            'full_text' => $this->full_text,
            'category' => $this->category,
            'slug' => $this->slug,
            'tags' => $this->tags,
            'tag_ids' => $this->tags->map(function ($tag) {
                return $tag->id;
            })->toArray(),
        ];
    }
}
