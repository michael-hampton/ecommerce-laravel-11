<div class="card p-3">
    <div class="card-body">
        <form action="{{route('admin.users.update', ['id' => $user->id])}}" method="POST"
              enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Name"
                       value="{{$user->name}}">
                @error('name') <p class="invalid-feedback">{{$message}}</p> @enderror
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Mobile</label>
                <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile"
                       value="{{$user->mobile}}">
                @error('mobile') <p class="invalid-feedback">{{$message}}</p> @enderror
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email</label>
                <input type="email" class="form-control" id="name" name="email" placeholder="Email"
                       value="{{$user->email}}">
                @error('email') <p class="invalid-feedback">{{$message}}</p> @enderror
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Role</label>
                <select class="form-control" id="utype" name="utype">
                    <option>Select Role</option>
                    <option value="ADM" @if($user->utype === 'ADM') selected="selected" @endif>Admin</option>
                    <option value="USR" @if($user->utype === 'USR') selected="selected" @endif>User</option>
                    <option value="SUPER" @if($user->utype === 'SUPER') selected="selected" @endif>SuperAdmin</option>
                </select>
                @error('utype') <p class="invalid-feedback">{{$message}}</p> @enderror
            </div>
            <div>
                <label for="exampleInputEmail1" class="form-label">Upload Image</label>
            </div>
            <div class="upload-image flex-grow">
                <div class="item" id="imgpreview">
                    <img src="{{asset('images/users')}}/{{$user->image}}"
                         alt="{{$user->name}}" class="effect8">
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



