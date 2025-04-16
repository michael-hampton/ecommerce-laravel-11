@extends('layouts.app')
@section('content')
    <div class="container mt-4">
        <div class="row">
            @include('front.user.account-nav', ['current' => 'address'])

            <div class="col-lg-9 my-lg-0 my-1">
                <div class="page-content my-account__address">
                    <div class="row">
                        <div class="col-6">
                            <p class="notice">The following addresses will be used on the checkout page by
                                default.</p>
                        </div>
                        <div class="col-6 text-right">
                            <a href="{{route('user.addAddress')}}" class="btn btn-sm btn-info">Add New</a>
                        </div>
                    </div>
                    <div class="my-account__address-list row">
                        <h5>Shipping Addresses</h5>

                        @foreach($addresses as $address)
                            <div class="my-account__address-item col-md-6">
                                <div class="my-account__address-item__title">
                                    <h5>{{$address->customer->name}} <i class="fa fa-check-circle text-success"></i>
                                    </h5>
                                    <a href="{{route('user.editAddress', ['addressId' => $address->id])}}">Edit</a>
                                </div>
                                <div class="my-account__address-item__detail">
                                    <p>{{$address->address1}} {{$address->address2}}</p>
                                    <p>{{$address->state}}, {{$address->city}}</p>
                                    <p>{{$address->zip}}</p>
                                    <p>{{$address->country}}</p>
                                    <br>
                                    <p>{{$address->phone}}</p>
                                </div>
                            </div>
                            <hr>
                        @endforeach
                        <hr>

                    </div>
                </div>
            </div>
        </div>
@endsection







