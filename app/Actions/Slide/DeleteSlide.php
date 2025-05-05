<?php

declare(strict_types=1);

namespace App\Actions;

use App\Repositories\Interfaces\ISlideRepository;
use Illuminate\Support\Facades\File;

class DeleteSlide
{
    public function __construct(private ISlideRepository $repository) {}

    public function handle(int $id)
    {
        $slide = $this->repository->getById($id);

        if (File::exists(public_path('images/slides/'.$slide->image))) {
            File::delete(public_path('images/slides/'.$slide->image));
        }

        return $this->repository->delete($id);
    }
}
