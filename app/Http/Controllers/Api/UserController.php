<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Repositories\Interfaces\IUserRepository;
use App\Services\Interfaces\IUserService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
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
        $users = $this->userRepository->getAll(null, 'id', 'desc');

        $collection = UserResource::collection($users)->resolve();

        if ($request->ajax()) {
            return DataTables::of($collection)->filter(function ($instance) use ($request) {
                if (!empty($request->get('search'))) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        if (\Illuminate\Support\Str::contains(Str::lower($row['name']), Str::lower($request->get('search')))) {
                            return true;
                        }
                        return false;

                    });

                };
            })->make(true);
        }

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->userService->createUser($request->all());
        return redirect()->route('admin.users');
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->userRepository->getById($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $this->userService->updateUser($request->except(['_token', '_method']), $id);
        return back()->with('success', 'User updated successfully');
    }

    public function updateActive(Request $request, $id)
    {
        $this->userService->updateUser(['active' => $request->boolean('active')], $id);
        return response()->json(['status' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->userService->deleteUser($id);
        return redirect()->route('admin.users');
    }

    public function changeStatus(bool $status, $id)
    {

    }
}
