@extends('layouts.app')
@section('content')
    <div class="container mt-4">
        <div class="row">
            @include('front.user.account-nav', ['current' => 'wishlist'])

            <div class="col-lg-9 my-lg-0 my-1">
                <div class="wishlist-table-container">
                    <table class="table table-wishlist mb-0">
                        <thead>
                        <tr>
                            <th class="thumbnail-col"></th>
                            <th class="product-col">Product</th>
                            <th class="price-col">Price</th>
                            <th class="status-col">Stock Status</th>
                            <th class="action-col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($wishlistItems as $item)
                            <tr class="product-row">
                                <td>
                                    <figure class="product-image-container">
                                        <a href="{{route('shop.product.details', ['slug' => $item->model->slug])}}" class="product-image">
                                            <img src="{{asset('images/products/thumbnails')}}/{{$item->model->image}}" alt="product">
                                        </a>

                                        <a href="#" class="btn-remove icon-cancel" title="Remove Product"></a>
                                    </figure>
                                </td>
                                <td>
                                    <h5 class="product-title">
                                        <a href="{{route('shop.product.details', ['slug' => $item->model->slug])}}">{{$item->name}}</a>
                                    </h5>
                                </td>
                                <td class="price-box">{{$item->price}}</td>
                                <td>
                                    <span class="stock-status">{{$item->model->stock_status === 'instock' ? 'In Stock' : 'Out of Stock'}}</span>
                                </td>
                                <td class="action">
                                    <a href="ajax/product-quick-view.html" class="btn btn-quickview mt-1 mt-md-0" title="Quick View">Quick
                                        View</a>

                                    <form name="addtocart-form" method="post" action="{{route('cart.add')}}">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$item->id}}">
                                        <input type="hidden" name="name" value="{{$item->name}}">
                                        <input type="hidden" name="quantity" value="1">
                                        <input type="hidden" name="price"
                                               value="{{!empty($item->model->sale_price) ? $item->model->sale_price : $item->model->regular_price}}">

                                        <button class="btn btn-dark btn-add-cart product-type-simple btn-shop add-to-cart">Add to Cart</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
@endsection





