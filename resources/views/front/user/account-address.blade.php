@extends('layouts.app')
@section('content')
    <div class="container mt-4">
        <div class="row">
            @include('front.user.account-nav', ['current' => 'address'])

            <div class="col-lg-9 my-lg-0 my-1">
                <div class="ps-lg-3 ps-xl-0">

                    <!-- Page title -->
                    <h1 class="h2 mb-1 mb-sm-2">Addresses</h1>

                    <!-- Primary shipping address -->
                    <div class="border-bottom py-4">
                        <div class="nav flex-nowrap align-items-center justify-content-between pb-1 mb-3">
                            <div class="d-flex align-items-center gap-3 me-4">
                                <h2 class="h6 mb-0">Shipping address</h2>
                                <span class="badge text-bg-info rounded-pill">Primary</span>
                            </div>
                            <a class="nav-link hiding-collapse-toggle text-decoration-underline p-0 collapsed"
                                href=".primary-address" data-bs-toggle="collapse" aria-expanded="false"
                                aria-controls="primaryAddressPreview primaryAddressEdit">Edit</a>
                        </div>
                        <div class="collapse primary-address show" id="primaryAddressPreview">
                            <ul class="list-unstyled fs-sm m-0">
                                <li>{{$defaultAddress->address1}} {{$defaultAddress->address2}}</li>
                                <li>{{$defaultAddress->state}}, {{$defaultAddress->city}}</li>
                                <li>{{$defaultAddress->zip}}</li>
                                <li>{{$defaultAddress->country}}</li>
                                <li>{{$defaultAddress->phone}}</li>
                            </ul>
                        </div>
                        <div class="collapse primary-address" id="primaryAddressEdit">
                            <form class="row g-3 g-sm-4 needs-validation" novalidate=""
                                action="{{route('user.updateAddress', ['addressId' => $defaultAddress->id])}}"
                                method="POST">
                                @csrf
                                @method('put')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating my-3">
                                            <input type="text" class="form-control" name="name"
                                                value="{{$defaultAddress->name}}">
                                            <label for="name">Full Name *</label>
                                            <span class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating my-3">
                                            <input type="text" class="form-control" name="phone"
                                                value="{{$defaultAddress->phone}}">
                                            <label for="phone">Phone Number *</label>
                                            <span class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating my-3">
                                            <input type="text" class="form-control" name="city"
                                                value="{{$defaultAddress->city}}">
                                            <label for="city">Town / City *</label>
                                            <span class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating mt-3 mb-3">
                                            <input type="text" class="form-control" name="state"
                                                value="{{$defaultAddress->state}}">
                                            <label for="state">State *</label>
                                            <span class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating my-3">
                                            <input type="text" class="form-control" name="zip"
                                                value="{{$defaultAddress->zip}}">
                                            <label for="zip">Zip *</label>
                                            <span class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating my-3">
                                            <input type="text" class="form-control" name="address1"
                                                value="{{$defaultAddress->address1}}">
                                            <label for="address">House no, Building Name *</label>
                                            <span class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating my-3">
                                            <input type="text" class="form-control" name="address2"
                                                value="{{$defaultAddress->address2}}">
                                            <label for="locality">Road Name, Area, Colony *</label>
                                            <span class="text-danger"></span>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" id="isdefault"
                                                name="isdefault" @if($defaultAddress->is_defailt) checked="checked" @endif>
                                            <label class="form-check-label" for="isdefault">
                                                Make as Default address
                                            </label>
                                        </div>
                                    </div> --}}
                                    <div class="col-12">
                                        <div class="d-flex gap-3 pt-2 pt-sm-0">
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                            <button type="button" class="btn btn-secondary" data-bs-toggle="collapse"
                                                data-bs-target=".primary-address" aria-expanded="true"
                                                aria-controls="primaryAddressPreview primaryAddressEdit">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Alternative shipping address -->
                    <div class="border-bottom py-4">
                        <div class="nav flex-nowrap align-items-center justify-content-between pb-1 mb-3">
                            <div class="d-flex align-items-center gap-3 me-4">
                                <h2 class="h6 mb-0">Alternative shipping address</h2>
                            </div>
                            <a class="nav-link hiding-collapse-toggle text-decoration-underline p-0 collapsed"
                                href=".alternative-address" data-bs-toggle="collapse" aria-expanded="false"
                                aria-controls="alternativeAddressPreview alternativeAddressEdit">Edit</a>
                        </div>
                        <div class="collapse alternative-address show" id="alternativeAddressPreview">
                            <ul class="list-unstyled fs-sm m-0">
                                <li>{{$otherAddress->address1}} {{$otherAddress->address2}}</li>
                                <li>{{$otherAddress->state}}, {{$otherAddress->city}}</li>
                                <li>{{$otherAddress->zip}}</li>
                                <li>{{$otherAddress->country}}</li>
                                <li>{{$otherAddress->phone}}</li>
                            </ul>
                        </div>
                        <div class="collapse alternative-address" id="alternativeAddressEdit">
                            <form class="row g-3 g-sm-4 needs-validation" novalidate=""
                                action="{{route('user.updateAddress', ['addressId' => $otherAddress->id])}}" method="POST">
                                @csrf
                                @method('put')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating my-3">
                                            <input type="text" class="form-control" name="name"
                                                value="{{$otherAddress->name}}">
                                            <label for="name">Full Name *</label>
                                            <span class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating my-3">
                                            <input type="text" class="form-control" name="phone"
                                                value="{{$otherAddress->phone}}">
                                            <label for="phone">Phone Number *</label>
                                            <span class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating my-3">
                                            <input type="text" class="form-control" name="city"
                                                value="{{$otherAddress->city}}">
                                            <label for="city">Town / City *</label>
                                            <span class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating mt-3 mb-3">
                                            <input type="text" class="form-control" name="state"
                                                value="{{$otherAddress->state}}">
                                            <label for="state">State *</label>
                                            <span class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating my-3">
                                            <input type="text" class="form-control" name="zip"
                                                value="{{$otherAddress->zip}}">
                                            <label for="zip">Zip *</label>
                                            <span class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating my-3">
                                            <input type="text" class="form-control" name="address1"
                                                value="{{$otherAddress->address1}}">
                                            <label for="address">House no, Building Name *</label>
                                            <span class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating my-3">
                                            <input type="text" class="form-control" name="address2"
                                                value="{{$otherAddress->address2}}">
                                            <label for="locality">Road Name, Area, Colony *</label>
                                            <span class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check mb-0">
                                            <input type="checkbox" class="form-check-input" id="set-primary-2"
                                                name=isdefault>
                                            <label for="set-primary-2" class="form-check-label">Set as primary
                                                address</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex gap-3 pt-2 pt-sm-0">
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                            <button type="button" class="btn btn-secondary" data-bs-toggle="collapse"
                                                data-bs-target=".alternative-address" aria-expanded="true"
                                                aria-controls="alternativeAddressPreview alternativeAddressEdit">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Add address button -->
                    <div class="nav pt-4">
                        <a class="nav-link animate-underline fs-base px-0" href="#newAddressModal" data-bs-toggle="modal">
                            <i class="ci-plus fs-lg ms-n1 me-2"></i>
                            <span class="animate-target">Add address</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
