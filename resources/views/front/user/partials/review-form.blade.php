<form name="customer-review-form" action="{{route('storeReview', ['productId' => $product->id])}}" method="post">
    @csrf
    @if(Session::has('message'))
        <div class="alert alert-success">{{Session::get('message')}}</div>
    @endif
    <h5>Be the first to review “{{$product->name}}”</h5>
    <p>Your email address will not be published. Required fields are marked *</p>
    <div class="select-star-rating">
        <label>Your rating *</label>
        <span class="star-rating">
            @for ($x = 0; $x < 5; $x++)
                <i class="fa fa-star"></i>
            @endfor
        </span>
        <input type="hidden" name="rating" id="form-input-rating" value="" />
        @error('rating') <span class="text-danger">{{$message}}</span>@enderror
    </div>
    <div class="mb-4">
        <textarea id="form-input-review" name="review" class="form-control form-control_gray" placeholder="Your Review"
            cols="30" rows="8"></textarea>
        @error('review') <span class="text-danger">{{$message}}</span>@enderror
    </div>
    <input type="hidden" name="orderItemId" value="{{$orderItem->id}}">
    <input type="hidden" name="productId" value="{{$product->id}}">
    <input type="hidden" name="customerId" value="{{$orderItem->order->customer_id}}">
    {{-- <div class="form-label-fixed mb-4">--}}
        {{-- <label for="form-input-name" class="form-label">Name *</label>--}}
        {{-- <input id="form-input-name" class="form-control form-control-md form-control_gray">--}}
        {{-- </div>--}}
    {{-- <div class="form-label-fixed mb-4">--}}
        {{-- <label for="form-input-email" class="form-label">Email address *</label>--}}
        {{-- <input id="form-input-email" class="form-control form-control-md form-control_gray">--}}
        {{-- </div>--}}
    <div class="form-check mb-4">
        <input class="form-check-input form-check-input_fill" type="checkbox" value="" id="remember_checkbox">
        <label class="form-check-label" for="remember_checkbox">
            Save my name, email, and website in this browser for the next time I comment.
        </label>
    </div>
    <div class="form-action">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>