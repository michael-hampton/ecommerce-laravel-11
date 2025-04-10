@extends('layouts.admin')

@section('content')
    <div class="p-4">
        <div class="py-4">
            <h3 >Create User</h3>
        </div>

        <div class="card p-3">
            <div class="card-body">
                <form action="{{route('admin.users.store')}}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name"
                               value="{{old('name')}}">
                        @error('name') <p class="invalid-feedback">{{$message}}</p> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Mobile</label>
                        <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile"
                               value="{{old('mobile')}}">
                        @error('mobile') <p class="invalid-feedback">{{$message}}</p> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email</label>
                        <input type="email" class="form-control" id="name" name="email" placeholder="Email"
                               value="{{old('email')}}">
                        @error('email') <p class="invalid-feedback">{{$message}}</p> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                               value="{{old('password')}}">
                        @error('password') <p class="invalid-feedback">{{$message}}</p> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm" name="confirm" placeholder="Password"
                               value="{{old('confirm')}}">
                        @error('confirm') <p class="invalid-feedback">{{$message}}</p> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Role</label>
                        <select class="form-control" id="utype" name="utype">
                            <option>Select Role</option>
                            <option value="ADM">Admin</option>
                            <option value="USR">User</option>
                            <option value="SUPER">SuperAdmin</option>
                        </select>
                        @error('utype') <p class="invalid-feedback">{{$message}}</p> @enderror
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" name="active">
                        <label class="form-check-label" for="flexSwitchCheckDefault">Active</label>
                    </div>
                    <div>
                        <label for="exampleInputEmail1" class="form-label">Upload Image</label>
                    </div>
                    <div class="upload-image flex-grow">
                        <div class="item" id="imgpreview" style="display:none">
                            <img src="upload-1.html" class="effect8" alt="">
                        </div>
                        <div id="upload-file" class="item up-load">
                            <label class="uploadfile" for="myFile">
                                                        <span class="icon">
                                                            <i class="icon-upload-cloud"></i>
                                                        </span>
                                <span class="body-text">Drop your images here or select <span
                                        class="tf-color">click to browse</span></span>
                                <input type="file" id="myFile" name="image" accept="image/*">
                            </label>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push("scripts")
    <script>
        $(function () {
            $("#myFile").on("change", function (e) {
                const photoInp = $("#myFile");
                const [file] = this.files;
                if (file) {
                    $("#imgpreview img").attr('src', URL.createObjectURL(file));
                    $("#imgpreview").show();
                }
            });
            $("input[name='name']").on("change", function () {
                $("input[name='slug']").val(StringToSlug($(this).val()));
            });

        });

        function StringToSlug(Text) {
            return Text.toLowerCase()
                .replace(/[^\w ]+/g, "")
                .replace(/ +/g, "-");
        }
    </script>
@endpush