@endsection

    <div class="modal fade" id="newAddressModal" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="newAddressModalLabel" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newAddressModalLabel">Add new address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3 g-lg-4 needs-validation" action="{{route('user.storeAddress')}}" method="POST">
                        @csrf
                        <div class="col-md-6">
                            <label class="form-label" for="name">Full Name *</label>
                            <input type="text" class="form-control" name="name" value="">
                            <span class="text-danger"></span>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="phone">Phone Number *</label>
                            <input type="text" class="form-control" name="phone" value="">
                            <span class="text-danger"></span>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="city">Town / City *</label>
                            <input type="text" class="form-control" name="city" value="">
                            <span class="text-danger"></span>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="state">State *</label>
                            <input type="text" class="form-control" name="state" value="">
                            <span class="text-danger"></span>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="zip">Zip *</label>
                            <input type="text" class="form-control" name="zip" value="">
                            <span class="text-danger"></span>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="address">House no, Building Name *</label>
                            <input type="text" class="form-control" name="address1" value="">
                            <span class="text-danger"></span>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="locality">Road Name, Area, Colony *</label>
                            <input type="text" class="form-control" name="address2" value="">
                            <span class="text-danger"></span>
                        </div>
                        <div class="col-12">
                            <div class="form-check mb-0">
                                <input type="checkbox" class="form-check-input" id="set-primary-3" name="isdefault">
                                <label for="set-primary-3" class="form-check-label">Set as primary address</label>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="d-flex gap-3 pt-2 pt-sm-0">
                                <button type="submit" class="btn btn-primary">Add address</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>