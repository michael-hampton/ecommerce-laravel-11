<?php

declare(strict_types=1);

namespace App\Actions\Slide;

use App\Repositories\Interfaces\ISlideRepository;

class ActivateSlide
{
    public function __construct(private readonly ISlideRepository $slideRepository) {}

    public function handle(int $id)
    {
        $slide = $this->slideRepository->getById($id);
        $data = ['active' => $slide->active !== true];

        return $slide->update($data);
    }
}
