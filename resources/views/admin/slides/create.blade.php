<div class="card p-3">
    <div class="card-body">
        <form action="{{route('admin.slides.store')}}" method="POST"
              enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Title"
                       value="{{old('title')}}">
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">SubTitle</label>
                <input type="text" class="form-control" id="subtitle" name="subtitle" placeholder="Subtitle"
                       value="{{old('subtitle')}}">
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Tags</label>
                <input type="text" class="form-control" id="tags" name="tags" placeholder="Tags"
                       value="{{old('tags')}}">
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Link</label>
                <input type="text" class="form-control" id="link" name="link" placeholder="Link"
                       value="{{old('link')}}">
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Link Text</label>
                <input type="text" class="form-control" id="link_text" name="link_text" placeholder="Link Text"
                       value="{{old('link_text')}}">
            </div>
            <select class="form-control" id="active" name="active">
                <option value="">Select</option>
                <option value="1" @if(old('status') == 1) selected="selected" @endif>Active</option>
                <option value="0" @if(old('status') == 0) selected="selected" @endif>Inactive</option>
            </select>
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
        </form>
    </div>
</div>

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



