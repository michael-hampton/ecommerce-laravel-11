<?php



namespace App\Actions\User;

use App\Repositories\Interfaces\IUserRepository;
use Illuminate\Support\Facades\File;

class DeleteUser
{
    public function __construct(private IUserRepository $repository) {}

    public function handle(int $id)
    {
        /*$user = $this->repository->getById($id);

        if (File::exists(public_path('uploads/users/' . $user->image))) {
            File::delete(public_path('uploads/users/' . $user->image));
        }*/

        return $this->repository->delete($id);
    }
}
