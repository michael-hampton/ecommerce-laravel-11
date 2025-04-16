@extends('layouts.app')
@section('content')
    <div class="container mt-4">
        <div class="row">
            @include('front.user.account-nav', ['current' => 'reviews'])

            <div class="col-lg-9 my-lg-0 my-1">
                <div class="page-content my-account__address">
                    @foreach($reviews as $review)
                        <div class="bg-body-tertiary rounded-4 p-4 p-sm-5">
                            <div class="vstack gap-3 gap-md-4 mt-n3">

                                <!-- Comment -->
                                <div class="mt-3">
                                    <div class="d-flex align-items-center justify-content-between gap-3 mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="ratio ratio-1x1 flex-shrink-0 bg-body-secondary rounded-circle overflow-hidden" style="width: 40px">
                                                <img src="{{asset('images/users/')}}/{{$review->customer->image}}" alt="{{$review->customer->name}}">
                                            </div>
                                            <div class="ps-2 ms-1">
                                                <div class="fs-sm fw-semibold text-dark-emphasis mb-1">{{$review->customer->name}}</div>
                                                <div class="fs-xs text-body-secondary">{{$review->created_at->diffForHumans()}}</div>
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
@endsection






