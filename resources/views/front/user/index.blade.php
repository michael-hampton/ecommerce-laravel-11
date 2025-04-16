@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <div class="row">
        @include('front.user.account-nav', ['current' => 'account'])

        <div class="col-lg-9 my-lg-0 my-1">
            <div id="main-content" class="bg-white border">
                <div class="d-flex flex-column">
                    <div class="h5">Hello {{auth()->user()->name}},</div>
                    <div>Logged in as: {{auth()->user()->email}}</div>
                </div>
                <div class="d-flex my-4 flex-wrap">
                    <div class="box me-4 my-1 bg-light">
                        <img src="https://www.freepnglogos.com/uploads/box-png/cardboard-box-brown-vector-graphic-pixabay-2.png"
                             alt="">
                        <div class="d-flex align-items-center mt-2">
                            <div class="tag">Orders placed</div>
                            <div class="ms-auto number">10</div>
                        </div>
                    </div>
                    <div class="box me-4 my-1 bg-light">
                        <img src="https://www.freepnglogos.com/uploads/shopping-cart-png/shopping-cart-campus-recreation-university-nebraska-lincoln-30.png"
                             alt="">
                        <div class="d-flex align-items-center mt-2">
                            <div class="tag">Items in Cart</div>
                            <div class="ms-auto number">10</div>
                        </div>
                    </div>
                    <div class="box me-4 my-1 bg-light">
                        <img src="https://www.freepnglogos.com/uploads/love-png/love-png-heart-symbol-wikipedia-11.png"
                             alt="">
                        <div class="d-flex align-items-center mt-2">
                            <div class="tag">Wishlist</div>
                            <div class="ms-auto number">10</div>
                        </div>
                    </div>
                </div>
                <div class="text-uppercase">My recent orders</div>
                <div class="order my-3 bg-light">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="d-flex flex-column justify-content-between order-summary">
                                <div class="d-flex align-items-center">
                                    <div class="text-uppercase">Order #fur10001</div>
                                    <div class="blue-label ms-auto text-uppercase">paid</div>
                                </div>
                                <div class="fs-8">Products #03</div>
                                <div class="fs-8">22 August, 2020 | 12:05 PM</div>
                                <div class="rating d-flex align-items-center pt-1">
                                    <img src="https://www.freepnglogos.com/uploads/like-png/like-png-hand-thumb-sign-vector-graphic-pixabay-39.png"
                                         alt=""><span class="px-2">Rating:</span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="d-sm-flex align-items-sm-start justify-content-sm-between">
                                <div class="status">Status : Delivered</div>
                                <div class="btn btn-primary text-uppercase">order info</div>
                            </div>
                            <div class="progressbar-track">
                                <ul class="progressbar">
                                    <li id="step-1" class="text-muted green">
                                        <span class="fa fa-gift"></span>
                                    </li>
                                    <li id="step-2" class="text-muted green">
                                        <span class="fa fa-check"></span>
                                    </li>
                                    <li id="step-3" class="text-muted green">
                                        <span class="fa fa-box"></span>
                                    </li>
                                    <li id="step-4" class="text-muted green">
                                        <span class="fa fa-truck"></span>
                                    </li>
                                    <li id="step-5" class="text-muted green">
                                        <span class="fa fa-box-open"></span>
                                    </li>
                                </ul>
                                <div id="tracker"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="order my-3 bg-light">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="d-flex flex-column justify-content-between order-summary">
                                <div class="d-flex align-items-center">
                                    <div class="text-uppercase">Order #fur10001</div>
                                    <div class="green-label ms-auto text-uppercase">cod</div>
                                </div>
                                <div class="fs-8">Products #03</div>
                                <div class="fs-8">22 August, 2020 | 12:05 PM</div>
                                <div class="rating d-flex align-items-center pt-1">
                                    <img src="https://www.freepnglogos.com/uploads/like-png/like-png-hand-thumb-sign-vector-graphic-pixabay-39.png"
                                         alt=""><span class="px-2">Rating:</span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="d-sm-flex align-items-sm-start justify-content-sm-between">
                                <div class="status">Status : Delivered</div>
                                <div class="btn btn-primary text-uppercase">order info</div>
                            </div>
                            <div class="progressbar-track">
                                <ul class="progressbar">
                                    <li id="step-1" class="text-muted green">
                                        <span class="fa fa-gift"></span>
                                    </li>
                                    <li id="step-2" class="text-muted">
                                        <span class="fa fa-check"></span>
                                    </li>
                                    <li id="step-3" class="text-muted">
                                        <span class="fa fa-box"></span>
                                    </li>
                                    <li id="step-4" class="text-muted">
                                        <span class="fa fa-truck"></span>
                                    </li>
                                    <li id="step-5" class="text-muted">
                                        <span class="fa fa-box-open"></span>
                                    </li>
                                </ul>
                                <div id="tracker"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
