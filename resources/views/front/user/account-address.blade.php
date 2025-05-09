@extends('layouts.app')
@section('content')
    <div class="container mt-4">
        <div class="row">
            @include('front.user.account-nav', ['current' => 'address'])

            <div class="col-lg-9 my-lg-0 my-1">
                <div class="ps-lg-3 ps-xl-0" id="addressList">

                    <!-- Page title -->
                    <h1 class="h2 mb-1 mb-sm-2">Addresses</h1>

                    <!-- Primary shipping address -->
                    @include('front.user.partials.address-list', ['address' => $defaultAddress])

                    <!-- Alternative shipping address -->
                    @foreach($otherAddresses as $otherAddress)
                        @include('front.user.partials.address-list', ['address' => $otherAddress])
                    @endforeach

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
                    <form id="addAddress" class="row g-3 g-lg-4 needs-validation"
                        action="{{route('user.storeAddress')}}" method="POST">
                        @csrf
                        <div class="alert alert-success alert-dismissable d-none">Address created successfully</div>

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
                        <div class="col-8">
                            <label class="form-label" for="locality">Country *</label>

                            <select name="country_id" class="form-control">
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}">{{$country->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <div class="form-check mb-0">
                                <input type="checkbox" class="form-check-input" id="set-primary-3" name="is_default">
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

    @push('scripts')
        <script>
            const editForms = document.getElementsByClassName('editAddressForm')

            Array.from(editForms).forEach(element => {
                element.addEventListener('submit', (event) => {
                    event.preventDefault()
                    const action = event.currentTarget.getAttribute('action')
                    const formData = new FormData(event.target)
                    formData.append('_method', 'PUT')

                    $.ajax({
                        url: action,
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                    }).done(function (msg) {
                        const mess = event.target.getElementsByClassName('alert-success')[0]
                        mess.classList.remove('d-none')
                    });
                })
            });

            const addAddress = document.getElementById('addAddress')
            addAddress.addEventListener('submit', (event) => {
                event.preventDefault()
                const action = event.currentTarget.getAttribute('action')
                const formData = new FormData(event.target)

                $.ajax({
                    url: action,
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                }).done(function (msg) {
                    const addressList = document.getElementById('addressList')
                    addressList.insertAdjacentHTML('beforeend', msg.view)
                    const mess = event.target.getElementsByClassName('alert-success')[0]
                    mess.classList.remove('d-none')
                    var myModalEl = document.getElementById('newAddressModal');
                    var modal = bootstrap.Modal.getInstance(myModalEl)
                    modal.hide();
                });
            })
        </script>
    @endpush