<?php

declare(strict_types=1);

namespace App\Actions\Slide;

use App\Helper;
use App\Models\Slide;
use App\Repositories\Interfaces\ISlideRepository;

class CreateSlide
{
    public function __construct(private readonly ISlideRepository $slideRepository) {}

    public function handle(array $data): Slide
    {
        $filename = time().'.'.$data['image']->getClientOriginalExtension();
        $data['image']->storeAs('slides', $filename, 'public');

        // Thumbnail
        Helper::generateThumbnailImage($data['image'], $filename, 'slides');
        $data['image'] = $filename;

        return $this->slideRepository->create($data);
    }
}
