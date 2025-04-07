@php use App\Services\Cart\Facade\Cart;use Illuminate\Support\Facades\Session;use Illuminate\Support\Str; @endphp
@extends('layouts.app')
@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="shop-checkout container">
            <h2 class="page-title">Shipping and Checkout</h2>
            <div class="checkout-steps">
                <a href="{{route('cart.index')}}" class="checkout-steps__item active">
                    <span class="checkout-steps__item-number">01</span>
                    <span class="checkout-steps__item-title">
            <span>Shopping Bag</span>
            <em>Manage Your Items List</em>
          </span>
                </a>
                <a href="javascript:void(0)" class="checkout-steps__item active">
                    <span class="checkout-steps__item-number">02</span>
                    <span class="checkout-steps__item-title">
            <span>Shipping and Checkout</span>
            <em>Checkout Your Items List</em>
          </span>
                </a>
                <a href="javascript:void(0)" class="checkout-steps__item">
                    <span class="checkout-steps__item-number">03</span>
                    <span class="checkout-steps__item-title">
            <span>Confirmation</span>
            <em>Review And Submit Your Order</em>
          </span>
                </a>
            </div>
            <form method="post" name="checkout-form" id="checkout-form" action="{{route('checkout.placeCardOrder')}}">
                @csrf
                <input type="hidden" name="token" id="token">
                <input type="hidden" id="addressId" name="addressId" value="{{$addressId}}">
                <input type="hidden" name="mode" value="card">
                <div class="checkout-form">
                    <div class="billing-info__wrapper">
                        <div class="row">
                            <div class="col-6">
                                <h4>SHIPPING DETAILS</h4>
                            </div>
                            <div class="col-6">
                            </div>
                        </div>

                        @if($address)
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="my-account__address-list">
                                        <div class="my-account__address-item">
                                            <div class="my-account__address-item__detail">
                                                <p>{{$address->name}}</p>
                                                <p>{{$address->address1}}</p>
                                                <p>{{$address->address2}}</p>
                                                <p>{{$address->city}}, {{$address->state}}</p>
                                                <p>{{$address->zip}}</p>
                                                <br>
                                                {{$address->phone}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="row mt-5">
                                <div class="col-md-6">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="name" required=""
                                               value="{{old('name')}}">
                                        <label for="name">Full Name *</label>
                                        @error('name')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="phone" required=""
                                               value="{{old('phone')}}">
                                        <label for="phone">Phone Number *</label>
                                        @error('phone')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="city" required=""
                                               value="{{old('city')}}">
                                        <label for="city">Town / City *</label>
                                        @error('city')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating mt-3 mb-3">
                                        <input type="text" class="form-control" name="state" required=""
                                               value="{{old('state')}}">
                                        <label for="state">State *</label>
                                        @error('state')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating mt-3 mb-3">
                                        <select class="form-control" name="country" required="">
                                            <option value=""></option>
                                            @foreach($countries as $country)
                                                <option
                                                    value="{{Str::lower($country['name'])}}">{{$country['name']}}</option>
                                            @endforeach
                                        </select>
                                        <label for="state">Country *</label>
                                        @error('state')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="address1" required=""
                                               value="{{old('address1')}}">
                                        <label for="address">Address 1</label>
                                        @error('address1')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="address2"
                                               value="{{old('address2')}}">
                                        <label for="locality">Address 2</label>
                                        @error('address2')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="zip" required=""
                                               value="{{old('zip')}}">
                                        <label for="zip">Postcode *</label>
                                        @error('zip')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                {{--                                <div class="col-md-12">--}}
                                {{--                                    <div class="form-floating my-3">--}}
                                {{--                                        <input type="text" class="form-control" name="landmark" required="">--}}
                                {{--                                        <label for="landmark">Landmark *</label>--}}
                                {{--                                        <span class="text-danger"></span>--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}
                            </div>
                        @endif

                        <label for="card-element">
                            Credit or debit card
                        </label>
                        <div id="card-element">
                            <!-- A Stripe Element will be inserted here. -->
                        </div>
                    </div>
                    <div class="checkout__totals-wrapper">
                        <div class="sticky-content">
                            <div class="checkout__totals">
                                <h3>Your Order</h3>
                                <table class="checkout-cart-items">
                                    <thead>
                                    <tr>
                                        <th>PRODUCT</th>
                                        <th align="right">SUBTOTAL</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach(Cart::instance('cart') as $item)
                                        <tr>
                                            <td>
                                                {{$item->name}} x {{$item->qty}}
                                            </td>
                                            <td align="right">
                                                {{$item->subtotal()}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                @if(Session::has('discounts'))
                                    <table class="checkout-totals">
                                        <tbody>
                                        <tr>
                                            <th>Subtotal</th>
                                            <td class="text-end">{{$currency}}{{Cart::instance('cart')->subtotal()}}</td>
                                        </tr>
                                        <tr>
                                            <th>Discount {{Session::get('coupon')['code']}}</th>
                                            <td class="text-end">{{$currency}}{{Session::get('discounts')['discount']}}</td>
                                        </tr>
                                        <tr>
                                            <th>Subtotal after discount</th>
                                            <td class="text-end">{{$currency}}{{Session::get('discounts')['subtotal']}}</td>
                                        </tr>
                                        <tr>
                                            <th>Shipping</th>
                                            <td class="text-end">{{$currency}}{{Session::get('discounts')['shipping']}}</td>
                                        </tr>
                                        <tr>
                                            <th>VAT</th>
                                            <td class="text-end">{{$currency}}{{Session::get('discounts')['tax']}}</td>
                                        </tr>
                                        <tr>
                                            <th>Total</th>
                                            <td class="text-end">{{$currency}}{{Session::get('discounts')['total']}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                @else
                                    <table class="checkout-totals">
                                        <tbody>
                                        <tr>
                                            <th>SUBTOTAL</th>
                                            <td class="text-end">{{Cart::instance('cart')->subtotal()}}</td>
                                        </tr>
                                        <tr>
                                            <th>SHIPPING</th>
                                            <td class="text-end">{{Cart::instance('cart')->shipping()}}</td>
                                        </tr>
                                        <tr>
                                            <th>VAT</th>
                                            <td class="text-end">{{Cart::instance('cart')->tax()}}</td>
                                        </tr>
                                        <tr>
                                            <th>TOTAL</th>
                                            <td class="text-end">{{Cart::instance('cart')->total()}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary btn-checkout" id="btn-checkout">PLACE ORDER</button>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </main>
@endsection

<script src="https://js.stripe.com/v3/"></script>

@push('scripts')
    <script>
        // $(function () {
        //    $('.form-check-input').on('click', function () {
        //       if($(this).val() === 'card') {
        //           alert('yes')
        //         $('.card-container').removeClass('d-none')
        //
        //       } else {
        //           $('.card-container').addClass('d-none')
        //       }
        //    });
        // });

        const stripe = Stripe('{{env('STRIPE_KEY')}}');
        const elements = stripe.elements();

        // Custom styling can be passed to options when creating an Element.
        const style = {
            base: {
                // Add your base input styles here. For example:
                fontSize: '16px',
                color: '#32325d',
            },
        };

        // Create an instance of the card Element.
        const card = elements.create('card', {hidePostalCode: true, style});

        // Add an instance of the card Element into the `card-element` <div>.
        card.mount('#card-element');

        const form = document.getElementById('btn-checkout');
        form.addEventListener('click', async (event) => {
            event.preventDefault();

            const {token, error} = await stripe.createToken(card);

            if (error) {
                alert(error)
                // Inform the customer that there was an error.
                const errorElement = document.getElementById('card-errors');
                errorElement.textContent = error.message;
            } else {
                alert(token.id)
                document.getElementById('token').value = token.id;
                // Send the token to your server.
                document.getElementById('checkout-form').submit();
            }
        });
    </script>
@endpush
