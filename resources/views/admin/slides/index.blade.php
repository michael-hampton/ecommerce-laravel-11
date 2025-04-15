@php use Illuminate\Support\Facades\Session; @endphp
@extends('layouts.admin')
@section('content')
    <div class="p-4">
        <div class="py-4">
            <h3>Slides</h3>
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
                    <a href="{{route('admin.slides.create')}}" class="btn btn-primary">Add New Slide</a>
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
                            <th>Image</th>
                            <th>Tags</th>
                            <th>Title</th>
                            <th>SubTitle</th>
                            <th>Link</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($slides as $slide)
                            <tr>
                                <td>{{$slide->id}}</td>
                                <td class="d-flex">
                                    <div class="d-flex align-items-center justify-content-between me-3">
                                        <img src="{{asset('images/slides')}}/{{$slide->image}}"
                                             alt="{{$slide->title}}" class="image">
                                    </div>
                                </td>
                                <td>{{$slide->tags}}</td>
                                <td>{{$slide->title}}</td>
                                <td>{{$slide->subtitle}}</td>
                                <td><a href="{{$slide->link}}" target="_blank">{{$slide->link}}</a></td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{route('admin.slides.edit', ['id' => $slide->id])}}">
                                            <div class="item edit">
                                                <i class="icon-edit-3"></i>
                                            </div>
                                        </a>
                                        <form action="{{route('admin.slides.destroy', ['id' => $slide->id])}}"
                                              method="POST">
                                            @csrf
                                            @method('delete')
                                            <div class="item text-danger delete">
                                                <i class="icon-trash-2"></i>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <p>No Slides</p>
                        @endforelse

                        </tbody>
                    </table>
                </div>
                <div class="divider"></div>
                <div class="d-flex align-items-center justify-content-between">
                    {{$slides->links('pagination::bootstrap-5')}}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
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


