<div class="card p-3">
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{route('admin.coupons.store')}}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Coupon Code</label>
                <input type="text" class="form-control" id="name" name="code" placeholder="Code"
                       value="{{old('name')}}">
                @error('code') <p class="invalid-feedback">{{$message}}</p> @enderror
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Coupon Type</label>
                <select class="form-select" name="type">
                    <option value="">Select</option>
                    <option value="fixed">Fixed</option>
                    <option value="percent">Percent</option>
                </select>
                @error('type') <p class="invalid-feedback">{{$message}}</p> @enderror
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Coupon Value</label>
                <input type="text" class="form-control" id="name" name="value" placeholder="Value"
                       value="{{old('value')}}">
                @error('value') <p class="invalid-feedback">{{$message}}</p> @enderror
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Cart Value</label>
                <input type="text" class="form-control" id="cart_value" name="cart_value"
                       placeholder="Cart Value"
                       value="{{old('cart_value')}}">
                @error('cart_value') <p class="invalid-feedback">{{$message}}</p> @enderror
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">No of times coupon can be used</label>
                <input type="text" class="form-control" id="usages" name="usages" placeholder="Usages"
                       value="{{old('usages')}}">
                @error('usages') <p class="invalid-feedback">{{$message}}</p> @enderror
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Expiry Date</label>
                <input type="date" class="form-control" id="expires_at" name="expires_at"
                       value="{{old('expires_at')}}">
                @error('expires_at') <p class="invalid-feedback">{{$message}}</p> @enderror
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Categories</label>
                <select class="form-select" multiple name="categories[]">
                    @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
                @error('categories') <p class="invalid-feedback">{{$message}}</p> @enderror
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Brands</label>
                <select class="form-select" multiple name="brands[]">
                    @foreach($brands as $brand)
                        <option value="{{$brand->id}}">{{$brand->name}}</option>
                    @endforeach
                </select>
                @error('brands') <p class="invalid-feedback">{{$message}}</p> @enderror
            </div>
        </form>
    </div>
</div>
