@extends('layouts.admin')

@section('content')
    <div class="p-4">
        <div class="py-4">
            <h3 >Create Brand</h3>
        </div>

        <div class="card p-3">
            <div class="card-body">
                <form action="{{route('admin.brands.update', ['id' => $brand->id])}}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name"
                               value="{{$brand->name}}">
                        @error('name') <p class="invalid-feedback">{{$message}}</p> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Slug</label>
                        <input type="text" class="form-control" id="name" name="slug" placeholder="Slug"
                               value="{{$brand->slug}}">
                        @error('slug') <p class="invalid-feedback">{{$message}}</p> @enderror
                    </div>
                    <div>
                        <label for="exampleInputEmail1" class="form-label">Upload Image</label>
                    </div>
                    <div class="upload-image flex-grow">
                        <div class="item" id="imgpreview">
                            <img src="{{asset('images/brands')}}/{{$brand->image}}"
                                 alt="{{$brand->name}}" class="effect8">
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



