<?php

namespace App\Services;

use App\Helper;
use App\Repositories\Interfaces\ISlideRepository;
use App\Services\Interfaces\ISlideService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SlideService implements ISlideService
{
    public function __construct(private ISlideRepository $repository)
    {

    }
    public function createSlide(array $data) {
        $filename = time() . '.' . $data['image']->getClientOriginalExtension();
        $data['image']->storeAs('slides', $filename, 'public');

        // Thumbnail
        Helper::generateThumbnailImage($data['image'], $filename, 'slides');
        $data['image'] = $filename;

        $this->repository->create($data);
    }

    public function updateSlide(array $data, int $id) {
        $slide = $this->repository->getById($id);

        if(!empty($data['image'])) {
            if(File::exists(public_path('uploads/slides/' . $slide->image))){
                File::delete(public_path('uploads/slides/' . $slide->image));
            }

            $image = $data['image'];
            $filename = time() . '.' . $image->getClientOriginalExtension();

            $data['image']->storeAs('slides', $filename, 'public');

            // Thumbnail
            Helper::generateThumbnailImage($data['image'], $filename, 'slides');

            $data['image'] = $filename;
        }

        $this->repository->update($id, $data);
    }

    public function deleteSlide(int $id) {
        $slide = $this->repository->getById($id);

        if(File::exists(public_path('images/slides/' . $slide->image))){
            File::delete(public_path('images/slides/' . $slide->image));
        }

        $this->repository->delete($id);
    }
}
