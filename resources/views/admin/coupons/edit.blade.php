@extends('layouts.admin')
@section('content')
    <div class="p-4">
        <div class="py-4">
            <h3>Create Coupon</h3>
        </div>

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
                <form action="{{route('admin.coupons.update', ['id' => $coupon->id])}}" method="POST">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Coupon Code</label>
                        <input type="text" class="form-control" id="name" name="code" placeholder="Code"
                               value="{{$coupon->code}}">
                        @error('code') <p class="invalid-feedback">{{$message}}</p> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Coupon Type</label>
                        <select class="form-select" name="type">
                            <option value="">Select</option>
                            <option value="fixed" @if($coupon->type === 'fixed') selected="selected" @endif>Fixed
                            </option>
                            <option value="percent" @if($coupon->type === 'percent') selected="selected" @endif>
                                Percent
                            </option>
                        </select>
                        @error('type') <p class="invalid-feedback">{{$message}}</p> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Coupon Value</label>
                        <input type="text" class="form-control" id="name" name="value" placeholder="Value"
                               value="{{$coupon->value}}">
                        @error('value') <p class="invalid-feedback">{{$message}}</p> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Cart Value</label>
                        <input type="text" class="form-control" id="cart_value" name="cart_value"
                               placeholder="Cart Value"
                               value="{{$coupon->cart_value}}">
                        @error('cart_value') <p class="invalid-feedback">{{$message}}</p> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">No of times coupon can be used</label>
                        <input type="text" class="form-control" id="usages" name="usages" placeholder="Usages"
                               value="{{$coupon->usages}}">
                        @error('usages') <p class="invalid-feedback">{{$message}}</p> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Expiry Date</label>
                        <input type="date" class="form-control" id="expires_at" name="expires_at"
                               value="{{$coupon->expires_at}}">
                        @error('expires_at') <p class="invalid-feedback">{{$message}}</p> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Categories</label>
                        <select class="form-select" multiple name="categories[]">
                            @foreach($categories as $category)
                                <option value="{{$category->id}}"
                                        @if(in_array($category->id, explode(',', $coupon->categories))) selected="selected" @endif>{{$category->name}}</option>
                            @endforeach
                        </select>
                        @error('categories') <p class="invalid-feedback">{{$message}}</p> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Brands</label>
                        <select class="form-select" multiple name="brands[]">
                            @foreach($brands as $brand)
                                <option value="{{$brand->id}}"
                                        @if(in_array($brand->id, explode(',', $coupon->brands))) selected="selected" @endif>{{$brand->name}}</option>
                            @endforeach
                        </select>
                        @error('brands') <p class="invalid-feedback">{{$message}}</p> @enderror
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
