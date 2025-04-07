@php use App\Services\Cart\Facade\Cart; @endphp
@extends('layouts.app')
@section('content')
    <style>
        .cart-item img {
            max-width: 100px;
            height: auto;
        }

        .quantity-input {
            width: 50px;
            height: 35px;
        }

        .cart-summary {
            background-color: #f8f9fa;
            border-radius: 10px;
        }
    </style>

    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="shop-checkout container">
            <h2 class="page-title">Wishlist</h2>
            <div class="checkout-steps mb-5">
                <a href="shop_cart.html" class="checkout-steps__item active">
                    <span class="checkout-steps__item-number">01</span>
                    <span class="checkout-steps__item-title">
            <span>Shopping Bag</span>
            <em>Manage Your Items List</em>
          </span>
                </a>
                <a href="shop_checkout.html" class="checkout-steps__item">
                    <span class="checkout-steps__item-number">02</span>
                    <span class="checkout-steps__item-title">
            <span>Shipping and Checkout</span>
            <em>Checkout Your Items List</em>
          </span>
                </a>
                <a href="shop_order_complete.html" class="checkout-steps__item">
                    <span class="checkout-steps__item-number">03</span>
                    <span class="checkout-steps__item-title">
            <span>Confirmation</span>
            <em>Review And Submit Your Order</em>
          </span>
                </a>
            </div>
            @if(Cart::instance('wishlist')->content()->count() > 0)
                <div class="row">
                    <div class="col-lg-8">
                        <!-- Cart Items -->
                        @if($items->count() > 0)
                            <div class="card mb-4">
                                <div class="card-body">
                                    @foreach($items as $item)
                                        <div class="row cart-item mb-3">
                                            <div class="col-md-3">
                                                <img
                                                    src="{{asset('images/products/thumbnails')}}/{{$item->model->image}}"
                                                    alt="{{$item->name}}"
                                                    class="img-fluid rounded">
                                            </div>
                                            <div class="col-md-4">
                                                <h5 class="card-title">{{$item->name}}</h5>
                                                <p class="text-muted">Category: {{$item->model->category_name}}</p>
                                                <ul class="shopping-cart__product-item__options">
                                                    @foreach($item->model->productAttributes as $productAttribute)
                                                        <li>{{$productAttribute->productAttribute->name}}
                                                            : {{$productAttribute->productAttributeValue->name}}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="input-group">
{{--                                                    <form method="post"--}}
{{--                                                          action="{{route('cart.decreaseCartQuantity', ['rowId' => $item->rowId])}}">--}}
{{--                                                        @csrf--}}
{{--                                                        @method('put')--}}
{{--                                                        <button class="btn btn-outline-secondary btn-sm qty-reduce"--}}
{{--                                                                type="button">---}}
{{--                                                        </button>--}}
{{--                                                    </form>--}}
                                                    <input style="max-width:100px" type="text" name="quantity"
                                                           class="form-control  form-control-sm text-center quantity-input"
                                                           value="{{$item->qty}}">

                                                    <form method="post"
                                                          action="{{route('wishlist.moveToCart', ['rowId' => $item->rowId])}}">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-warning ms-3">Move to Cart
                                                        </button>
                                                    </form>

{{--                                                    <form method="post"--}}
{{--                                                          action="{{route('cart.increaseCartQuantity', ['rowId' => $item->rowId])}}">--}}
{{--                                                        @csrf--}}
{{--                                                        @method('put')--}}
{{--                                                        <button class="btn btn-outline-secondary btn-sm qty-increase"--}}
{{--                                                                type="button">+--}}
{{--                                                        </button>--}}
{{--                                                    </form>--}}
                                                </div>
                                            </div>
                                            <div class="col-md-2 text-end">
                                                <p class="fw-bold">{{$item->subTotal()}}</p>
                                                <form method="post"
                                                      action="{{route('wishlist.removeFromWishList', ['rowId' => $item->rowId])}}">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-sm btn-outline-danger remove-cart">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                    <hr>
                                </div>
                            </div>
                        @endif
                        <div class="d-flex">
                            <!-- Continue Shopping Button -->
                            <div class="text-start mb-4">
                                <a href="{{route('shop.index')}}" class="btn btn-outline-primary">
                                    <i class="bi bi-arrow-left me-2"></i>Continue Shopping
                                </a>
                            </div>
                            @if($items->count() > 0)
                                <div class="text-end mb-4 ms-5">
                                    <form method="post" action="{{route('cart.emptyCart')}}">
                                        @csrf
                                        @method('delete')
                                        <button id="clear-cart-button" href="{{route('wishlist.emptyWishList')}}"
                                                class="btn btn-outline-primary">
                                            <i class="bi bi-arrow-left me-2"></i>Empty Wishlist
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>

                    </div>
                    <div class="col-lg-4">
                        <div class="cart-sidebar">
                            @include('partials.cart-sidebar')
                        </div>

                        <!-- Promo Code -->
                        <div class="card mt-4">
                            <div class="card-body">
                                <div id="apply-coupon"
                                     style="<?= !Session::has('coupon') ? 'display: block' : 'display: none' ?>">
                                    <h5 class="card-title mb-3">Apply Promo Code</h5>
                                    <form method="post" action="{{route('cart.applyCoupon')}}"
                                          class="position-relative bg-body">
                                        @csrf

                                        <div class="input-group mb-3">
                                            <input name="coupon_code" type="text" class="form-control"
                                                   placeholder="Enter promo code">
                                            <button id="apply-coupon-button" class="btn btn-outline-secondary" type="button">
                                                Apply
                                            </button>
                                        </div>
                                    </form>
                                </div>


                                <div id="remove-coupon"
                                     style="<?= Session::has('coupon') ? 'display: block' : 'display: none' ?>">
                                    <h5 class="card-title mb-3">Remove Promo Code</h5>
                                    <form method="post" action="{{route('cart.removeCoupon')}}"
                                          class="position-relative bg-body">
                                        @csrf
                                        @method('delete')
                                        <button id="remove-coupon-button" class="btn btn-outline-secondary" type="button">
                                            Remove
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col--md-12">
                        <p>No items in your wishlist</p>
                        <a href="{{route('shop.index')}}" class="btn btn-info">Back to Shop</a>
                    </div>
                </div>
            @endif

        </section>
    </main>
@endsection;
