<?php

namespace App\Http\Controllers\Api;

use App\Actions\ActivateUser;
use App\Actions\CreateUser;
use App\Actions\DeleteUser;
use App\Actions\UpdateUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\SlideResource;
use App\Http\Resources\UserResource;
use App\Repositories\Interfaces\IUserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class UserController extends ApiController
{
    public function __construct(private IUserRepository $userRepository)
    {

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Http\JsonResponse|object
     * @throws \Exception
     */
    public function index(SearchRequest $request)
    {
        $users = $this->userRepository->getPaginated(
            $request->integer('limit'),
            $request->string('sortBy'),
            $request->string('sortDir'),
            ['name' => $request->get('searchText'), 'ignore_active' => true]
        );

        return $this->sendPaginatedResponse($users, UserResource::collection($users));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CreateUser $createUser)
    {
        $result = $createUser->handle($request->all());
        
        if (!$result) {
            return $this->error('Unable to create User');
        }

        return $this->success($result, 'User created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * @param UpdateUserRequest $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id, UpdateUser $updateUser)
    {
        $result = $updateUser->handle($request->except(['_token', '_method']), $id);
        
        if (!$result) {
            return $this->error('Unable to update User');
        }

        return $this->success($result, 'User updated');
    }

    public function updateActive(Request $request, $id, UpdateUser $updateUser)
    {
        $result = $updateUser->handle(['active' => $request->boolean('active')], $id);
        
        if (!$result) {
            return $this->error('Unable to update User');
        }

        return $this->success($result, 'User updated');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, DeleteUser $deleteUser)
    {
        $result = $deleteUser->handle($id);

        if (!$result) {
            return $this->error('Unable to delete User');
        }

        return $this->success($result, 'User deleted');
    }

    public function changeStatus(bool $status, $id)
    {

    }

    public function toggleActive(int $id, ActivateUser $activateUser)
    {
        $result = $activateUser->handle($id);
        
        if (!$result) {
            return $this->error('Unable to update User');
        }

        return $this->success($result, 'User updated');
    }
}
