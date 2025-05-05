<?php

namespace App\Actions;

use App\Helper;
use App\Repositories\Interfaces\ISlideRepository;
use App\Services\Interfaces\ISlideService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CreateSlide
{
    public function __construct(private ISlideRepository $repository)
    {

    }
    public function handle(array $data) {
        $filename = time() . '.' . $data['image']->getClientOriginalExtension();
        $data['image']->storeAs('slides', $filename, 'public');

        // Thumbnail
        Helper::generateThumbnailImage($data['image'], $filename, 'slides');
        $data['image'] = $filename;

        return $this->repository->create($data);
    }
}
