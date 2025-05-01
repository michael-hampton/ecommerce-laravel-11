@php use App\Services\Cart\Facade\Cart;use Illuminate\Support\Facades\Session; @endphp
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
    <div class="container py-5">
        <h1 class="mb-5">Your Shopping Cart</h1>

        <div class="mb-4 pb-4"></div>

        @include('front.partials.cart-steps')

        <div class="row">
            <div class="col-lg-8">
                <!-- Cart Items -->
                <div class="card mb-4">
                    <div class="card-body cart-items-container">
                        @if($items->count() > 0)
                            @foreach($items as $item)
                                <div class="row cart-item mb-3">
                                    <div class="col-md-3">
                                        <img src="{{asset('images/products/thumbnails')}}/{{$item->model->image}}"
                                            alt="{{$item->name}}" class="img-fluid rounded">
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
                                            <form method="post"
                                                action="{{route('cart.decreaseCartQuantity', ['rowId' => $item->rowId])}}">
                                                @csrf
                                                @method('put')
                                                <button class="btn btn-outline-secondary btn-sm qty-reduce" type="button">-
                                                </button>
                                            </form>
                                            <input style="max-width:100px" type="text" name="quantity"
                                                class="form-control  form-control-sm text-center quantity-input"
                                                value="{{$item->qty}}">

                                            <form method="post"
                                                action="{{route('cart.increaseCartQuantity', ['rowId' => $item->rowId])}}">
                                                @csrf
                                                @method('put')
                                                <button class="btn btn-outline-secondary btn-sm qty-increase" type="button">+
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <p class="fw-bold">{{$item->subTotal()}}</p>
                                        <form method="post" action="{{route('cart.removeFromCart', ['rowId' => $item->rowId])}}">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-sm btn-outline-danger remove-cart">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <h2>There are no items in your cart </h2>
                        @endif
                        <hr>
                    </div>
                </div>

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
                                <button id="clear-cart-button" href="{{route('shop.index')}}" class="btn btn-outline-primary">
                                    <i class="bi bi-arrow-left me-2"></i>Empty Cart
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

            </div>
            <div class="col-lg-4">
                <div class="cart-sidebar">
                    @include('front.partials.cart-sidebar')
                </div>

                <!-- Promo Code -->
                <div class="card mt-4">
                    <div class="card-body">
                        <div id="apply-coupon" style="<?= !Session::has('coupon') ? 'display: block' : 'display: none' ?>">
                            <h5 class="card-title mb-3">Apply Promo Code</h5>
                            <form method="post" action="{{route('cart.applyCoupon')}}" class="position-relative bg-body">
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


                        <div id="remove-coupon" style="<?= Session::has('coupon') ? 'display: block' : 'display: none' ?>">
                            <h5 class="card-title mb-3">Remove Promo Code</h5>
                            <form method="post" action="{{route('cart.removeCoupon')}}" class="position-relative bg-body">
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
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
            $('#clear-cart-button').on('click', function (e) {
                e.preventDefault();
                var form = $(this).closest('form')
                $.ajax({
                    url: form.attr('action'),
                    type: "post",
                    data: form.serialize(),
                    datatype: "html",
                })
                    .done(function (data) {
                        if (data.success === true) {
                            location.href = "{{route('shop.index')}}"
                        }
                    })
                    .fail(function (jqXHR, ajaxOptions, thrownError) {
                        alert('No response from server');
                    });
            });


            $('#apply-coupon-button').on('click', function (e) {
                e.preventDefault();
                var form = $(this).closest('form')
                $.ajax({
                    url: form.attr('action'),
                    type: "post",
                    data: form.serialize(),
                    datatype: "html",
                })
                    .done(function (data) {
                        $('.cart-sidebar').html(data)
                        $('#remove-coupon').show()
                        $('#apply-coupon').hide()
                    })
                    .fail(function (jqXHR, ajaxOptions, thrownError) {
                        alert('No response from server');
                    });
            });

            $('#remove-coupon-button').on('click', function (e) {
                e.preventDefault();
                var form = $(this).closest('form')
                $.ajax({
                    url: form.attr('action'),
                    type: "post",
                    data: form.serialize(),
                    datatype: "html",
                })
                    .done(function (data) {
                        $('.cart-sidebar').html(data)
                        $('#apply-coupon').show()
                        $('#remove-coupon').hide()
                    })
                    .fail(function (jqXHR, ajaxOptions, thrownError) {
                        alert('No response from server');
                    });
            });

            $('.qty-increase').on('click', function () {
                var form = $(this).closest('form')
                $.ajax({
                    url: form.attr('action'),
                    type: "post",
                    data: form.serialize(),
                    datatype: "html",
                })
                    .done(function (data) {
                        $('.quantity-input').val(data.quantity)
                        $('.cart-sidebar').html(data.view)
                        //$("#product-list").empty().html(data);
                        //location.hash = page;
                    })
                    .fail(function (jqXHR, ajaxOptions, thrownError) {
                        alert('No response from server');
                    });
            });

            $('.qty-reduce').on('click', function () {
                var form = $(this).closest('form')
                $.ajax({
                    url: form.attr('action'),
                    type: "post",
                    data: form.serialize(),
                    datatype: "html",
                })
                    .done(function (data) {
                        $('.quantity-input').val(data.quantity)
                        $('.cart-sidebar').html(data.view)
                    })
                    .fail(function (jqXHR, ajaxOptions, thrownError) {
                        alert('No response from server');
                    });
            });

            $('.remove-cart').on('click', function (event) {
                event.preventDefault();
                var form = $(this).closest('form')
                var element = $(this).parent().parent().parent()
                $.ajax({
                    url: form.attr('action'),
                    type: "post",
                    data: form.serialize(),
                    datatype: "json",
                })
                    .done(function (data) {
                        element.remove();

                        if ($('.row.cart-item').length === 0) {
                            $('.cart-items-container').html('<h2>There are no items in your cart </h2>')
                        }
                    })
                    .fail(function (jqXHR, ajaxOptions, thrownError) {
                        alert('No response from server');
                    });
            });

            $('.shipping-checkbox').on('change', function () {
                if ($(this).is(':checked')) {
                    $('.shipping-checkbox').not(this).prop('checked', false);
                    $('#shipping_id').val($(this).val());
                    $('#shipping_price').val($(this).data('price'))
                    $('#shipping-form').submit();
                }
            });
        })
    </script>
@endpush