<?php

namespace App\Actions;

use App\Helper;
use App\Repositories\Interfaces\ISlideRepository;
use App\Services\Interfaces\ISlideService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class DeleteSlide
{
    public function __construct(private ISlideRepository $repository)
    {

    }

    public function handle(int $id) {
        $slide = $this->repository->getById($id);

        if(File::exists(public_path('images/slides/' . $slide->image))){
            File::delete(public_path('images/slides/' . $slide->image));
        }

        return $this->repository->delete($id);
    }
}
