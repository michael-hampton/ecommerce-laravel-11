<?php



namespace App\Actions;

use App\Helper;
use App\Repositories\Interfaces\IUserRepository;
use Illuminate\Support\Facades\Hash;

class CreateUser
{
    public function __construct(private IUserRepository $repository) {}

    public function handle(array $data)
    {

        $data['password'] = Hash::make($data['password']);

        if (! empty($data['image'])) {
            $filename = time().'.'.$data['image']->getClientOriginalExtension();
            $data['image']->storeAs('users', $filename, 'public');
            // Thumbnail
            Helper::generateThumbnailImage($data['image'], $filename, 'users');
            $data['image'] = $filename;
        }

        $data['active'] = (empty($data['active']) ? 0 : $data['active'] === 'on') ? 1 : 0;

        return $this->repository->create($data);
    }
}
