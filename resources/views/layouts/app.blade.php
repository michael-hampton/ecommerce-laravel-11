@php use App\Services\Cart\Cart;use Illuminate\Support\Facades\Auth; @endphp
    <!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
    <title>Shop Pinoy</title>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta name="author" content="shop pinoy"/>
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.ico')}}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link
        href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Allura&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/css/plugins/swiper.min.css')}}" type="text/css"/>
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}" type="text/css"/>
    <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}" type="text/css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
          integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw=="
          crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert.min.css')}}">
    @stack('styles')
</head>
<body class="gradient-bg">
<style>
    #header {
        padding-top: 8px;
        padding-bottom: 8px;
        position: relative !important;
    }

    .logo__image {
        max-width: 220px;
    }

    .count {
        padding: .25em !important;
    }

    .btn-outline-secondary {
        color: #333d4c !important;
        border-color: #e0e5eb !important;
    }

    /*.btn-icon {*/
    /*    flex-shrink: 0;*/
    /*    height: 3rem;*/
    /*    padding: 0;*/
    /*    width: 3rem;*/
    /*}*/
</style>

<!-- Wishlist cart offcanvas -->
<div class="offcanvas offcanvas-end pb-sm-2 px-sm-2" id="wishlist" tabindex="-1" aria-labelledby="shoppingCartLabel"
     style="width: 500px">

    <!-- Header -->
    <div class="offcanvas-header flex-column align-items-start py-3 pt-lg-4">
        <div class="d-flex align-items-center justify-content-between w-100">
            <h4 class="offcanvas-title" id="shoppingCartLabel">Wishlist ({{\App\Services\Cart\Facade\Cart::instance('wishlist')->count()}})</h4>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
    </div>

    <!-- Items -->
    <div class="offcanvas-body d-flex flex-column gap-4 pt-2">
        @foreach(\App\Services\Cart\Facade\Cart::instance('wishlist')->content() as $item)
            <!-- Item -->
            <div class="d-flex align-items-center">
                <a class="flex-sm-shrink-0" href="{{route('shop.product.details', ['slug' => $item->model->slug])}}" style="width: 142px">
                    <div class="bg-body-tertiary rounded overflow-hidden"
                         style="--cz-aspect-ratio: calc(110 / 142 * 100%)">
                        <img src="{{asset('images/products/thumbnails')}}/{{$item->model->image}}" alt="Thumbnail">
                    </div>
                </a>
                <div class="w-100 min-w-0 ps-3">
                    <h5 class="d-flex animate-underline mb-2">
                        <a class="d-block fs-sm fw-medium text-truncate animate-target"
                           href="shop-product-marketplace.html">{{$item->name}}</a>
                    </h5>
                    <div class="h6 pb-1 mb-2">{{$item->price}}</div>
                    <div class="d-flex align-items-center justify-content-between gap-1">
                        <button type="button" class="btn btn-icon btn-sm flex-shrink-0 fs-sm" data-bs-toggle="tooltip"
                                data-bs-custom-class="tooltip-sm" data-bs-title="Remove" aria-label="Remove from cart">
                            <i class="ci-trash fs-base"></i>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Footer -->
    <div class="offcanvas-header flex-column align-items-start">
        <div class="d-flex align-items-center justify-content-between w-100 mb-3 mb-md-4">
            <span class="text-light-emphasis">Subtotal:</span>
            <span class="h6 mb-0">{{\App\Services\Cart\Facade\Cart::instance('wishlist')->total()}}</span>
        </div>
        <a class="btn btn-lg btn-dark w-100 rounded-pill" href="{{route('wishlist.index')}}">Go to wishlist</a>
    </div>
</div>

