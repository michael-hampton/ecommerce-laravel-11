<a href="{{route('cart.index')}}" class="header-tools__item header-tools__cart">
    <svg class="d-block" width="20" height="20" viewBox="0 0 20 20" fill="none"
         xmlns="http://www.w3.org/2000/svg">
        <use href="#icon_cart"/>
    </svg>
    @if(\App\Services\Cart\Facade\Cart::instance('cart')->content()->count() > 0)
        <span class="cart-amount d-block position-absolute js-cart-items-count">{{\App\Services\Cart\Facade\Cart::instance('cart')->content()->count()}}</span>
    @endif
</a>
