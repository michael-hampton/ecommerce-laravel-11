@extends('layouts.app')
@section('content')
    <div class="p-5">
        <div class="col-lg-4">
            <div class="d-flex justify-content-between align-items-center">
                <img class="rounded-circle" style="width: 200px;"
                    src="{{ asset('images/sellers') }}/{{ $profile->profile_picture }}">
                <div class="details">
                    <h1 class="product-single__name">{{$seller->name}}</h1>
                    <div class="d-flex">
                        <div class="product-single__rating">
                            <div class="reviews-group d-flex">
                                @for ($x = 0; $x < $seller->reviews()->avg('rating'); $x++)
                                    <i class="fa fa-star text-warning"></i>
                                @endfor
                            </div>
                        </div>

                        <span class="reviews-note text-lowercase text-secondary ms-1">{{$seller->reviews()->count()}}
                            reviews</span>
                    </div>
                    <p>{{!empty($profile->email) ? $profile->email : $seller->email}}</p>
                </div>
            </div>
        </div>

        <ul class="nav nav-pills nav-fill" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button"
                    role="tab" aria-controls="details" aria-selected="true">Details</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab"
                    aria-controls="reviews" aria-selected="false">Reviews</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="ask-a-question-tab" data-bs-toggle="tab" data-bs-target="#ask-a-question"
                    type="button" role="tab" aria-controls="ask-a-question" aria-selected="false">Ask a Question</a>
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
                                <form name="customer-review-form"
                                    action="{{route('storeSellerReview', ['sellerId' => $seller->id])}}" method="post">
                                    @csrf
                                    @if(Session::has('message'))
                                        <div class="alert alert-success">{{Session::get('message')}}</div>
                                    @endif
                                    <h5>Be the first to review “{{$seller->name}}”</h5>
                                    <p>Your email address will not be published. Required fields are marked *</p>
                                    <div class="select-star-rating">
                                        <label>Your rating *</label>
                                        <span class="star-rating">
                                            @for ($x = 0; $x < 5; $x++)
                                                <i class="fa fa-star"></i>
                                            @endfor
                                        </span>
                                        <input type="hidden" name="rating" id="form-input-rating" value="" />
                                        @error('rating') <span class="text-danger">{{$message}}</span>@enderror
                                    </div>
                                    <div class="mb-4">
                                        <textarea id="form-input-review" name="review"
                                            class="form-control form-control_gray" placeholder="Your Review" cols="30"
                                            rows="8"></textarea>
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
                                    <img loading="lazy" src="assets/images/avatar.jpg" alt="" />
                                </div>
                                <div class="customer-review">
                                    <div class="customer-name">
                                        <h6>{{$review->customer->name}}</h6>
                                        <div class="reviews-group d-flex">
                                            @for ($x = 0; $x < $review->rating; $x++)
                                                <i class="fa fa-star text-warning"></i>
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
                                <img src="https://randomuser.me/api/portraits/women/4.jpg" alt="User Avatar"
                                    class="user-avatar">
                                <div class="flex-grow-1">
                                    <textarea name="comment" class="form-control comment-input" rows="3"
                                        placeholder="Write a comment..."></textarea>
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

        @if($sellerProducts->count() > 0)
            @include('front.partials.product-row', ['products' => $sellerProducts, 'title' => 'Products from this seller', 'currency' => $currency])
        @endif
    </div>


@endsection

@push('scripts')
    <script>
        $(function () {
            StarRating()
        })

        function StarRating() {
            let stars = Array.from(document.querySelectorAll('.fa-star'));
            let user_selected_star = document.querySelector('#form-input-rating');

            stars.forEach(star => {
                // Mouseover event
                star.addEventListener('mouseover', (e) => {
                    stars.forEach((item, current_index) => {
                        if (current_index <= stars.indexOf(e.target)) {
                            item.classList.add('text-warning');
                        } else {
                            if (!item.classList.contains('is-selected')) {
                                item.classList.remove('text-warning');
                            }
                        }
                    })
                })

                // Mouseover event
                star.addEventListener('mouseleave', (e) => {
                    stars.forEach((item) => {
                        if (!item.classList.contains('is-selected')) {
                            item.classList.remove('text-warning');
                        }
                    })
                })

                // Click event
                star.addEventListener('click', (e) => {
                    const selected_index = stars.indexOf(e.target);
                    user_selected_star.value = selected_index + 1;
                    stars.forEach((item, current_index) => {
                        if (current_index <= stars.indexOf(e.target)) {
                            item.classList.add('is-selected', 'text-warning');
                        } else {
                            item.classList.remove('is-selected', 'text-warning');
                        }
                    })
                })
            })
        }
    </script>
@endpush