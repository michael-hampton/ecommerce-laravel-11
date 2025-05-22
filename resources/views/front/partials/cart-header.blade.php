<!-- Header -->
<div class="offcanvas-header flex-column align-items-start py-3 pt-lg-4">
    <div class="d-flex align-items-center justify-content-between w-100">
        <h4 class="offcanvas-title" id="shoppingCartLabel">Cart
            ({{\App\Services\Cart\Facade\Cart::instance('cart')->count()}})</h4>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
</div>

<!-- Items -->
<div class="offcanvas-body d-flex flex-column gap-4 pt-2 cart-header">
    @foreach($items as $item)
        <!-- Item -->
        <div class="d-flex align-items-center">
            <a class="flex-sm-shrink-0" href="{{route('shop.product.details', ['slug' => $products->get($item->id)->slug])}}"
                style="width: 142px">
                <div class="bg-body-tertiary rounded overflow-hidden" style="--cz-aspect-ratio: calc(110 / 142 * 100%)">
                    <img src="{{asset('images/products/thumbnails')}}/{{$products->get($item->id)->image}}" alt="Thumbnail">
                </div>
            </a>
            <div class="w-100 min-w-0 ps-3">
                <h5 class="d-flex animate-underline mb-2 de-flex justify-content-between">
                    <a class="d-block fs-sm fw-medium text-truncate animate-target"
                        href="shop-product-marketplace.html">{{$item->name}}</a>
                    <div class="h6 pb-1 mb-2">{{config('shop.currency')}}{{$item->price}}</div>
                </h5>

                <p>{{$products->get($item->id)->short_description}}</p>

                <div class="d-flex align-items-center justify-content-between gap-1">
                    <button type="button" class="btn btn-icon btn-sm flex-shrink-0 fs-sm" data-bs-toggle="tooltip"
                        data-bs-custom-class="tooltip-sm" data-bs-title="Remove" aria-label="Remove from cart">
                        <i class="fa fa-trash fs-base"></i>
                    </button>
                </div>
            </div>
        </div>
    @endforeach
</div>

<!-- Footer -->
<div class="offcanvas-header flex-column align-items-start">
    @if(!empty($total))
        <div class="d-flex align-items-center justify-content-between w-100 mb-3 mb-md-4">
            <span class="text-light-emphasis">Subtotal:</span>
            <span class="h6 mb-0">{{$total}}</span>
        </div>
    @endif
    <a class="btn btn-lg btn-primary w-100 rounded-pill" href="{{route('cart.index')}}">Go to cart</a>
    <a class="btn btn-lg btn-primary w-100 rounded-pill mt-2" href="{{route('checkout.index')}}">Go to checkout</a>
</div>