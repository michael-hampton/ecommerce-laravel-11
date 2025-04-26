@php use App\Helper;use App\Services\Cart\Facade\Cart; @endphp
<style>
    .commission-text {
        font-size: 10px !important;
    }
</style>
<div class="products-grid row row-cols-2 row-cols-md-3" id="products-grid">
    @forelse($products as $product)
        <div class="col-md-4 mb-3 mb-md-4 mb-xxl-5">
            <div class="card">
                <a class="card-img-container" href="{{route('shop.product.details', ['slug' => $product->slug])}}">
                    <img style="max-height: 150px"
                         src="{{asset('images/products/thumbnails')}}/{{$product->image}}"
                         class="card-img-top" alt="{{$product->name}}">
                </a>

                <div class="card-body">
                    <h5 class="card-title">
                        <a href="{{route('shop.product.details', ['slug' => $product->slug])}}">{{$product->name}}</a>
                    </h5>
                    <div class="mb-4">
                        <p class="card-text">{{$product->short_description}}</p>
                        <p class="pc__category">Category: <a href="{{route('shop.index', ['categoryId' => $product->category_id])}}">{{$product->category->name}}</a></p>
                        <p class="pc__category">Brand: <a href="{{route('shop.index', ['brandId' => $product->brand_id])}}">{{$product->brand->name}}</a> </p>
                        <p class="pc__category">Seller: <a
                                href="{{route('seller.details', ['id' => $product->seller_id])}}">{{$product->seller->name}}</a>
                        </p>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <div class="mb-0">
                            <span class="h5 mb-0">
                             @if($product->sale_price)
                                    <s>{{$currency}}{{$product->regular_price}}</s> {{$currency}}{{$product->sale_price}}
                                @else
                                    {{$currency}}{{$product->regular_price}}
                                @endif
                        </span>

                            @if(config('shop.show_commission'))
                                <br class="small commission-text">{{ Helper::calculateCommission(!empty($product->sale_price) ? $product->sale_price : $product->regular_price, true)}}
                                inc
                            @endif
                        </div>

                        @if($product->reviews->count() > 0)
                            <div>
                                @for ($x = 0; $x < $product->reviews()->avg('rating'); $x++)
                                    <i class="fa fa-star-fill text-warning"></i>
                                @endfor
                                <small class="text-muted">({{$product->reviews->count()}})</small>
                            </div>
                        @endif
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
                                    <span
                                        class="wishlist-amount">{{Session::get('wishlist_products')[$product->id]}}</span>
                                @endif
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    @empty
        No Products
    @endforelse
</div>

<div class="divider"></div>
<div class="d-flex align-items-center justify-content-between flex-wrap gap10">
    {{$products->withQueryString()->links('pagination::bootstrap-5')}}
</div>
