<!-- Header -->
<div class="offcanvas-header flex-column align-items-start py-3 pt-lg-4">
    <div class="d-flex align-items-center justify-content-between w-100">
        <h4 class="offcanvas-title" id="shoppingCartLabel">Wishlist
            ({{\App\Services\Cart\Facade\Cart::instance('wishlist')->count()}})</h4>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
</div>

<!-- Items -->
<div class="offcanvas-body d-flex flex-column gap-4 pt-2">
    @foreach($items as $item)
        <!-- Item -->
        <div class="d-flex align-items-center">
            <a class="flex-sm-shrink-0" href="{{route('shop.product.details', ['slug' => $item->model->slug])}}"
                style="width: 142px">
                <div class="bg-body-tertiary rounded overflow-hidden" style="--cz-aspect-ratio: calc(110 / 142 * 100%)">
                    <img src="{{asset('images/products/thumbnails')}}/{{$item->model->image}}" alt="Thumbnail">
                </div>
            </a>
            <div class="w-100 min-w-0 ps-3">
                <h5 class="d-flex animate-underline mb-2">
                    <a class="d-block fs-sm fw-medium text-truncate animate-target"
                        href="shop-product-marketplace.html">{{$item->name}}</a>
                </h5>
                <div class="h6 pb-1 mb-2">{{$item->price}}</div>
                <div class="d-flex align-items-center justify-content-between gap-1">
                    <button type="button" class="btn btn-icon btn-sm flex-shrink-0 fs-sm" data-bs-toggle="tooltip"
                        data-bs-custom-class="tooltip-sm" data-bs-title="Remove" aria-label="Remove from cart">
                        <i class="ci-trash fs-base"></i>
                    </button>
                </div>
            </div>
        </div>
    @endforeach
</div>

<!-- Footer -->
<div class="offcanvas-header flex-column align-items-start">
    <div class="d-flex align-items-center justify-content-between w-100 mb-3 mb-md-4">
        <span class="text-light-emphasis">Subtotal:</span>
        <span class="h6 mb-0">{{\App\Services\Cart\Facade\Cart::instance('wishlist')->total()}}</span>
    </div>
    <a class="btn btn-lg btn-dark w-100 rounded-pill" href="{{route('wishlist.index')}}">Go to wishlist</a>
</div>