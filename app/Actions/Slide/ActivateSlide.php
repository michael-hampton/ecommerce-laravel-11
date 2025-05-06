<?php



namespace App\Actions\Slide;

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
