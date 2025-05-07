<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Repositories\Interfaces\IUserRepository;
use Illuminate\Support\Facades\File;

class DeleteUser
{
    public function __construct(private IUserRepository $userRepository) {}

    public function handle(int $id)
    {
        /*$user = $this->repository->getById($id);

        if (File::exists(public_path('uploads/users/' . $user->image))) {
            File::delete(public_path('uploads/users/' . $user->image));
        }*/

        return $this->userRepository->delete($id);
    }
}
