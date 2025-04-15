<header class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container flex-nowrap">
        <!-- Mobile menu toggler (Hamburger) -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Navbar brand (Logo) -->
        <a class="navbar-brand py-1 py-md-2 py-xl-1" href="{{route('home.index')}}">
            <img src="{{asset('assets/images/logo.png')}}" width="30" height="30" class="d-inline-block align-top" alt="">
            Shop Pinoy
        </a>

        <div class="collapse navbar-collapse pt-3 pb-4 py-lg-0 mx-lg-auto" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active py-lg-2 me-lg-n1 me-xl-0">
                    <a class="nav-link" href="{{route('home.index')}}">Home</a>
                </li>
                <li class="nav-item py-lg-2 me-lg-n1 me-xl-0">
                    <a class="nav-link" href="{{route('shop.index')}}">Shop</a>
                </li>
                <li class="nav-item py-lg-2 me-lg-n1 me-xl-0">
                    <a class="nav-link" href="{{route('cart.index')}}">Cart</a>
                </li>
                <li class="nav-item py-lg-2 me-lg-n1 me-xl-0">
                    <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item py-lg-2 me-lg-n1 me-xl-0">
                    <a class="nav-link" href="#">Contact</a>
                </li>
            </ul>
        </div>

        <div class="d-flex align-items-center">

            <!-- Search toggle button -->
            <button type="button" class="btn btn-icon btn-lg fs-xl border-0 rounded-circle animate-shake" data-bs-toggle="offcanvas" data-bs-target="#searchBox" aria-controls="searchBox" aria-label="Toggle search bar">
                <i class="fa fa-search animate-target"></i>
            </button>

            <!-- Account button visible on screens > 768px wide (md breakpoint) -->
            <a class="btn btn-icon btn-lg fs-lg border-0 rounded-circle animate-shake d-none d-md-inline-flex" href="{{ Auth::user()->utype === 'ADM' ? route('admin.index') : route('user.index') }}">
                <i class="fa fa-user animate-target"></i>
                <span class="visually-hidden">Account</span>
            </a>

            <!-- Wishlist button -->
            <button type="button" class="btn btn-icon btn-lg fs-xl position-relative border-0 rounded-circle animate-scale wishlist-count-container" data-bs-toggle="offcanvas" data-bs-target="#wishlist" aria-controls="shoppingCart" aria-label="Shopping cart">
                <span class="position-absolute top-0 start-100 badge fs-xs bg-primary rounded-pill mt-1 ms-n4 z-2 count wishlist-amount" style="--cz-badge-padding-y: .25em; --cz-badge-padding-x: .42em">{{\App\Services\Cart\Facade\Cart::instance('wishlist')->content()->count()}}</span>
                <i class="fa fa-heart animate-target me-1"></i>
            </button>

            <!-- Cart button -->
            <button type="button" class="btn btn-icon btn-lg fs-xl position-relative border-0 rounded-circle animate-scale cart-count-container" data-bs-toggle="offcanvas" data-bs-target="#shoppingCart" aria-controls="shoppingCart" aria-label="Shopping cart">
                <span class="cart-amount position-absolute top-0 start-100 badge fs-xs bg-primary rounded-pill mt-1 ms-n4 z-2 count" style="--cz-badge-padding-y: .25em; --cz-badge-padding-x: .42em">{{\App\Services\Cart\Facade\Cart::instance('cart')->content()->count()}}</span>
                <i class="fa fa-shopping-bag animate-target me-1"></i>
            </button>
        </div>
    </div>
</header>
