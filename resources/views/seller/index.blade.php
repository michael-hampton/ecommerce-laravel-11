@extends('layouts.app')
@section('content')
    <div class="p-5">
        <h1 class="product-single__name">{{$seller->name}}</h1>
        <div class="product-single__rating">
            <div class="reviews-group d-flex">
                @for ($x = 0; $x < $seller->reviews()->avg('rating'); $x++)
                    <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_star"/>
                    </svg>
                @endfor
            </div>
            <span class="reviews-note text-lowercase text-secondary ms-1">{{$seller->reviews()->count()}} reviews</span>
        </div>
        <p>{{!empty($profile->email) ? $profile->email : $seller->email}}</p>

        @if($sellerProducts->count() > 0)
            @include('partials/product-row', ['products' => $sellerProducts, 'title' => 'Products from this seller', 'currency' => $currency])
        @endif

        <ul class="nav nav-pills nav-fill" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab" aria-controls="details" aria-selected="true">Details</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">Reviews</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="ask-a-question-tab" data-bs-toggle="tab" data-bs-target="#ask-a-question" type="button" role="tab" aria-controls="ask-a-question" aria-selected="false">Ask a Question</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                <ul class="list-unstyled">
                    <li>City: {{$profile->city}}</li>
                    <li>Phone: {{$profile->phone}}</li>
                    <li>Website: {{$profile->website}}</li>
                </ul>

                <p>{{$profile->biography}}</p>
            </div>
            <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                <section class="reviews">
                    <div>
                        <div class="container" style="padding: 30px 0">
                            <div class="product-single__review-form">
                                <form name="customer-review-form" action="{{route('storeSellerReview', ['sellerId' => $seller->id])}}"
                                      method="post">
                                    @csrf
                                    @if(Session::has('message'))
                                        <div class="alert alert-success">{{Session::get('message')}}</div>
                                    @endif
                                    <h5>Be the first to review “{{$seller->name}}”</h5>
                                    <p>Your email address will not be published. Required fields are marked *</p>
                                    <div class="select-star-rating">
                                        <label>Your rating *</label>
                                        <span class="star-rating">
                    <svg class="star-rating__star-icon" width="12" height="12" fill="#ccc" viewBox="0 0 12 12"
                         xmlns="http://www.w3.org/2000/svg" data-id="1">
                      <path
                          d="M11.1429 5.04687C11.1429 4.84598 10.9286 4.76562 10.7679 4.73884L7.40625 4.25L5.89955 1.20312C5.83929 1.07589 5.72545 0.928571 5.57143 0.928571C5.41741 0.928571 5.30357 1.07589 5.2433 1.20312L3.73661 4.25L0.375 4.73884C0.207589 4.76562 0 4.84598 0 5.04687C0 5.16741 0.0870536 5.28125 0.167411 5.3683L2.60491 7.73884L2.02902 11.0871C2.02232 11.1339 2.01563 11.1741 2.01563 11.221C2.01563 11.3951 2.10268 11.5558 2.29688 11.5558C2.39063 11.5558 2.47768 11.5223 2.56473 11.4754L5.57143 9.89509L8.57813 11.4754C8.65848 11.5223 8.75223 11.5558 8.84598 11.5558C9.04018 11.5558 9.12054 11.3951 9.12054 11.221C9.12054 11.1741 9.12054 11.1339 9.11384 11.0871L8.53795 7.73884L10.9688 5.3683C11.0558 5.28125 11.1429 5.16741 11.1429 5.04687Z"/>
                    </svg>
                    <svg class="star-rating__star-icon" width="12" height="12" fill="#ccc" viewBox="0 0 12 12"
                         xmlns="http://www.w3.org/2000/svg" data-id="2">
                      <path
                          d="M11.1429 5.04687C11.1429 4.84598 10.9286 4.76562 10.7679 4.73884L7.40625 4.25L5.89955 1.20312C5.83929 1.07589 5.72545 0.928571 5.57143 0.928571C5.41741 0.928571 5.30357 1.07589 5.2433 1.20312L3.73661 4.25L0.375 4.73884C0.207589 4.76562 0 4.84598 0 5.04687C0 5.16741 0.0870536 5.28125 0.167411 5.3683L2.60491 7.73884L2.02902 11.0871C2.02232 11.1339 2.01563 11.1741 2.01563 11.221C2.01563 11.3951 2.10268 11.5558 2.29688 11.5558C2.39063 11.5558 2.47768 11.5223 2.56473 11.4754L5.57143 9.89509L8.57813 11.4754C8.65848 11.5223 8.75223 11.5558 8.84598 11.5558C9.04018 11.5558 9.12054 11.3951 9.12054 11.221C9.12054 11.1741 9.12054 11.1339 9.11384 11.0871L8.53795 7.73884L10.9688 5.3683C11.0558 5.28125 11.1429 5.16741 11.1429 5.04687Z"/>
                    </svg>
                    <svg class="star-rating__star-icon" width="12" height="12" fill="#ccc" viewBox="0 0 12 12"
                         xmlns="http://www.w3.org/2000/svg" data-id="3">
                      <path
                          d="M11.1429 5.04687C11.1429 4.84598 10.9286 4.76562 10.7679 4.73884L7.40625 4.25L5.89955 1.20312C5.83929 1.07589 5.72545 0.928571 5.57143 0.928571C5.41741 0.928571 5.30357 1.07589 5.2433 1.20312L3.73661 4.25L0.375 4.73884C0.207589 4.76562 0 4.84598 0 5.04687C0 5.16741 0.0870536 5.28125 0.167411 5.3683L2.60491 7.73884L2.02902 11.0871C2.02232 11.1339 2.01563 11.1741 2.01563 11.221C2.01563 11.3951 2.10268 11.5558 2.29688 11.5558C2.39063 11.5558 2.47768 11.5223 2.56473 11.4754L5.57143 9.89509L8.57813 11.4754C8.65848 11.5223 8.75223 11.5558 8.84598 11.5558C9.04018 11.5558 9.12054 11.3951 9.12054 11.221C9.12054 11.1741 9.12054 11.1339 9.11384 11.0871L8.53795 7.73884L10.9688 5.3683C11.0558 5.28125 11.1429 5.16741 11.1429 5.04687Z"/>
                    </svg>
                    <svg class="star-rating__star-icon" width="12" height="12" fill="#ccc" viewBox="0 0 12 12"
                         xmlns="http://www.w3.org/2000/svg" data-id="4">
                      <path
                          d="M11.1429 5.04687C11.1429 4.84598 10.9286 4.76562 10.7679 4.73884L7.40625 4.25L5.89955 1.20312C5.83929 1.07589 5.72545 0.928571 5.57143 0.928571C5.41741 0.928571 5.30357 1.07589 5.2433 1.20312L3.73661 4.25L0.375 4.73884C0.207589 4.76562 0 4.84598 0 5.04687C0 5.16741 0.0870536 5.28125 0.167411 5.3683L2.60491 7.73884L2.02902 11.0871C2.02232 11.1339 2.01563 11.1741 2.01563 11.221C2.01563 11.3951 2.10268 11.5558 2.29688 11.5558C2.39063 11.5558 2.47768 11.5223 2.56473 11.4754L5.57143 9.89509L8.57813 11.4754C8.65848 11.5223 8.75223 11.5558 8.84598 11.5558C9.04018 11.5558 9.12054 11.3951 9.12054 11.221C9.12054 11.1741 9.12054 11.1339 9.11384 11.0871L8.53795 7.73884L10.9688 5.3683C11.0558 5.28125 11.1429 5.16741 11.1429 5.04687Z"/>
                    </svg>
                    <svg class="star-rating__star-icon" width="12" height="12" fill="#ccc" viewBox="0 0 12 12"
                         xmlns="http://www.w3.org/2000/svg" data-id="5">
                      <path
                          d="M11.1429 5.04687C11.1429 4.84598 10.9286 4.76562 10.7679 4.73884L7.40625 4.25L5.89955 1.20312C5.83929 1.07589 5.72545 0.928571 5.57143 0.928571C5.41741 0.928571 5.30357 1.07589 5.2433 1.20312L3.73661 4.25L0.375 4.73884C0.207589 4.76562 0 4.84598 0 5.04687C0 5.16741 0.0870536 5.28125 0.167411 5.3683L2.60491 7.73884L2.02902 11.0871C2.02232 11.1339 2.01563 11.1741 2.01563 11.221C2.01563 11.3951 2.10268 11.5558 2.29688 11.5558C2.39063 11.5558 2.47768 11.5223 2.56473 11.4754L5.57143 9.89509L8.57813 11.4754C8.65848 11.5223 8.75223 11.5558 8.84598 11.5558C9.04018 11.5558 9.12054 11.3951 9.12054 11.221C9.12054 11.1741 9.12054 11.1339 9.11384 11.0871L8.53795 7.73884L10.9688 5.3683C11.0558 5.28125 11.1429 5.16741 11.1429 5.04687Z"/>
                    </svg>
                  </span>
                                        <input type="hidden" name="rating" id="form-input-rating" value=""/>
                                        @error('rating') <span class="text-danger">{{$message}}</span>@enderror
                                    </div>
                                    <div class="mb-4">
                  <textarea id="form-input-review" name="review" class="form-control form-control_gray"
                            placeholder="Your Review"
                            cols="30" rows="8"></textarea>
                                        @error('review') <span class="text-danger">{{$message}}</span>@enderror
                                    </div>
                                    <input type="hidden" name="sellerId" value="{{$seller->id}}">
                                    <div class="form-check mb-4">
                                        <input class="form-check-input form-check-input_fill" type="checkbox" value=""
                                               id="remember_checkbox">
                                        <label class="form-check-label" for="remember_checkbox">
                                            Save my name, email, and website in this browser for the next time I comment.
                                        </label>
                                    </div>
                                    <div class="form-action">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="product-single__reviews-list">
                        @foreach($seller->reviews as $review)
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
                </section>
            </div>
            <div class="tab-pane fade" id="ask-a-question" role="tabpanel" aria-labelledby="ask-a-question-tab">
                <section>
                    <form action="{{route('user.createQuestion')}}" method="post">
                        @csrf
                        <input type="hidden" name="sellerId" value="{{$seller->id}}">

                        <div class="mb-4 p-4">
                            <div class="d-flex gap-3">
                                <div></div>
                                <div class="flex-grow-1">
                                    <label>Title</label>
                                    <input type="text" name="title" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="mb-4 p-4">
                            <div class="d-flex gap-3">
                                <img src="https://randomuser.me/api/portraits/women/4.jpg" alt="User Avatar" class="user-avatar">
                                <div class="flex-grow-1">
                                    <textarea name="comment" class="form-control comment-input" rows="3" placeholder="Write a comment..."></textarea>
                                </div>
                            </div>

                            <div class="mt-3 text-end">
                                <button type="submit" class="btn btn-primary">Post Comment</button>
                            </div>
                        </div>
                    </form>

                </section>
            </div>
        </div>
    </div>


@endsection
