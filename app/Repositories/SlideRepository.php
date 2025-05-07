<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Slide;
use App\Repositories\Interfaces\ISlideRepository;
use Illuminate\Database\Eloquent\Builder;

class SlideRepository extends BaseRepository implements ISlideRepository
{
    public function __construct(Slide $slide)
    {
        parent::__construct($slide);
    }

    protected function applyFilters(array $searchParams = []): Builder
    {
        $builder = $this->getQuery();

        if (empty($searchParams['ignore_active'])) {
            $builder->where('active', true);
        }

        $builder->when(! empty($searchParams['title']), function (Builder $builder) use ($searchParams): void {
            $builder->where('title', 'like', sprintf('%%%s%%', $searchParams['name']));
        });

        return $builder;
    }
}
