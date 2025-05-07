<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Repositories\Interfaces\IUserRepository;

class ActivateUser
{
    public function __construct(private readonly IUserRepository $userRepository) {}

    public function handle(int $id)
    {
        $user = $this->userRepository->getById($id);
        $data = ['active' => $user->active !== true];

        return $user->update($data);
    }
}
