<?php

namespace App\Services;

use App\Helper;
use App\Repositories\Interfaces\IUserRepository;
use App\Services\Interfaces\IUserService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserService implements IUserService
{
    public function __construct(private IUserRepository $repository)
    {

    }


    public function createUser(array $data)
    {

        $data['password'] = Hash::make($data['password']);

        if (!empty($data['image'])) {
            $filename = time() . '.' . $data['image']->getClientOriginalExtension();
            $data['image']->storeAs('users', $filename, 'public');
            // Thumbnail
            Helper::generateThumbnailImage($data['image'], $filename, 'users');
            $data['image'] = $filename;
        }

        $data['active'] = (empty($data['active']) ? 0 : $data['active'] === 'on') ? 1 : 0;

        $this->repository->create($data);
    }

    public function updateUser(array $data, int $id)
    {
        $user = $this->repository->getById($id);

        if (!empty($data['image'])) {
            if (File::exists(public_path('uploads/users/' . $user->image))) {
                File::delete(public_path('uploads/users/' . $user->image));
            }

            $image = $data['image'];
            $filename = time() . '.' . $image->getClientOriginalExtension();

            $data['image']->storeAs('users', $filename, 'public');

            // Thumbnail
            Helper::generateThumbnailImage($data['image'], $filename, 'users');

            $data['image'] = $filename;
        }

        $this->repository->update($id, $data);
    }

    public function deleteUser(int $id)
    {
        $user = $this->repository->getById($id);

        /*if (File::exists(public_path('uploads/users/' . $user->image))) {
            File::delete(public_path('uploads/users/' . $user->image));
        }*/

        $this->repository->delete($id);
    }
}
