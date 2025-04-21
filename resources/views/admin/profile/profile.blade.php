@extends('layouts.admin')
@section('content')
    <style>
        .profile-card {
            max-width: 340px;
            background-color: #f8f9fa;
        }

        .profile-img {
            width: 150px;
            height: 150px;
            object-fit: cover;
        }
        .form-row>.col, .form-row>[class*=col-] {
            padding-right: 5px;
            padding-left: 5px;
        }
        .form-group {
            margin-bottom: 1rem;
        }

        .form-row {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            margin-right: -5px;
            margin-left: -5px;
        }
    </style>
    <div class="container py-5 bg-white">
        <div class="row">
            <div class="col-lg-3">
                <div class="text-center">
                    <div class="position-relative d-inline-block">
                        <img src="{{asset('images/sellers')}}/{{$profile->profile_picture}}" class="rounded-circle profile-pic" alt="Profile Picture" id="output">
                        <button id="upload-button" class="btn btn-primary btn-sm position-absolute bottom-0 end-0 rounded-circle">
                            <i class="fas fa-camera"></i>
                        </button>
                    </div>
                    <h3 class="mt-3 mb-1">{{$profile->name}}</h3>
                    <p class="text-muted mb-3">{{$profile->email}}</p>
                </div>
            </div>

            <div class="col-lg-9">
                <nav>
                    <div class="nav nav-pills nav-justified nav-fill" id="nav-tab" role="tablist">
                        <a class="nav-link active" id="nav-profile-tab" data-bs-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="true">Profile</a>
                        <a class="nav-link" id="nav-home-tab" data-bs-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="false">Home</a>
                        <a class="nav-link" id="nav-payment-tab" data-bs-toggle="tab" href="#nav-payment" role="tab" aria-controls="nav-payment" aria-selected="false">Payment</a>
                    </div>
                </nav>
                <div class="tab-content mt-5" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <div class="mb-4">
                            <h5 class="mb-4">Personal Information</h5>
                            <div class="row g-3">
                                <form method="post" action="{{route('admin.profile.update')}}" enctype="multipart/form-data">
                                    @csrf
                                    @method('put')
                                    <input id="file" type="file" name="profile_pic" onchange="loadFile(event)" style="display: none">
                                    <div class="form-row">
                                        <div class="form-group col-lg-6">
                                            <label for="inputPassword4">Full Name</label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{$profile->name}}">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="inputEmail4">Email</label>
                                            <input type="email" class="form-control" id="inputEmail4" name="email" placeholder="Email" value="{{$profile->email}}">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-lg-6">
                                            <label for="inputPassword4">Phone</label>
                                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" value="{{$profile->phone}}">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="inputEmail4">Username</label>
                                            <input type="text" class="form-control" id="inputEmail4" name="username" placeholder="Username" value="{{$profile->username}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputAddress">Address</label>
                                        <input type="text" class="form-control" id="inputAddress" name="address1" placeholder="1234 Main St" value="{{$profile->address1}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputAddress2">Address 2</label>
                                        <input type="text" class="form-control" id="inputAddress2" name="address2" placeholder="Apartment, studio, or floor" value="{{$profile->address2}}">
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-lg-6">
                                            <label for="inputCity">City</label>
                                            <input type="text" class="form-control" id="inputCity" name="city" value="{{$profile->city}}">
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="inputState">State</label>
                                            <input type="text" class="form-control" id="inputCity" name="state" value="{{$profile->state}}">
                                        </div>
                                        <div class="form-group col-lg-2">
                                            <label for="inputZip">Zip</label>
                                            <input type="text" class="form-control" id="inputZip" name="zip" value="{{$profile->zip}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputAddress2">Bio</label>
                                        <textarea class="form-control" id="inputAddress2" name="bio">{{$profile->biography}}</textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <p>clicked home</p>
                    </div>
                    <div class="tab-pane fade" id="nav-payment" role="tabpanel" aria-labelledby="nav-payment-tab">
                        <p>clicked contact</p>
                        <p>clicked contact</p>
                        <p>clicked contact</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
           $('#upload-button').on('click', function () {
               $('#file').click();
           });
        });

        var loadFile = function (event) {
            var image = document.getElementById("output");
            image.src = URL.createObjectURL(event.target.files[0]);
        };
    </script>
@endpush