<!-- Shopping cart offcanvas -->
<div class="offcanvas offcanvas-end pb-sm-2 px-sm-2" id="shoppingCart" tabindex="-1" aria-labelledby="shoppingCartLabel"
     style="width: 500px">

    <!-- Header -->
    <div class="offcanvas-header flex-column align-items-start py-3 pt-lg-4">
        <div class="d-flex align-items-center justify-content-between w-100">
            <h4 class="offcanvas-title" id="shoppingCartLabel">Cart ({{\App\Services\Cart\Facade\Cart::instance('cart')->count()}})</h4>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
    </div>

    <!-- Items -->
    <div class="offcanvas-body d-flex flex-column gap-4 pt-2">

        @foreach(\App\Services\Cart\Facade\Cart::instance('cart')->content() as $item)
            <!-- Item -->
            <div class="d-flex align-items-center">
                <a class="flex-sm-shrink-0" href="{{route('shop.product.details', ['slug' => $item->model->slug])}}" style="width: 142px">
                    <div class="bg-body-tertiary rounded overflow-hidden"
                         style="--cz-aspect-ratio: calc(110 / 142 * 100%)">
                        <img src="{{asset('images/products/thumbnails')}}/{{$item->model->image}}" alt="Thumbnail">
                    </div>
                </a>
                <div class="w-100 min-w-0 ps-3">
                    <h5 class="d-flex animate-underline mb-2">
                        <a class="d-block fs-sm fw-medium text-truncate animate-target"
                           href="shop-product-marketplace.html">{{$item->name}}</a>
                    </h5>
                    <div class="h6 pb-1 mb-2">{{$item->price}}</div>
                    <div class="d-flex align-items-center justify-content-between gap-1">
                        <button type="button" class="btn btn-icon btn-sm flex-shrink-0 fs-sm" data-bs-toggle="tooltip"
                                data-bs-custom-class="tooltip-sm" data-bs-title="Remove" aria-label="Remove from cart">
                            <i class="ci-trash fs-base"></i>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Footer -->
    <div class="offcanvas-header flex-column align-items-start">
        <div class="d-flex align-items-center justify-content-between w-100 mb-3 mb-md-4">
            <span class="text-light-emphasis">Subtotal:</span>
            <span class="h6 mb-0">{{\App\Services\Cart\Facade\Cart::instance('cart')->total()}}</span>
        </div>
        <a class="btn btn-lg btn-dark w-100 rounded-pill" href="{{route('cart.index')}}">Go to cart</a>
    </div>
</div>

<!-- Search offcanvas -->
<div class="offcanvas offcanvas-top" id="searchBox" tabindex="-1" aria-labelledby="shoppingCartLabel" style="min-height: 400px">
    <div class="offcanvas-header border-bottom p-0 py-lg-1">
        <form method="GET" class="container d-flex align-items-center">
            <input type="search" class="form-control form-control-lg fs-lg border-0 rounded-0 py-3 ps-0"
                   placeholder="Search the products" data-autofocus="offcanvas" name="search-keyword"
                   id="search-keyword">
            <button type="reset" class="btn-close fs-lg" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </form>
    </div>
    <div class="offcanvas-body px-0">
        <div class="container text-center">
            <svg class="text-body-tertiary opacity-60 mb-4" xmlns="http://www.w3.org/2000/svg" width="60"
                 viewBox="0 0 512 512" fill="currentColor">
                <path
                    d="M340.115,361.412l-16.98-16.98c-34.237,29.36-78.733,47.098-127.371,47.098C87.647,391.529,0,303.883,0,195.765S87.647,0,195.765,0s195.765,87.647,195.765,195.765c0,48.638-17.738,93.134-47.097,127.371l16.98,16.98l11.94-11.94c5.881-5.881,15.415-5.881,21.296,0l112.941,112.941c5.881,5.881,5.881,15.416,0,21.296l-45.176,45.176c-5.881,5.881-15.415,5.881-21.296,0L328.176,394.648c-5.881-5.881-5.881-15.416,0-21.296L340.115,361.412z M195.765,361.412c91.484,0,165.647-74.163,165.647-165.647S287.249,30.118,195.765,30.118S30.118,104.28,30.118,195.765S104.28,361.412,195.765,361.412z M360.12,384l91.645,91.645l23.88-23.88L384,360.12L360.12,384z M233.034,233.033c5.881-5.881,15.415-5.881,21.296,0c5.881,5.881,5.881,15.416,0,21.296c-32.345,32.345-84.786,32.345-117.131,0c-5.881-5.881-5.881-15.415,0-21.296c5.881-5.881,15.416-5.881,21.296,0C179.079,253.616,212.45,253.616,233.034,233.033zM135.529,180.706c-12.475,0-22.588-10.113-22.588-22.588c0-12.475,10.113-22.588,22.588-22.588c12.475,0,22.588,10.113,22.588,22.588C158.118,170.593,148.005,180.706,135.529,180.706z M256,180.706c-12.475,0-22.588-10.113-22.588-22.588c0-12.475,10.113-22.588,22.588-22.588s22.588,10.113,22.588,22.588C278.588,170.593,268.475,180.706,256,180.706z"></path>
            </svg>
            <h6 class="mb-2 to-hide">Your search results will appear here</h6>
            <p class="fs-sm mb-0 to-hide">Start typing in the search field above to see instant search results.</p>
            <ul id="box-content-search" class="list-unstyled">

            </ul>
        </div>
    </div>
