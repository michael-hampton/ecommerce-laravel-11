@php use App\Services\Cart\Facade\Cart; @endphp
    <!-- Cart Summary -->
<div class="card cart-summary">
    <div class="card-body">
        <h5 class="card-title mb-4">Order Summary</h5>
        @if(Session::has('discounts'))
            <div class="d-flex justify-content-between mb-3">
                <span>Subtotal</span>
                <span>{{$currency}}{{Cart::instance('cart')->subtotal()}}</span>
            </div>
            @if(Session::has('coupon'))
                <div class="d-flex justify-content-between mb-3">
                    <span>Discount</span>
                    <span>{{$currency}}{{Session::get('discounts')['discount']}}</span>
                </div>
            @endif
            <div class="d-flex justify-content-between mb-3">
                <span>Buyer Protection Insurance</span>
                <span> {{$currency}}{{Session::get('discounts')['commission']}}</span>
            </div>
            <div class="d-flex justify-content-between mb-3">
                <span>Shipping</span>
                <span>{{$currency}}{{Session::get('discounts')['shipping']}}</span>
            </div>
            <div class="d-flex justify-content-between mb-3">
                <span>Tax</span>
                <span>{{$currency}}{{Session::get('discounts')['tax']}}</span>
            </div>
            <hr>
            <div class="d-flex justify-content-between mb-4">
                <strong>Total</strong>
                <strong>{{$currency}}{{Session::get('discounts')['total']}}</strong>
            </div>
        @else
            <div class="d-flex justify-content-between mb-3">
                <span>Subtotal</span>
                <span>{{$currency}}{{Cart::instance('cart')->subtotal()}}</span>
            </div>
            @if(Session::has('coupon'))
{{--                <div class="d-flex justify-content-between mb-3">--}}
{{--                    <span>Discount</span>--}}
{{--                    <span>{{$currency}}{{Cart::instance('cart')->subtotal()}}</span>--}}
{{--                </div>--}}
            @endif
            <div class="d-flex justify-content-between mb-3">
                <span>Buyer Protection Insurance</span>
                <span> {{$currency}}{{Cart::instance('cart')->commission()}}</span>
            </div>
            <div class="d-flex justify-content-between mb-3">
                <span>Shipping</span>
                <span>{{$currency}}{{Cart::instance('cart')->shipping()}}</span>
            </div>
            <div class="d-flex justify-content-between mb-3">
                <span>Tax</span>
                <span>{{$currency}}{{Cart::instance('cart')->tax()}}</span>
            </div>
            <hr>
            <div class="d-flex justify-content-between mb-4">
                <strong>Total</strong>
                <strong>{{$currency}}{{Cart::instance('cart')->total()}}</strong>
            </div>
        @endif

        <a href="{{route('checkout.index')}}" class="btn btn-primary w-100">Proceed to Checkout</a>
    </div>
</div>
