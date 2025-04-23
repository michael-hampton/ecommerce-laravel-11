<?php

namespace App\Repositories;

use App\Models\Slide;
use App\Repositories\Interfaces\ISlideRepository;
use Illuminate\Database\Eloquent\Builder;

class SlideRepository extends BaseRepository implements ISlideRepository
{
    public function __construct(Slide $slide) {
        parent::__construct($slide);
    }

    protected function applyFilters(array $searchParams = []): Builder
    {
        $query = $this->getQuery();

        $query->when(!empty($searchParams['title']), function (Builder $query) use ($searchParams) {
            $query->where('title', 'like', "%{$searchParams['name']}%");
        });

        return $query;
    }
}
