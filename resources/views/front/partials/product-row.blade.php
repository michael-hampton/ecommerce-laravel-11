@php use App\Helper;use App\Services\Cart\Facade\Cart; @endphp

<div class="row row-cols-2 row-cols-md-4 g-4 pb-3 mb-3">
    @foreach($products as $product)
        <div class="col">
            <div class="card animate-underline hover-effect-opacity bg-body rounded" style="min-height: 450px;">
                <div class="position-relative">
                    <a class="d-block rounded-top overflow-hidden" href="shop-product-general-electronics.html">
                        {{-- <span
                            class="badge bg-danger position-absolute top-0 start-0 mt-2 ms-2 mt-lg-3 ms-lg-3">-21%</span>
                        --}}
                        <div class="ratio" style="--cz-aspect-ratio: calc(240 / 258 * 100%)">
                            <img class="product-image"
                                src="{{asset('images/products/thumbnails')}}/{{$product->image}}" alt="VR Glasses">
                        </div>
                    </a>
                </div>

                <div class="card-body">
                    @if($product->reviews->count() > 0)
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <div class="d-flex gap-1 fs-xs">
                                @for ($x = 0; $x < $product->reviews->avg('rating'); $x++)
                                    <i class="fa fa-star text-warning"></i>
                                @endfor
                            </div>
                            <span class="text-body-tertiary fs-xs">({{$product->reviews->count()}})</span>
                        </div>
                    @endif

                    <h3 class="pb-1 mb-2">
                        <a class="d-block fs-sm fw-medium text-truncate"
                            href="{{route('shop.product.details', ['slug' => $product->slug])}}">
                            <span class="animate-target">{{$product->name}}</span>
                        </a>
                    </h3>

                    <p class="fs-sm pc__category">Seller: <a
                            href="{{route('seller.details', ['id' => $product->seller_id])}}">{{$product->seller->name}}</a>
                    </p>

                    <div class="d-flex justify-content-between align-items-center">
                        <div class="mb-0">
                            <span class="h5 mb-0">
                                @if($product->sale_price)
                                    <s>{{$currency}}{{$product->regular_price}}</s>
                                    {{$currency}}{{$product->sale_price}}
                                @else
                                    {{$currency}}{{$product->regular_price}}
                                @endif
                            </span>

                            @if(config('shop.show_commission'))
                                <br
                                    class="small commission-text">{{ Helper::calculateCommission(!empty($product->sale_price) ? $product->sale_price : $product->regular_price, true)}}
                                inc
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between bg-light">
                    @if(Cart::instance('cart')->content()->where('id', $product->id)->count() === 0 && $product->quantity > 0)
                        <form name="addtocart-form" method="post" action="{{route('cart.add')}}">
                            @csrf
                            <input type="hidden" name="id" value="{{$product->id}}">
                            <input type="hidden" name="name" value="{{$product->name}}">
                            <input type="hidden" name="quantity" value="1">
                            <input type="hidden" name="price"
                                value="{{!empty($product->sale_price) ? $product->sale_price : $product->regular_price}}">

                            <button class="btn btn-primary btn-sm add-to-cart">Add to Cart</button>
                        </form>
                    @endif

                    @if(Cart::instance('wishlist')->content()->where('id', $product->id)->count() === 0)
                        <form method="post" action="{{route('wishlist.add')}}">
                            @csrf
                            <input type="hidden" name="id" value="{{$product->id}}">
                            <input type="hidden" name="name" value="{{$product->name}}">
                            <input type="hidden" name="price"
                                value="{{!empty($product->sale_price) ? $product->sale_price : $product->regular_price}}">
                            <input type="hidden" name="quantity" value="1">

                            <button class="btn btn-outline-secondary btn-sm js-add-wishlist">
                                <i class="fa fa-heart"></i>
                                @if(Session::has('wishlist_products') && array_key_exists($product->id, Session::get('wishlist_products')))
                                    <span class="wishlist-amount">{{Session::get('wishlist_products')[$product->id]}}</span>
                                @endif
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>
{{-- </div> --}}