</div>

@include('layouts.header')
@yield('content')


<hr class="mt-5 text-secondary"/>
@include('layouts.footer')

<footer class="footer-mobile container w-100 px-5 d-md-none bg-body">
    <div class="row text-center">
        <div class="col-4">
            <a href="{{route('home.index')}}" class="footer-mobile__link d-flex flex-column align-items-center">
                <svg class="d-block" width="18" height="18" viewBox="0 0 18 18" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <use href="#icon_home"/>
                </svg>
                <span>Home</span>
            </a>
        </div>

        <div class="col-4">
            <a href="{{route('home.index')}}" class="footer-mobile__link d-flex flex-column align-items-center">
                <svg class="d-block" width="18" height="18" viewBox="0 0 18 18" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <use href="#icon_hanger"/>
                </svg>
                <span>Shop</span>
            </a>
        </div>

        <div class="col-4">
            <a href="{{route('home.index')}}" class="footer-mobile__link d-flex flex-column align-items-center">
                <div class="position-relative">
                    <svg class="d-block" width="18" height="18" viewBox="0 0 20 20" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_heart"/>
                    </svg>
                    <span class="wishlist-amount d-block position-absolute js-wishlist-count">3</span>
                </div>
                <span>Wishlist</span>
            </a>
        </div>
    </div>
</footer>

<div id="scrollTop" class="visually-hidden end-0"></div>
<div class="page-overlay"></div>

<script src="{{asset('js/sweetalert.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/jquery.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
<script src="{{asset('assets/js/plugins/bootstrap-slider.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/swiper.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/countdown.js')}}"></script>
<script src="{{asset('assets/js/theme.js')}}"></script>
@stack('scripts')

<script>
    $(function () {
        if (window.innerWidth < 992) {

            // close all inner dropdowns when parent is closed
            document.querySelectorAll('.navbar .dropdown').forEach(function(everydropdown){
                everydropdown.addEventListener('hidden.bs.dropdown', function () {
                    // after dropdown is hidden, then find all submenus
                    this.querySelectorAll('.submenu').forEach(function(everysubmenu){
                        // hide every submenu as well
                        everysubmenu.style.display = 'none';
                    });
                })
            });

            document.querySelectorAll('.dropdown-menu a').forEach(function(element){
                element.addEventListener('click', function (e) {
                    let nextEl = this.nextElementSibling;
                    if(nextEl && nextEl.classList.contains('submenu')) {
                        // prevent opening link if link needs to open dropdown
                        e.preventDefault();
                        if(nextEl.style.display == 'block'){
                            nextEl.style.display = 'none';
                        } else {
                            nextEl.style.display = 'block';
                        }

                    }
                });
            })
        }
// end if innerWidth
        $('#search-keyword').on('keyup', delay(function (e) {
            var searchQuery = $(this).val();

            if (searchQuery.length < 3) {
                return;
            }

            $.ajax({
                type: 'GET',
                url: "{{route('shop.searchProducts')}}",
                data: {query: searchQuery},
                dataType: 'json',
                success: function (data) {
                    $('.to-hide').hide();
                    $('#box-content-search').html('');
                    $.each(data, function (index, item) {
                        var url = "{{route('shop.product.details', ['slug' => 'product_slug_pls'])}}";
                        var link = url.replace('product_slug_pls', item.slug)

                        $('#box-content-search').append(`<li><ul class="list-unstyled"><li class="product-item gap14 mb-2 d-flex">
                            <div class="image d-flex align-items-center justify-content-center no-bg">
                            <img style="width:50px; height: 50px; padding: 5px; border-radius: 10px; gap: 10px" src="{{asset('images/products')}}/${item.image}" alt="${item.name}">
                            </div>
                            <div class="d-flex align-items-center justify-content-between flex-grow-1 gap20">
                            <div class="name"><a href="${link}" class="body-text">${item.name}</a></div>
                            </div>
                            </li>
                            <li class="mb-10"><div class="divider"></li>
                            </ul></li>
                       `)
                    });
                }
            })
        }))
    });

    function delay(callback, ms) {
        var timer = 0;
        return function () {
            var context = this, args = arguments;
            clearTimeout(timer);
            timer = setTimeout(function () {
                callback.apply(context, args);
            }, ms || 0);
        };
    }
</script>
</body>
</html>
