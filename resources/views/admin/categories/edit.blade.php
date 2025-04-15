<!-- main-content-wrap -->
<div class="card p-3">
    <div class="card-body">
        <form action="{{route('admin.categories.update', ['id' => $category->id])}}" method="POST"
              enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Name"
                       value="{{$category->name}}">
                @error('name') <p class="text-danger">{{$message}}</p> @enderror
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Slug</label>
                <input type="text" class="form-control" id="name" name="slug" placeholder="Slug"
                       value="{{$category->slug}}">
                @error('slug') <p class="text-danger">{{$message}}</p> @enderror
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Parent</label>
                <select class="form-select" name="parent_id">
                    <option value="">None</option>
                    @foreach($categories as $subcategory)
                        <option value="{{$subcategory->id}}"
                                @if($category->parent_id === $subcategory->id) selected="selected" @endif>{{$subcategory->name}}</option>
                    @endforeach
                </select>
                @error('parent_id') <p class="text-danger">{{$message}}</p> @enderror
            </div>
            <div>
                <label for="exampleInputEmail1" class="form-label">Upload Image</label>
            </div>
            <div class="upload-image flex-grow">
                <div class="item" id="imgpreview">
                    <img src="{{asset('images/categories')}}/{{$category->image}}" class="effect8" alt="">
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


