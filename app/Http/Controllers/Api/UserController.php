<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\SlideResource;
use App\Http\Resources\UserResource;
use App\Repositories\Interfaces\IUserRepository;
use App\Services\Interfaces\IUserService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class UserController extends ApiController
{
    public function __construct(private IUserRepository $userRepository, private IUserService  $userService)
    {

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Http\JsonResponse|object
     * @throws \Exception
     */
    public function index(Request $request)
    {
        $users = $this->userRepository->getPaginated(
            $request->integer('limit'),
            $request->string('sortBy'),
            $request->boolean('sortAsc') === true ? 'asc' : 'desc',
            ['name' => $request->get('searchText'), 'ignore_active' => true]
        );

        return $this->sendPaginatedResponse($users, UserResource::collection($users));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $result = $this->userService->createUser($request->all());
        return response()->json($result);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $result = $this->userService->updateUser($request->except(['_token', '_method']), $id);
        return response()->json($result);
    }

    public function updateActive(Request $request, $id)
    {
        $this->userService->updateUser(['active' => $request->boolean('active')], $id);
        return response()->json(['status' => 'success']);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $result = $this->userService->deleteUser($id);

        return response()->json($result);
    }

    public function changeStatus(bool $status, $id)
    {

    }

    public function toggleActive(int $id)
    {
        $result = $this->userService->toggleActive($id);
        return response()->json($result);
    }
}
