@php use App\Helper;use App\Services\Cart\Facade\Cart;use Illuminate\Support\Facades\Session; @endphp
@extends('layouts.app')
@section('content')
    <style>
        .filled-heart {
            color: orange;
        }

        .product-image {
            max-height: 400px;
            object-fit: cover;
        }

        .thumbnail {
            width: 80px;
            height: 80px;
            object-fit: cover;
            cursor: pointer;
            opacity: 0.6;
            transition: opacity 0.3s ease;
        }

        .nav-pills .nav-link.active,
        .nav-pills .show>.nav-link {
            color: #fff;
            background-color: #007bff;
        }

        .thumbnail:hover,
        .thumbnail.active {
            opacity: 1;
        }

        .bg-light {
            --mdb--bg-opacity: 1;
            background-color: rgba(251, 251, 251, var(--mdb--bg-opacity));
        }

        .bg-light {
            --mdb-bg-opacity: 1;
            background-color: rgba(var(--mdb-light-rgb), var(--mdb-bg-opacity)) !important;
        }
    </style>
    <main class="pt-90">
        <div class="mb-md-1 pb-md-3"></div>
        <section class="product-single container">
            <div class="container mt-5">
                <div class="row">
                    <!-- Breadcrumb -->
                    <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
                        @if(!empty($product->category->parent_id))
                            <a href="#"
                                class="menu-link menu-link_us-s text-uppercase fw-medium">{{$product->category->parent->name}}</a>
                            <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
                            <a href="#"
                                class="menu-link menu-link_us-s text-uppercase fw-medium">{{$product->category->name}}</a>
                        @else
                            <a href="#"
                                class="menu-link menu-link_us-s text-uppercase fw-medium">{{$product->category->name}}</a>
                        @endif
                    </div>

                    <div id="alertMessage" class="alert alert-success d-none"></div>
                    <!-- Product Images -->
                    <div class="col-md-6 mb-4">
                        <img style="min-height: 520px;" src="{{asset('images/products')}}/{{$product->image}}"
                            alt="{{$product->name}}" class="img-fluid rounded mb-3 product-image" id="mainImage">
                        <div class="d-flex justify-content-between">
                            <img src="{{asset('images/products/thumbnails')}}/{{$product->image}}" alt="{{$product->name}}"
                                class="thumbnail rounded active" onclick="changeImage(event, this.src)">
                            @foreach(explode(',', $product->images) as $image)
                                <img src="{{asset('images/products/thumbnails')}}/{{$image}}" alt="{{$product->name}}"
                                    class="thumbnail rounded active" onclick="changeImage(event, this.src)">
                            @endforeach
                        </div>
                    </div>

                    <!-- Product Details -->
                    <div class="col-md-6">
                        <h2 class="mb-3">{{$product->name}}</h2>
                        <p class="text-muted mb-4">SKU: {{$product->SKU}}</p>
                        <div class="mb-3">
                            @if($product->sale_price)
                                <span class="h4 me-2">{{$currency}}{{$product->sale_price}} </span>
                                <span class="text-muted"><s>{{$currency}}{{$product->regular_price}}</s></span>
                            @else
                                <span class="h4 me-2"> {{$currency}}{{$product->regular_price}}</span>
                            @endif
                            @if(config('shop.show_commission'))
                                <br>{{ Helper::calculateCommission(!empty($product->sale_price) ? $product->sale_price : $product->regular_price, true)}}
                                inc
                            @endif
                        </div>
                        @if($product->reviews()->count() > 0)
                            <div class="mb-3">
                                @for ($x = 0; $x < $product->reviews()->avg('rating'); $x++)
                                    <i class="fa fa-star text-warning"></i>
                                @endfor
                                <span class="ms-2">{{$product->reviews()->avg('rating')}} ({{$product->reviews()->count()}}
                                    reviews)</span>
                            </div>
                        @endif
                        <p class="mb-4">{{$product->short_description}}</p>
                        <div class="row">
                            <div class="card py-2 border-0">
                                <div class="d-flex">
                                    <dt class="col-3">Brand:</dt>
                                    <dd class="col-9"><a
                                            href="{{route('shop.index', ['brandId' => $product->brand_id])}}">{{$product->brand->name}}</a>
                                    </dd>
                                </div>

                                <div class="d-flex">
                                    <dt class="col-3">Category</dt>
                                    <dd class="col-9"><a
                                            href="{{route('shop.index', ['categoryId' => $product->category_id])}}">{{$product->category->name}}</a>
                                    </dd>
                                </div>

                                @foreach ($attributes as $productAttribute)
                                    <div class="d-flex">
                                        <dt class="col-3">{{$productAttribute->name}}</dt>
                                        <dd class="col-9">
                                            {{$attributeValues->get($productAttribute->id)->pluck('name')->implode(', ')}}
                                        </dd>
                                    </div>
                                @endforeach

                                <div class="mb-4">
                                    <label for="quantity" class="form-label">Quantity:</label>
                                    <input type="number" class="form-control" id="quantity" name="quantity" value="1"
                                        min="1" style="width: 80px;">
                                </div>

                                <div class="d-flex">
                                    <form name="addtocart-form" method="post" action="{{route('cart.add')}}">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$product->id}}">
                                        <input type="hidden" name="name" value="{{$product->name}}">
                                        <input type="hidden" name="price"
                                            value="{{!empty($product->sale_price) ? $product->sale_price : $product->regular_price}}">
                                        <button class="btn btn-primary btn-lg mb-3 me-2 btn-addtocart">
                                            <i class="fa fa-cart-plus"></i> Add to Cart
                                        </button>
                                    </form>

                                    <form method="post" action="{{route('wishlist.add')}}" id="wishlist-form">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$product->id}}">
                                        <input type="hidden" name="name" value="{{$product->name}}">
                                        <input type="hidden" name="price"
                                            value="{{!empty($product->sale_price) ? $product->sale_price : $product->regular_price}}">
                                        <input type="hidden" name="quantity" value="1">

                                        <button class="btn btn-outline-secondary btn-lg mb-3 add-to-wishlist">
                                            <i class="fa fa-heart"></i> Add to Wishlist
                                            @if(Session::has('wishlist_products') && array_key_exists($product->id, Session::get('wishlist_products')))
                                                <span
                                                    class="wishlist-amount">{{Session::get('wishlist_products')[$product->id]}}</span>
                                            @endif
                                        </button>
                                    </form>

                                    <button type="button" style="max-height: 48px;" class="btn btn-primary btn-lg mb-3 ms-2"
                                        data-bs-toggle="modal" data-bs-target="#messageModal"><i class="fa fa-question"></i>
                                        Ask Seller</button>
                                </div>

                            </div>

                            <div class="mt-3 mb-3">
                                <div class="d-flex align-items-center">
                                    <img style="width: 100px"
                                        src="{{ asset('images/sellers') }}/{{ $product->seller->profile->profile_picture }}"
                                        alt="Client 2" class="testimonial-image me-3 rounded-circle">
                                    <div>
                                        <h5 class="mb-0"><a
                                                href="{{route('seller.details', ['id' => $product->seller_id])}}">{{$product->seller->name}}</a>
                                        </h5>
                                        @if($product->seller->reviews()->count() > 0)
                                            @for ($x = 0; $x < $product->seller->reviews()->avg('rating'); $x++)
                                                <i class="fa fa-star text-warning"></i>
                                            @endfor
                                            {{ $product->seller->reviews()->count() }}
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- <dt class="col-3"><img
                                    src="{{ asset('images/sellers') }}/{{ $product->seller->profile->profile_picture }}"
                                    class="rounded-circle mt-4"> </dt>
                            <dd class="col-9"><a
                                    href="{{route('seller.details', ['id' => $product->seller_id])}}">{{$product->seller->name}}</a>
                            </dd> --}}
                        </div>

                    </div>
                </div>
            </div>

            <section class="bg-light border-top py-4">
                <div class="container">
                    <div class="row gx-4">
                        <div class="col-lg-12 mb-4">
                            <div class="border rounded-2 px-3 py-2 bg-white">
                                <ul class="nav nav-pills nav-justified mb-3" id="myTab" role="tablist">
                                    <li class="nav-item d-flex" role="presentation">
                                        <a class="nav-link d-flex align-items-center justify-content-center w-100 active"
                                            id="tab-description-tab" data-bs-toggle="tab" href="#tab-description" role="tab"
                                            aria-controls="tab-description" aria-selected="true">Description</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link d-flex align-items-center justify-content-center w-100"
                                            id="tab-additional-info-tab" data-bs-toggle="tab" href="#tab-additional-info"
                                            role="tab" aria-controls="tab-additional-info" aria-selected="false">Additional
                                            Information</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link d-flex align-items-center justify-content-center w-100"
                                            id="tab-reviews-tab" data-bs-toggle="tab" href="#tab-reviews" role="tab"
                                            aria-controls="tab-reviews" aria-selected="false">Reviews
                                            ({{$product->reviews->count()}})</a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="tab-description" role="tabpanel"
                                        aria-labelledby="tab-description-tab">
                                        <div class="product-single__description">
                                            {{$product->description}}
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tab-additional-info" role="tabpanel"
                                        aria-labelledby="tab-additional-info-tab">
                                        <div class="product-single__addtional-info">
                                            @if($product->productAttributes->count() > 0)
                                                <div class="mt-4">
                                                    <h5>Key Features:</h5>
                                                    <ul>
                                                        @foreach($product->productAttributes as $productAttribute)
                                                            <li>{{$productAttribute->productAttribute->name}}
                                                                : {{$productAttribute->productAttributeValue->name}}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tab-reviews" role="tabpanel"
                                        aria-labelledby="tab-reviews-tab">
                                        <h2 class="product-single__reviews-title">Reviews</h2>
                                        <div class="product-single__reviews-list">
                                            @foreach($product->reviews as $review)
                                                <div class="bg-body-tertiary rounded-4 p-4 p-sm-5">
                                                    <div class="vstack gap-3 gap-md-4 mt-n3">

                                                        <!-- Comment -->
                                                        <div class="mt-3">
                                                            <div
                                                                class="d-flex align-items-center justify-content-between gap-3 mb-3">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="ratio ratio-1x1 flex-shrink-0 bg-body-secondary rounded-circle overflow-hidden"
                                                                        style="width: 40px">
                                                                        <img src="{{asset('images/users/thumbnails')}}/{{$review->customer->image}}"
                                                                            alt="Avatar">
                                                                    </div>
                                                                    <div class="ps-2 ms-1">
                                                                        <div class="fs-sm fw-semibold text-dark-emphasis mb-1">
                                                                            {{$review->customer->name}}
                                                                        </div>
                                                                        <div class="fs-xs text-body-secondary">
                                                                            {{$review->created_at->diffForHumans()}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex gap-2">
                                                                    @for ($x = 0; $x < $review->rating; $x++)
                                                                        <i class="fa fa-star text-warning"></i>
                                                                    @endfor
                                                                </div>
                                                            </div>
                                                            <p class="fs-sm mb-0">{{$review->comment}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </section>

        <!-- Other products from this seller -->
        @if(!empty($otherSellerProducts))
            @include('front.partials.product-row', ['products' => $otherSellerProducts, 'title' => 'Other Products from this seller'])
        @endif

        <!-- Related Products -->
        @if(!empty($relatedProducts))
            @include('front.partials.product-row', ['products' => $relatedProducts, 'title' => 'Related Products'])
        @endif

    </main>
@endsection

<!-- Modal -->
<div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ask a Question</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @include('front.seller.partials.ask-a-question', ['seller' => $product->seller])
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function changeImage(event, src) {
            document.getElementById('mainImage').src = src.replace('thumbnails/', '');
            document.querySelectorAll('.thumbnail').forEach(thumb => thumb.classList.remove('active'));
            event.target.classList.add('active');
        }

        $(function () {

            $('.add-to-wishlist').on('click', function (event) {
                event.preventDefault();
                var form = $(this).closest('form')
                var formData = form.serialize();
                formData += '&quantity=' + $('[name="quantity"]').val()
                console.log(form)
                $.ajax({
                    url: form.attr('action'),
                    type: "post",
                    data: formData,
                    datatype: "json",
                })
                    .done(function (data) {
                        if ($('.wishlist-count-container .wishlist-amount').length > 0) {
                            $('.wishlist-count-container .wishlist-amount').html(data.count)
                        } else {
                            $('.wishlist-count-container').append(`<span class="cart-amount d-block position-absolute js-cart-items-count">${data.count}</span>`)
                        }
                    })
                    .fail(function (jqXHR, ajaxOptions, thrownError) {
                        alert('No response from server');
                    });
            });


            $('.btn-addtocart').on('click', function (event) {
                event.preventDefault();
                var form = $(this).closest('form')
                var formData = form.serialize();
                formData += '&quantity=' + $('[name="quantity"]').val()
                console.log(form)
                $.ajax({
                    url: form.attr('action'),
                    type: "post",
                    data: formData,
                    datatype: "json",
                })
                    .done(function (data) {
                        if ($('.cart-count-container .cart-amount').length > 0) {
                            $('.cart-count-container .cart-amount').html(data.count)
                        } else {
                            $('.cart-count-container').append(`<span class="cart-amount d-block position-absolute js-cart-items-count">${data.count}</span>`)
                        }
                    })
                    .fail(function (jqXHR, ajaxOptions, thrownError) {
                        alert('No response from server');
                    });
            });
        });
        const messageForm = document.getElementById('messageForm')

        messageForm.addEventListener('submit', (event) => {
            event.preventDefault()
            const action = event.currentTarget.getAttribute('action')

            $.ajax({
                url: action,
                type: "POST",
                data: {
                    title: document.querySelector('[name="title"]').value,
                    comment: document.querySelector('[name="comment"]').value,
                    sellerId: {{ $product->seller_id }},
                    _token: "{{ csrf_token() }}"
                },
            }).done(function (msg) {
                const successMessage = document.getElementById('alertMessage')
                successMessage.innerHTML = 'Review was added successfully. Thankyou'
                successMessage.classList.remove('d-none')
                var myModalEl = document.getElementById('messageModal');
                var modal = bootstrap.Modal.getInstance(myModalEl)
                modal.hide();
            });
        })

    </script>
@endpush