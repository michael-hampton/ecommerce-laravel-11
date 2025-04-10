@php use Illuminate\Support\Facades\Session; @endphp
@extends('layouts.admin')
@section('content')
    <div class="p-4">
        <div class="py-4">
            <h3>Users</h3>
        </div>

        <div class="card py-2 mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="input-group">
                            <input class="form-control border-end-0 border" type="search" placeholder="Search"
                                   id="example-search-input">
                            <span class="input-group-append">
                    <button class="btn btn-outline-secondary bg-white border-start-0 border-bottom-0 border ms-n5"
                            type="button">
                        <i class="fa fa-search"></i>
                    </button>
                </span>
                        </div>
                    </div>
                    <a href="{{route('admin.users.create')}}" class="btn btn-primary">Add New User</a>
                </div>
            </div>
        </div>

        <div class="card p-3">
            <div class="card-body">
                <div class="table-responsive">
                    @if(Session::has('status'))
                        <p class="alert alert-success">{{Session::get('status')}}</p>
                    @endif
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{$user->id}}</td>
                                <td class="d-flex">
                                    <div class="d-flex align-items-center justify-content-between me-3">
                                        <img src="{{asset('images/users')}}/{{$user->image}}"
                                             alt="{{$user->name}}" class="image">
                                    </div>
                                    <div class="">
                                        <a href="#" class="fw-bold">{{$user->name}}</a>
                                    </div>
                                </td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->mobile}}</td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{route('admin.users.edit', ['id' => $user->id])}}">
                                            <div class="item edit">
                                                <i class="icon-edit-3"></i>
                                            </div>
                                        </a>
                                        <form action="{{route('admin.users.destroy', ['id' => $user->id])}}"
                                              method="POST">
                                            @csrf
                                            @method('delete')
                                            <div class="item text-danger delete">
                                                <i class="icon-trash-2"></i>
                                            </div>
                                        </form>

                                        <form>
                                            <div class="form-check form-switch" data-route="{{route('admin.users.updateActive', ['id' => $user->id])}}">
                                                <input class="form-check-input" type="checkbox" role="switch" name="active" id="flexSwitchCheckDefault" @if($user->active === true) checked="checked" @endif>
                                                <label class="form-check-label" for="flexSwitchCheckDefault">Active</label>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <p>No Users</p>
                        @endforelse

                        </tbody>
                    </table>
                </div>
                <div class="divider"></div>
                <div class="d-flex align-items-center justify-content-between">
                    {{$users->links('pagination::bootstrap-5')}}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
            $('[name="active"]').on('change', function () {
               var active = $(this).is(':checked')

                $.ajax({
                    url: $(this).parent().data('route'),
                    type: "post",
                    datatype: "json",
                    data: {active: active, _method: 'put', _token: "{{csrf_token()}}"}
                })
                    .done(function (data) {
                      alert('good')
                    })
                    .fail(function (jqXHR, ajaxOptions, thrownError) {
                        alert('No response from server');
                    });
            });

            $(".delete").on('click', function (e) {
                e.preventDefault();
                var selectedForm = $(this).closest('form');
                swal({
                    title: "Are you sure?",
                    text: "You want to delete this record?",
                    type: "warning",
                    buttons: ["No!", "Yes!"],
                    confirmButtonColor: '#dc3545'
                }).then(function (result) {
                    if (result) {
                        selectedForm.submit();
                    }
                });
            });
        });
    </script>
@endpush


