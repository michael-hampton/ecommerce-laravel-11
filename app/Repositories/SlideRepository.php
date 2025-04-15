<?php

namespace App\Repositories;

use App\Models\Slide;
use App\Repositories\Interfaces\ISlideRepository;

class SlideRepository extends BaseRepository implements ISlideRepository
{
    public function __construct(Slide $slide) {
        parent::__construct($slide);
    }
}
