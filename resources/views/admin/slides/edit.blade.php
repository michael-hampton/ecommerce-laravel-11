@extends('layouts.admin')

@section('content')
    <div class="p-4">
        <div class="py-4">
            <h3 >Create Brand</h3>
        </div>

        <div class="card p-3">
            <div class="card-body">
                <form action="{{route('admin.slides.update', ['id' => $slide->id])}}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Title"
                               value="{{$slide->title}}">
                        @error('title') <p class="invalid-feedback">{{$message}}</p> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">SubTitle</label>
                        <input type="text" class="form-control" id="subtitle" name="subtitle" placeholder="Subtitle"
                               value="{{$slide->subtitle}}">
                        @error('subtitle') <p class="invalid-feedback">{{$message}}</p> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Tags</label>
                        <input type="text" class="form-control" id="tags" name="tags" placeholder="Tags"
                               value="{{$slide->tags}}">
                        @error('tags') <p class="invalid-feedback">{{$message}}</p> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Link</label>
                        <input type="text" class="form-control" id="link" name="link" placeholder="Link"
                               value="{{$slide->link}}">
                        @error('link') <p class="invalid-feedback">{{$message}}</p> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Link Text</label>
                        <input type="text" class="form-control" id="link_text" name="link_text" placeholder="Link Text"
                               value="{{$slide->link_text}}">
                        @error('link_text') <p class="invalid-feedback">{{$message}}</p> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Status</label>
                        <select class="form-control" id="active" name="active">
                            <option value="">Select</option>
                            <option value="1" @if($slide->active === 1) selected="selected" @endif>Active</option>
                            <option value="0" @if($slide->active === 0) selected="selected" @endif>Inactive</option>
                        </select>
                        @error('active') <p class="invalid-feedback">{{$message}}</p> @enderror
                    </div>
                    <div>
                        <label for="exampleInputEmail1" class="form-label">Upload Image</label>
                    </div>
                    <div class="upload-image flex-grow">
                        <div class="item" id="imgpreview">
                            <img src="{{asset('images/slides')}}/{{$slide->image}}" class="effect8" alt="">
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



