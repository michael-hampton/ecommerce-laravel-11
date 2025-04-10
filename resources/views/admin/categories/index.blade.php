@php use Illuminate\Support\Facades\Session; @endphp
@extends('layouts.admin')
@section('content')
    <div class="p-4">
        <div class="py-4">
            <h3>Categories</h3>
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
                    <a href="{{route('admin.categories.create')}}" class="btn btn-primary">Add New Category</a>
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
                            <th>Slug</th>
                            <th>Products</th>
                            <th>Subcategories</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td>{{$category->id}}</td>
                                <td class="d-flex">
                                    <div class="d-flex align-items-center justify-content-between me-3">
                                        <img src="{{asset('images/categories')}}/{{$category->image}}"
                                             alt="{{$category->name}}" class="image">
                                    </div>
                                    <div class="">
                                        <a href="#" class="fw-bold">{{$category->name}}</a>
                                    </div>
                                </td>
                                <td>{{$category->slug}}</td>
                                <td><a href="#" target="_blank">{{$category->products->count()}}</a></td>
                                <td>
                                    <ul class="sclist">
                                        @foreach($category->subcategories as $scategory)
                                            <li><i class="fa fa-caret-right"></i> {{$scategory->name}}
                                                <a href="{{route('admin.categories.edit',['id'=>$category->id,'scategory_slug'=>$scategory->slug])}}"
                                                   class="slink"><i class="fa fa-edit"></i></a>
                                                <a href="#"
                                                   onclick="confirm('Are you sure, You want to delete this subcategory?') || event.stopImmediatePropagation()"
                                                   wire:click.prevent="deleteSubcategory({{$scategory->id}})"
                                                   class="slink"><i class="fa fa-times text-danger"></i></a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{route('admin.categories.edit', ['id' => $category->id])}}">
                                            <div class="item edit">
                                                <i class="icon-edit-3"></i>
                                            </div>
                                        </a>
                                        <form action="{{route('admin.categories.destroy', ['id' => $category->id])}}"
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
                            <p>No Categories</p>
                        @endforelse

                        </tbody>
                    </table>
                </div>
                <div class="divider"></div>
                <div class="d-flex align-items-center justify-content-between flex-wrap">
                    {{$categories->links('pagination::bootstrap-5')}}
                </div>
            </div>
        </div>
    </div>
@endsection
