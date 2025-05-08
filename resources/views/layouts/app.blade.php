@php use App\Services\Cart\Cart;use Illuminate\Support\Facades\Auth; @endphp
<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
    <title>{{config('shop.shop_name')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />

    @if(!empty($brand))
        <meta name="description" content="{{ $brand->meta_description }}">
        <meta name="keywords" content="{{ $brand->meta_keywords }}">
        <meta name="name" content="{{ $brand->meta_name }}">
    @elseif (!empty($category))
        <meta name="description" content="{{ $category->meta_description }}">
        <meta name="keywords" content="{{ $category->meta_keywords }}">
        <meta name="name" content="{{ $category->meta_name }}">
    @endif

    <meta name="author" content="{{ config('shop.shop_name')}}" />
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.ico')}}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link
        href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Allura&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/css/plugins/swiper.min.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}" type="text/css" />
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
        @include('front.partials.wishlist-header', ['items' => \App\Services\Cart\Facade\Cart::instance('wishlist')->content()])


    </div>

    <!-- Shopping cart offcanvas -->
    <div class="offcanvas offcanvas-end pb-sm-2 px-sm-2" id="shoppingCart" tabindex="-1"
        aria-labelledby="shoppingCartLabel" style="width: 500px">

        @include('front.partials.cart-header', ['items' => \App\Services\Cart\Facade\Cart::instance('cart')->content()])

    </div>

    <!-- Notifications -->
    <div id="notificationScreen" class="offcanvas offcanvas-end pb-sm-2 px-sm-2" tabindex="-1"
        aria-labelledby="navbarDropdownNotification">
        <div class="card card-notification shadow-none">
            <div class="card-header">
                <div class="row justify-content-between align-items-center">
                    <div class="col-auto">
                        <h6 class="card-header-title mb-0">Notifications</h6>
                    </div>
                    <div class="col-auto ps-0 ps-sm-3"><a class="card-link fw-normal" href="#">Mark all as read</a>
                    </div>
                </div>
            </div>

            @if(auth()->check() && auth()->user()->notifications->count() > 0)
                <div class="scrollbar-overlay simplebar-scrollable-y" style="max-height:19rem" data-simplebar="init">
                    <div class="simplebar-wrapper" style="margin: 0px;">
                        <div class="simplebar-height-auto-observer-wrapper">
                            <div class="simplebar-height-auto-observer"></div>
                        </div>
                        <div class="simplebar-mask">
                            <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                <div class="simplebar-content-wrapper" tabindex="0" role="region"
                                    aria-label="scrollable content" style="height: auto; overflow: hidden scroll;">
                                    <div class="simplebar-content" style="padding: 0px;">
                                        <div class="list-group list-group-flush fw-normal fs-10">
                                            @foreach (auth()->user()->notifications as $notification)
                                                <div class="list-group-item">
                                                    <a class="notification notification-flush notification-unread" href="#!">
                                                        <div class="notification-avatar">
                                                            <div class="avatar avatar-2xl me-3">
                                                                <img class="rounded-circle" src="assets/img/team/1-thumb.png"
                                                                    alt="">
                                                            </div>
                                                        </div>
                                                        <div class="notification-body">
                                                            <p class="mb-1">{!! $notification->data['message'] !!}</p>
                                                            <span class="notification-time"><span class="me-2" role="img"
                                                                    aria-label="Emoji">💬</span>{{$notification->created_at->diffForHumans()}}</span>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endforeach


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="simplebar-placeholder" style="width: 318px; height: 514px;"></div>
                    </div>
                    <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                        <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
                    </div>
                    <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                        <div class="simplebar-scrollbar"
                            style="height: 179px; display: block; transform: translate3d(0px, 0px, 0px);"></div>
                    </div>
                </div>
            @endif
            <div class="card-footer text-center border-top"><a class="card-link d-block"
                    href="app/social/notifications.html">View all</a></div>
        </div>
    </div>

    <!-- Search offcanvas -->
    <div class="offcanvas offcanvas-top" id="searchBox" tabindex="-1" aria-labelledby="shoppingCartLabel"
        style="min-height: 400px">
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
                        d="M340.115,361.412l-16.98-16.98c-34.237,29.36-78.733,47.098-127.371,47.098C87.647,391.529,0,303.883,0,195.765S87.647,0,195.765,0s195.765,87.647,195.765,195.765c0,48.638-17.738,93.134-47.097,127.371l16.98,16.98l11.94-11.94c5.881-5.881,15.415-5.881,21.296,0l112.941,112.941c5.881,5.881,5.881,15.416,0,21.296l-45.176,45.176c-5.881,5.881-15.415,5.881-21.296,0L328.176,394.648c-5.881-5.881-5.881-15.416,0-21.296L340.115,361.412z M195.765,361.412c91.484,0,165.647-74.163,165.647-165.647S287.249,30.118,195.765,30.118S30.118,104.28,30.118,195.765S104.28,361.412,195.765,361.412z M360.12,384l91.645,91.645l23.88-23.88L384,360.12L360.12,384z M233.034,233.033c5.881-5.881,15.415-5.881,21.296,0c5.881,5.881,5.881,15.416,0,21.296c-32.345,32.345-84.786,32.345-117.131,0c-5.881-5.881-5.881-15.415,0-21.296c5.881-5.881,15.416-5.881,21.296,0C179.079,253.616,212.45,253.616,233.034,233.033zM135.529,180.706c-12.475,0-22.588-10.113-22.588-22.588c0-12.475,10.113-22.588,22.588-22.588c12.475,0,22.588,10.113,22.588,22.588C158.118,170.593,148.005,180.706,135.529,180.706z M256,180.706c-12.475,0-22.588-10.113-22.588-22.588c0-12.475,10.113-22.588,22.588-22.588s22.588,10.113,22.588,22.588C278.588,170.593,268.475,180.706,256,180.706z">
                    </path>
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


    <hr class="mt-5 text-secondary" />
    @include('layouts.footer')

    <footer class="footer-mobile container w-100 px-5 d-md-none bg-body">
        <div class="row text-center">
            <div class="col-4">
                <a href="{{route('home.index')}}" class="footer-mobile__link d-flex flex-column align-items-center">
                    <svg class="d-block" width="18" height="18" viewBox="0 0 18 18" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_home" />
                    </svg>
                    <span>Home</span>
                </a>
            </div>

            <div class="col-4">
                <a href="{{route('home.index')}}" class="footer-mobile__link d-flex flex-column align-items-center">
                    <svg class="d-block" width="18" height="18" viewBox="0 0 18 18" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_hanger" />
                    </svg>
                    <span>Shop</span>
                </a>
            </div>

            <div class="col-4">
                <a href="{{route('home.index')}}" class="footer-mobile__link d-flex flex-column align-items-center">
                    <div class="position-relative">
                        <svg class="d-block" width="18" height="18" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_heart" />
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
            // $('#navbarDropdownNotification').on('click', function() {
            //     alert('here')
            // })

            if (window.innerWidth < 992) {

                // close all inner dropdowns when parent is closed
                document.querySelectorAll('.navbar .dropdown').forEach(function (everydropdown) {
                    everydropdown.addEventListener('hidden.bs.dropdown', function () {
                        // after dropdown is hidden, then find all submenus
                        this.querySelectorAll('.submenu').forEach(function (everysubmenu) {
                            // hide every submenu as well
                            everysubmenu.style.display = 'none';
                        });
                    })
                });

                document.querySelectorAll('.dropdown-menu a').forEach(function (element) {
                    element.addEventListener('click', function (e) {
                        let nextEl = this.nextElementSibling;
                        if (nextEl && nextEl.classList.contains('submenu')) {
                            // prevent opening link if link needs to open dropdown
                            e.preventDefault();
                            if (nextEl.style.display == 'block') {
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
                    data: { query: searchQuery },
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