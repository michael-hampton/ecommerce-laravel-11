<?php



namespace App\Actions\User;

use App\Repositories\Interfaces\IUserRepository;

class ActivateUser
{
    public function __construct(private IUserRepository $repository) {}

    public function handle(int $id)
    {
        $user = $this->repository->getById($id);
        $data = ['active' => $user->active === true ? false : true];

        return $user->update($data);
    }
}
