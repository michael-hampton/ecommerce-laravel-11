<form class="form-horizontal" action="{{route('admin.attributes.update', ['id' => $attribute->id])}}" method="post">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Name"
               value="{{$attribute->name}}">
        <p class="invalid-feedback"></p>
    </div>
</form>
