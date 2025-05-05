<?php

declare(strict_types=1);

namespace App\Actions;

use App\Helper;
use App\Repositories\Interfaces\ISlideRepository;
use Illuminate\Support\Facades\File;

class UpdateSlide
{
    public function __construct(private ISlideRepository $repository) {}

    public function handle(array $data, int $id)
    {
        $slide = $this->repository->getById($id);

        if (! empty($data['image'])) {
            if (File::exists(public_path('uploads/slides/'.$slide->image))) {
                File::delete(public_path('uploads/slides/'.$slide->image));
            }

            $image = $data['image'];
            $filename = time().'.'.$image->getClientOriginalExtension();

            $data['image']->storeAs('slides', $filename, 'public');

            // Thumbnail
            Helper::generateThumbnailImage($data['image'], $filename, 'slides');

            $data['image'] = $filename;
        }

        return $this->repository->update($id, $data);
    }
}
