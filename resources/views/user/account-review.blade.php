@extends('layouts.app')
@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container">
            <h2 class="page-title">Review</h2>
            <div class="row">
                <div class="col-lg-2">
                    @include('user.account-nav')
                </div>
                <div class="col-lg-10">
                    <div class="page-content my-account__address">
                        @foreach($reviews as $review)
                            <div class="product-single__reviews-item">
                                <div class="customer-avatar">
                                    <img loading="lazy" src="assets/images/avatar.jpg" alt=""/>
                                </div>
                                <div class="customer-review">
                                    <div class="customer-name">
                                        <h6>{{$review->customer->name}}</h6>
                                        <div class="reviews-group d-flex">
                                            @for ($x = 0; $x < $review->rating; $x++)
                                                <svg class="review-star" viewBox="0 0 9 9"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <use href="#icon_star"/>
                                                </svg>
                                            @endfor
                                        </div>
                                    </div>
                                    <div class="review-date">{{$review->created_at}}</div>
                                    <div class="review-text">
                                        <p>{{$review->comment}}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
