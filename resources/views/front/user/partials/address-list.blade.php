<div class="border-bottom py-4">
    <div class="nav flex-nowrap align-items-center justify-content-between pb-1 mb-3">
        <div class="d-flex align-items-center gap-3 me-4">
            <h2 class="h6 mb-0">Shipping address</h2>
            <span class="badge text-bg-info rounded-pill">Primary</span>
        </div>
        <a class="nav-link hiding-collapse-toggle text-decoration-underline p-0 collapsed" href=".primary-address"
            data-bs-toggle="collapse" aria-expanded="false"
            aria-controls="primaryAddressPreview primaryAddressEdit">Edit</a>
    </div>
    <div class="collapse primary-address show" id="primaryAddressPreview">
        <ul class="list-unstyled fs-sm m-0">
            <li>{{$address->name}}</li>
            <li>{{$address->address1}} {{$address->address2}}</li>
            <li>{{$address->state}}, {{$address->city}}</li>
            <li>{{$address->zip}}</li>
            <li>{{$address->country}}</li>
            <li>{{$address->phone}}</li>
        </ul>
    </div>
    <div class="collapse primary-address" id="primaryAddressEdit">
        <form class="row g-3 g-sm-4 needs-validation editAddressForm" novalidate=""
            action="{{route('user.updateAddress', ['addressId' => $address->id])}}" method="POST">
            @csrf
            @method('put')
            <div class="alert alert-success alert-dismissable d-none">Address updated successfully</div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-floating my-3">
                        <input type="text" class="form-control" name="name" value="{{$address->name}}">
                        <label for="name">Full Name *</label>
                        <span class="text-danger"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating my-3">
                        <input type="text" class="form-control" name="phone" value="{{$address->phone}}">
                        <label for="phone">Phone Number *</label>
                        <span class="text-danger"></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating my-3">
                        <input type="text" class="form-control" name="city" value="{{$address->city}}">
                        <label for="city">Town / City *</label>
                        <span class="text-danger"></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating mt-3 mb-3">
                        <input type="text" class="form-control" name="state" value="{{$address->state}}">
                        <label for="state">State *</label>
                        <span class="text-danger"></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating my-3">
                        <input type="text" class="form-control" name="zip" value="{{$address->zip}}">
                        <label for="zip">Zip *</label>
                        <span class="text-danger"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating my-3">
                        <input type="text" class="form-control" name="address1" value="{{$address->address1}}">
                        <label for="address">House no, Building Name *</label>
                        <span class="text-danger"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating my-3">
                        <input type="text" class="form-control" name="address2" value="{{$address->address2}}">
                        <label for="locality">Road Name, Area, Colony *</label>
                        <span class="text-danger"></span>
                    </div>
                </div>

                <div class="col-8 mb-3">
                    <label class="form-label" for="locality">Country *</label>

                    <select name="country_id" class="form-control">
                        @foreach ($countries as $country)
                            <option @if($address->country_id === $country->id) selected="selected" @endif value="{{ $country->id }}">{{$country->name}}</option>
                        @endforeach
                    </select>
                </div>
                {{-- <div class="col-md-6">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="isdefault" name="isdefault"
                            @if($address->is_defailt) checked="checked" @endif>
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