<a href="{{route('wishlist.index')}}" class="header-tools__item header-tools__wishlist">
    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
        <use href="#icon_heart"/>
    </svg>
    <span class="wishlist-amount d-block position-absolute js-cart-items-count">{{\App\Services\Cart\Facade\Cart::instance('wishlist')->content()->count()}}</span>
</a>
