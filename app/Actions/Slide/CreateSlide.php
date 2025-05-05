<?php

declare(strict_types=1);

namespace App\Actions;

use App\Helper;
use App\Repositories\Interfaces\ISlideRepository;

class CreateSlide
{
    public function __construct(private ISlideRepository $repository) {}

    public function handle(array $data)
    {
        $filename = time().'.'.$data['image']->getClientOriginalExtension();
        $data['image']->storeAs('slides', $filename, 'public');

        // Thumbnail
        Helper::generateThumbnailImage($data['image'], $filename, 'slides');
        $data['image'] = $filename;

        return $this->repository->create($data);
    }
}
