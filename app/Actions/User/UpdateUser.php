<?php

declare(strict_types=1);

namespace App\Actions;

use App\Helper;
use App\Repositories\Interfaces\IUserRepository;
use Illuminate\Support\Facades\File;

class UpdateUser
{
    public function __construct(private IUserRepository $repository) {}

    public function handle(array $data, int $id)
    {
        $user = $this->repository->getById($id);

        if (! empty($data['image'])) {
            if (File::exists(public_path('uploads/users/'.$user->image))) {
                File::delete(public_path('uploads/users/'.$user->image));
            }

            $image = $data['image'];
            $filename = time().'.'.$image->getClientOriginalExtension();

            $data['image']->storeAs('users', $filename, 'public');

            // Thumbnail
            Helper::generateThumbnailImage($data['image'], $filename, 'users');

            $data['image'] = $filename;
        }

        return $this->repository->update($id, $data);
    }
}
