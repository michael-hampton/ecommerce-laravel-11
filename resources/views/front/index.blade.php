@php use App\Helper;use App\Services\Cart\Facade\Cart; @endphp
@extends('layouts.app')
@section('content')
    <main>
        <style>
            .slideshow-character {
                top: 0px !important;
            }
        </style>

        <div class="container col-12 col-lg-8">
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-indicators">
  @foreach($slides as $count => $slide)
  @if($count == 0)
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{$count++}}"aria-label="{{$slide->title}}" class="active" aria-current="true"></button>
@else
<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{$count++}}"aria-label="{{$slide->title}}"></button>

  @endif
    @endforeach
  </div>
  <div class="carousel-inner">
    @foreach($slides as $count => $slide)
    <div class="carousel-item @if($count === 0) active @endif">
        <div class="card text-center mb-3">
      <img style="max-height:350px" src="{{asset('images/slides')}}/{{$slide->image}}" class="d-block w-100" alt="...">
      <div class="card-body text-center"> <h5 class="card-title">{{$slide->title}}</h5>
      <p class="card-text">{{$slide->subtitle}}</p>
      <a href="{{$slide->link}}" class="btn btn-primary">{{$slide->link_text}}</a>

    </div>
        </div>
    </div>
        @endforeach
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
        </div>
    

        <div class="container mw-1620 bg-white border-radius-10">
            <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

            @if($categories->count() > 0)
                <section class="category-carousel container">
                    <h2 class="section-title text-center mb-3 pb-xl-2 mb-xl-4">You Might Like</h2>

                    <div class="position-relative">
                        <div class="swiper-container js-swiper-slider" data-settings='{
              "autoplay": {
                "delay": 5000
              },
              "slidesPerView": 8,
              "slidesPerGroup": 1,
              "effect": "none",
              "loop": true,
              "navigation": {
                "nextEl": ".products-carousel__next-1",
                "prevEl": ".products-carousel__prev-1"
              },
              "breakpoints": {
                "320": {
                  "slidesPerView": 2,
                  "slidesPerGroup": 2,
                  "spaceBetween": 15
                },
                "768": {
                  "slidesPerView": 4,
                  "slidesPerGroup": 4,
                  "spaceBetween": 30
                },
                "992": {
                  "slidesPerView": 6,
                  "slidesPerGroup": 1,
                  "spaceBetween": 45,
                  "pagination": false
                },
                "1200": {
                  "slidesPerView": 8,
                  "slidesPerGroup": 1,
                  "spaceBetween": 60,
                  "pagination": false
                }
              }
            }'>
                            <div class="swiper-wrapper">
                                @foreach($categories as $category)
                                    <div class="swiper-slide">
                                        <img loading="lazy" class="w-100 h-auto mb-3"
                                             src="{{asset('images/categories')}}/{{$category->image}}" width="124"
                                             height="124" alt="{{$category->name}}"/>
                                        <div class="text-center">
                                            <a href="{{route('shop.index', ['categoryId' => $category->id])}}"
                                               class="menu-link fw-bolder text-dark text-decoration-none">{{$category->name}}</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div><!-- /.swiper-wrapper -->
                        </div><!-- /.swiper-container js-swiper-slider -->

                        <div
                            class="products-carousel__prev products-carousel__prev-1 position-absolute top-50 d-flex align-items-center justify-content-center">
                            <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                                <use href="#icon_prev_md"/>
                            </svg>
                        </div><!-- /.products-carousel__prev -->
                        <div
                            class="products-carousel__next products-carousel__next-1 position-absolute top-50 d-flex align-items-center justify-content-center">
                            <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                                <use href="#icon_next_md"/>
                            </svg>
                        </div><!-- /.products-carousel__next -->
                    </div><!-- /.position-relative -->
                </section>
            @endif


            <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

            <!-- Hot Deals -->
            @if($products->count() > 0)
                @include('front/partials/product-row', ['products' => $products, 'title' => 'Hot Deals'])
            @endif

            <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

            <section class="category-banner container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="category-banner__item border-radius-10 mb-5">
                            <img loading="lazy" class="h-auto" src="assets/images/home/demo3/category_9.jpg" width="690"
                                 height="665"
                                 alt=""/>
                            <div class="category-banner__item-mark">
                                Starting at $19
                            </div>
                            <div class="category-banner__item-content">
                                <h3 class="mb-0">Blazers</h3>
                                <a href="#" class="btn-link default-underline text-uppercase fw-medium">Shop Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="category-banner__item border-radius-10 mb-5">
                            <img loading="lazy" class="h-auto" src="assets/images/home/demo3/category_10.jpg"
                                 width="690" height="665"
                                 alt=""/>
                            <div class="category-banner__item-mark">
                                Starting at $19
                            </div>
                            <div class="category-banner__item-content">
                                <h3 class="mb-0">Sportswear</h3>
                                <a href="#" class="btn-link default-underline text-uppercase fw-medium">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

            <!-- Featured Products -->
            @if($featuredProducts->count() > 0)
                @include('front.partials.product-row', ['products' => $featuredProducts, 'title' => 'Featured Products'])
            @endif
        </div>

        <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

    </main>
@endsection
