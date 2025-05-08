@extends('layouts.app')

@section('content')
    <style>
        .hstack {
            display: flex;
            flex-direction: row;
            align-items: center;
            align-self: stretch;
        }

        .vstack {
            display: flex;
            flex: 1 1 auto;
            flex-direction: column;
            align-self: stretch;
        }

        .text-body-secondary {
            color: #6c727f !important
        }

        .nav-link {
            background: none;
            border: 0;
            color: var(--cz-nav-link-color);
            display: block;
            font-size: var(--cz-nav-link-font-size);
            font-weight: var(--cz-nav-link-font-weight);
            padding: var(--cz-nav-link-padding-y) var(--cz-nav-link-padding-x);
            text-decoration: none;
            transition: color .2s ease-in-out, background-color .2s ease-in-out, border-color .2s ease-in-out;
        }

        .fs-sm {
            font-size: .875rem !important;
        }

        .fw-medium {
            font-weight: 500 !important;
        }
    </style>
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
                    <p>{{!empty($profile->email) ? App\Helper::obfuscateEmail($profile->email) : $seller->email}}</p>
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
                    <li>Website: {{$profile->website}}</li>
                </ul>

                <p>{{$profile->biography}}</p>
            </div>
            <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                <section class="reviews">
                    <div class="row g-4 pb-3">
                        <div class="col-sm-4">

                            <!-- Overall rating card -->
                            <div
                                class="d-flex flex-column align-items-center justify-content-center h-100 bg-body-tertiary rounded p-4">
                                <div class="h1 pb-2 mb-1">{{$seller->reviews()->avg('rating')}}</div>
                                <div class="hstack justify-content-center gap-1 fs-sm mb-2">
                                    <?php $test = $seller->reviews()->avg('rating') < 1 ? 1 : $seller->reviews()->avg('rating');?>
                                    @for ($x = 0; $x < $test; $x++)
                                        <i class="fa fa-star text-warning"></i>
                                    @endfor
                                </div>
                                <div class="fs-sm">{{$seller->reviews()->count()}}</div>
                            </div>
                        </div>

                        <div class="col-sm-8">

                            <!-- Rating breakdown by quantity -->
                            <div class="vstack gap-3">

                                <!-- 5 stars -->
                                <div class="hstack gap-2">
                                    <div class="hstack fs-sm gap-1">
                                        5<i class="ci-star-filled text-warning"></i>
                                    </div>
                                    <div class="progress w-100" role="progressbar" aria-label="Five stars"
                                        aria-valuenow="54" aria-valuemin="0" aria-valuemax="100" style="height: 4px">
                                        <div class="progress-bar bg-warning rounded-pill" style="width: 54%"></div>
                                    </div>
                                    <div class="fs-sm text-nowrap text-end" style="width: 40px;">37</div>
                                </div>

                                <!-- 4 stars -->
                                <div class="hstack gap-2">
                                    <div class="hstack fs-sm gap-1">
                                        4<i class="ci-star-filled text-warning"></i>
                                    </div>
                                    <div class="progress w-100" role="progressbar" aria-label="Four stars"
                                        aria-valuenow="23.5" aria-valuemin="0" aria-valuemax="100" style="height: 4px">
                                        <div class="progress-bar bg-warning rounded-pill" style="width: 23.5%"></div>
                                    </div>
                                    <div class="fs-sm text-nowrap text-end" style="width: 40px;">16</div>
                                </div>

                                <!-- 3 stars -->
                                <div class="hstack gap-2">
                                    <div class="hstack fs-sm gap-1">
                                        3<i class="ci-star-filled text-warning"></i>
                                    </div>
                                    <div class="progress w-100" role="progressbar" aria-label="Three stars"
                                        aria-valuenow="13" aria-valuemin="0" aria-valuemax="100" style="height: 4px">
                                        <div class="progress-bar bg-warning rounded-pill" style="width: 13%"></div>
                                    </div>
                                    <div class="fs-sm text-nowrap text-end" style="width: 40px;">9</div>
                                </div>

                                <!-- 2 stars -->
                                <div class="hstack gap-2">
                                    <div class="hstack fs-sm gap-1">
                                        2<i class="ci-star-filled text-warning"></i>
                                    </div>
                                    <div class="progress w-100" role="progressbar" aria-label="Two stars" aria-valuenow="6"
                                        aria-valuemin="0" aria-valuemax="100" style="height: 4px">
                                        <div class="progress-bar bg-warning rounded-pill" style="width: 6%"></div>
                                    </div>
                                    <div class="fs-sm text-nowrap text-end" style="width: 40px;">4</div>
                                </div>

                                <!-- 1 star -->
                                <div class="hstack gap-2">
                                    <div class="hstack fs-sm gap-1">
                                        1<i class="ci-star-filled text-warning"></i>
                                    </div>
                                    <div class="progress w-100" role="progressbar" aria-label="One star" aria-valuenow="3.5"
                                        aria-valuemin="0" aria-valuemax="100" style="height: 4px">
                                        <div class="progress-bar bg-warning rounded-pill" style="width: 3.5%"></div>
                                    </div>
                                    <div class="fs-sm text-nowrap text-end" style="width: 40px;">3</div>
                                </div>
                            </div>
                        </div>

                        @foreach($seller->reviews as $review)
                            <div class="border-bottom py-3 mb-3">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="text-nowrap me-3">
                                        <img style="width:100px" loading="lazy"
                                            src="{{ asset('images/users') }}/{{ $review->customer->image }}" alt="" />
                                        <span class="h6 mb-0">{{$review->customer->name}}</span>
                                        <i class="ci-check-circle text-success align-middle ms-1" data-bs-toggle="tooltip"
                                            data-bs-placement="top" data-bs-custom-class="tooltip-sm"
                                            data-bs-title="Verified customer"></i>
                                    </div>
                                    <span
                                        class="text-body-secondary fs-sm ms-auto">{{$review->created_at->diffForHumans()}}</span>
                                </div>
                                <div class="d-flex gap-1 fs-sm pb-2 mb-1">
                                    @for ($x = 0; $x < $review->rating; $x++)
                                        <i class="fa fa-star text-warning"></i>
                                    @endfor
                                </div>
                                <p class="fs-sm">{{$review->comment}}</p>

                                @if(!empty($review->replies))
                                    <img class="ms-4" style="width:100px" loading="lazy"
                                        src="{{ asset('images/sellers') }}/{{ $profile->profile_picture }}"
                                        alt="" />{{ $review->replies->customer->name }} Replied {{ $review->replies->comment }}
                                @endif

                                <div class="nav align-items-center">
                                    {{-- <button type="button" class="nav-link animate-underline px-0">
                                        <i class="fa fa-corner-down-right fs-base ms-1 me-1"></i>
                                        <span class="animate-target">Reply</span>
                                    </button> --}}
                                    <button type="button" class="nav-link text-body-secondary animate-scale px-0 ms-auto me-n1">
                                        <i class="fa fa-thumbs-up fs-base animate-target me-1"></i>
                                        0
                                    </button>
                                    <hr class="vr my-2 mx-3">
                                    <button type="button" class="nav-link text-body-secondary animate-scale px-0 ms-n1">
                                        <i class="fa fa-thumbs-down fs-base animate-target me-1"></i>
                                        0
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>
            <div class="tab-pane fade" id="ask-a-question" role="tabpanel" aria-labelledby="ask-a-question-tab">
                <section>
                    @include('front.seller.partials.ask-a-question')

                </section>
            </div>
        </div>

        @if($sellerProducts->count() > 0)
            @include('front.partials.product-row', ['products' => $sellerProducts, 'title' => 'Products from this seller', 'currency' => $currency])
        @endif
    </div>


@endsection