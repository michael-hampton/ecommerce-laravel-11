<?php

namespace App\Actions;

use App\Helper;
use App\Repositories\Interfaces\IUserRepository;
use App\Services\Interfaces\IUserService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class ActivateUser
{
    public function __construct(private IUserRepository $repository)
    {

    }

    public function handle(int $id)
    {
        $user = $this->repository->getById($id);
        $data = ['active' => $user->active === true ? false : true];
        return $user->update($data);
    }
}
