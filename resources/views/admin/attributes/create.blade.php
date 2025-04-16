<form class="form-horizontal" action="{{route('admin.attributes.store')}}" method="post">
    @csrf
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Name"
               value="{{old('name')}}">
    </div>
</form>
