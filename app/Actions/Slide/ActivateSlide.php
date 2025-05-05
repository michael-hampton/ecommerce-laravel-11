<?php

declare(strict_types=1);

namespace App\Actions;

use App\Repositories\Interfaces\ISlideRepository;

class ActivateSlide
{
    public function __construct(private ISlideRepository $repository) {}

    public function handle(int $id)
    {
        $slide = $this->repository->getById($id);
        $data = ['active' => $slide->active === true ? false : true];

        return $slide->update($data);
    }
}
