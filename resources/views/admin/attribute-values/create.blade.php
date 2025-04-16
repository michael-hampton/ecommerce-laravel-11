<form class="form-horizontal" action="{{route('admin.attributeValues.store')}}" method="post">
    @csrf
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Name"
               value="{{old('name')}}">
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Attribute</label>
        <select class="form-control" id="attribute_id" name="attribute_id">
            <option value="">Select Attribute</option>
            @foreach($attributes as $attribute)
                <option value="{{$attribute->id}}" @if($attribute->id === old('attribute_id')) selected="selected" @endif>{{$attribute->name}}</option>
            @endforeach
        </select>
    </div>
</form>
