@php use Illuminate\Support\Facades\Session; @endphp
@extends('layouts.admin')
@section('content')
    <div class="p-4">
        <div class="py-4">
            <h3>Products</h3>
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
                    <a href="{{route('admin.products.create')}}" class="btn btn-primary">Add New Product</a>
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
                            <th>Price</th>
                            <th>SalePrice</th>
                            <th>SKU</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Featured</th>
                            <th>Stock</th>
                            <th>Quantity</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>{{$product->id}}</td>
                                <td class="d-flex">
                                    <div class="d-flex align-items-center justify-content-between me-3">
                                        <img src="{{asset('images/products')}}/{{$product->image}}"
                                             alt="{{$product->name}}" class="image">
                                    </div>
                                    <div class="">
                                        <a href="#" class="fw-bold">{{$product->name}}</a>
                                        <div class="text-tiny mt-3">{{$product->sku}}</div>
                                    </div>
                                </td>
                                <td>{{$product->regular_price}}</td>
                                <td>{{$product->sale_price}}</td>
                                <td>{{$product->sku}}</td>
                                <td>{{$product->category->name}}</td>
                                <td>{{$product->brand->name}}</td>
                                <td>{{$product->featured}}</td>
                                <td>{{$product->stock_status}}</td>
                                <td>{{$product->quantity}}</td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <a href="#" target="_blank">
                                            <div class="item eye">
                                                <i class="icon-eye"></i>
                                            </div>
                                        </a>
                                        <a href="{{route('admin.products.edit', ['id' => $product->id])}}">
                                            <div class="item edit">
                                                <i class="icon-edit-3"></i>
                                            </div>
                                        </a>
                                        <form action="{{route('admin.products.destroy', ['id' => $product->id])}}"
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
                            <p>No Products</p>
                        @endforelse

                        </tbody>
                    </table>
                </div>

                <div class="divider"></div>
                <div class="d-flex align-items-center justify-content-between flex-wrap">
                    {{$products->links('pagination::bootstrap-5')}}

                </div>
            </div>
        </div>
    </div>
@endsection


