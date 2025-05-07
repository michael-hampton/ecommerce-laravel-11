<?php

declare(strict_types=1);

namespace App\Actions\Slide;

use App\Repositories\Interfaces\ISlideRepository;
use Illuminate\Support\Facades\File;

class DeleteSlide
{
    public function __construct(private ISlideRepository $slideRepository) {}

    public function handle(int $id)
    {
        $slide = $this->slideRepository->getById($id);

        if (File::exists(public_path('images/slides/'.$slide->image))) {
            File::delete(public_path('images/slides/'.$slide->image));
        }

        return $this->slideRepository->delete($id);
    }
}
