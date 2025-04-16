<form class="form-horizontal" action="{{route('admin.attributeValues.update',  ['id' => $attributeValue->id])}}" method="post">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Name"
               value="{{$attributeValue->name}}">
        <p class="invalid-feedback"></p>
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Attribute</label>
        <select class="form-control" id="attribute_id" name="attribute_id">
            <option value="">Select Attribute</option>
            @foreach($attributes as $attribute)
                <option value="{{$attribute->id}}" @if($attribute->id === $attributeValue->attribute_id) selected="selected" @endif>{{$attribute->name}}</option>
            @endforeach
        </select>
    </div>
</form>
