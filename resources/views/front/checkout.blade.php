@php use App\Services\Cart\Facade\Cart;use Illuminate\Support\Facades\Session;use Illuminate\Support\Str; @endphp
@extends('layouts.app')
@section('content')

<style>
    .cancel{text-decoration: none}.bg-pay{background-color: #eee;border-radius: 2px}.com-color{color: #8f37aa!important}.radio{cursor: pointer}label.radio input{position: absolute;top: 0;left: 0;visibility: hidden;pointer-events: none}label.radio div{padding: 7px 14px;border: 2px solid #8f37aa;display: inline-block;color: #8f37aa;border-radius: 3px;text-transform: uppercase;width: 100%;margin-bottom: 10px}label.radio input:checked+div{border-color: #8f37aa;background-color: #8f37aa;color: #fff}.fw-500{font-weight: 400}.lh-16{line-height: 16px}
    </style>

    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="shop-checkout container">
            <h2 class="page-title">Shipping and Checkout</h2>

            @include('front.partials.cart-steps')

            <form method="post" name="checkout-form" id="checkout-form" action="{{route('checkout.placeOrder')}}">
                @csrf
                <input type="hidden" name="token" id="token">
                <div class="checkout-form">
                    <div class="billing-info__wrapper">
                        <div class="row">
                            <div class="col-md-9 order-1">
                                <h4>SHIPPING DETAILS</h4>
                                @if($addresses->count() > 0)
                                    @foreach($addresses as $address)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="address"
                                                   id="address-{{$address->id}}" value="{{$address->id}}"
                                                   @if(old('address') === $address->id) checked="checked" @endif>
                                            <label class="form-check-label" for="address-{{$address->id}}">
                                        <span class="my-account__address-item__detail">
                                            <p>{{$address->name}}</p>
                                            <p>{{$address->address1}}</p>
                                            <p>{{$address->address2}}</p>
                                            <p>{{$address->city}}, {{$address->state}}</p>
                                            <p>{{$address->zip}}</p>
                                        </span>
                                            </label>
                                        </div>
                                    @endforeach
                                    @error('address')
                                    <div class="invalid-feedback d-block">
                                        {{$message}}
                                    </div>
                                    @enderror
                                @else
                                    <h4 class="mb-3">Billing Address</h4>
                                    <div class="col mb-4">
                                        <label for="First name"> Name </label>
                                        <input type="text" class="form-control" placeholder="First name" name="name"
                                               value="{{old('name')}}">
                                    </div>
                                    <div class="col mb-4">
                                        <label for="First name"> Phone </label>
                                        <input type="text" class="form-control" placeholder="Phone" name="phone">
                                    </div>
                                    <div class="mb-4">
                                        <label for="email">Email (optional)</label>
                                        <input type="text" class="form-control" placeholder="you@example.com"
                                               name="email">
                                    </div>
                                    <div class="mb-4">
                                        <label for="Address">Address</label>
                                        <input type="text" class="form-control" placeholder="1234 Main St"
                                               aria-label="Address" name="address1">
                                    </div>
                                    <div class="mb-4">
                                        <label for="Address2">Address 2 (optional)</label>
                                        <input type="text" class="form-control" placeholder="Appartment or suite"
                                               aria-label="Address2" name="address2">
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <label for="country">Country</label>
                                            <select class="form-select" name="country_id">
                                                <option value="">Select Country</option>
                                                @foreach($countries as $country)
                                                    <option
                                                        value="{{$country['id']}}">{{$country['name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label for="state">State</label>
                                            <input type="text" class="form-control" name="state">
                                        </div>
                                        <div class="col">
                                            <label for="state">City</label>
                                            <input type="text" class="form-control" name="city">
                                        </div>
                                        <div class="col mb-4">
                                            <label for="zip">Zip Code</label>
                                            <input type="text" class="form-control" name="zip">
                                        </div>

                                        <hr class="mb-4">

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=""
                                                   id="flexCheckDefault">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Shipping address is the same as my billing address
                                            </label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=""
                                                   id="flexCheckChecked">
                                            <label class="form-check-label" for="flexCheckChecked">
                                                Save this information for next time
                                            </label>
                                        </div>
                                    </div>
                                @endif

                                @if($cards->isEmpty())
                                <div id="card-container" class="d-none">
                                     <label for="card-element">
                                    Credit or debit card
                                </label>
                                <div id="card-element">
                                    <!-- A Stripe Element will be inserted here. -->
                                </div>
                                </div>
                                @else
                                    <div class="d-flex flex-column"> 
                                        @foreach($cards as $card)
                                            <label class="radio"> 
                                                <input type="radio" name="existing_card" value="{{ $card['id'] }}" checked>
                                                <div class="d-flex justify-content-between"> 
                                                    <span>{{$card['card_type']}}</span> 
                                                    <span>**** {{$card['formatted_card_number']}}</span> 
                                                </div>
                                            </label> 
                                        @endforeach
                                    </div>
                                @endif
                                
                            </div>
                            <div class="col-md-3 order-2">
                                <h4 class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-muted">Your Cart</span>
                                    <span
                                        class="badge rounded-pill bg-secondary">{{Cart::instance('cart')->count()}}</span>
                                </h4>

                                <div class="card" style="">
                                    @foreach(Cart::instance('cart')->content() as $item)
                                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                                            <div>
                                                <h6 class="my-0">{{$item->name}}</h6>
                                                <small class="text-muted">{{$item->model->short_description}}</small>
                                            </div>
                                            <span class="text-muted">{{$item->price}}</span>
                                        </li>
                                    @endforeach


                                    <div class="card-footer">
                                        @if(Session::has('discounts'))
                                            <ul class="list-unstyled">
                                                <li class="d-flex align-items-center justify-content-between">
                                                    <span>Subtotal</span>
                                                    <span
                                                        class="text-end">{{$currency}}{{Cart::instance('cart')->subtotal()}}</span>
                                                </li>
                                                @if(Session::has('coupon'))
                                                    <li class="d-flex align-items-center justify-content-between">
                                                        <span>Discount {{Session::get('coupon')['code']}}</span>
                                                        <span
                                                            class="text-end">{{$currency}}{{Session::get('discounts')['discount']}}</span>
                                                    </li>
                                                @endif
                                                <li class="d-flex align-items-center justify-content-between">
                                                    <span>Subtotal after discount</span>
                                                    <span
                                                        class="text-end">{{$currency}}{{Session::get('discounts')['subtotal']}}</span>
                                                </li>
                                                <li class="d-flex align-items-center justify-content-between">
                                                    <span>Shipping</span>
                                                    <span
                                                        class="text-end">{{$currency}}{{Session::get('discounts')['shipping']}}</span>
                                                </li>
                                                <li class="d-flex align-items-center justify-content-between">
                                                    <span>VAT</span>
                                                    <span
                                                        class="text-end">{{$currency}}{{Session::get('discounts')['tax']}}</span>
                                                </li>
                                                <li class="d-flex align-items-center justify-content-between">
                                                    <span>Total</span>
                                                    <span
                                                        class="text-end">{{$currency}}{{Session::get('discounts')['total']}}</span>
                                                </li>
                                            </ul>
                                        @else
                                            <ul class="list-unstyled">
                                                <li class="d-flex align-items-center justify-content-between">
                                                    <span>SUBTOTAL</span>
                                                    <span class="text-end">{{Cart::instance('cart')->subtotal()}}
                                                </li>
                                                <li class="d-flex align-items-center justify-content-between">
                                                    <span>SHIPPING</span>
                                                    <span class="text-end">{{Cart::instance('cart')->shipping()}}</span>
                                                </li>
                                                <li class="d-flex align-items-center justify-content-between">
                                                    <span>VAT</span>
                                                    <span class="text-end">{{Cart::instance('cart')->tax()}}</span>
                                                </li>
                                                <li class="d-flex align-items-center justify-content-between">
                                                    <span>TOTAL</span>
                                                    <span class="text-end">{{Cart::instance('cart')->total()}}</span>
                                                </li>
                                            </ul>
                                        @endif
                                    </div>

                                    <div class="ps-2">
                                        <div class="form-check">
                                            <input class="form-check-input form-check-input_fill" type="radio"
                                                   name="mode"
                                                   id="mode2" value="card"
                                                   @if(old('mode') === 'card')checked="checked" @endif>
                                            <label class="form-check-label" for="checkout_payment_method_2">
                                                Credit or debit card
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input form-check-input_fill" type="radio"
                                                   name="mode"
                                                   id="mode3" value="cash"
                                                   @if(old('mode') === 'cash')checked="checked" @endif>
                                            <label class="form-check-label" for="checkout_payment_method_3">
                                                Cash on delivery
                                            </label>
                                        </div>
                                        @if(in_array(auth()->user()->utype, ['SUPER', 'ADM']))
                                            <div class="form-check">
                                                <input class="form-check-input form-check-input_fill" type="radio"
                                                       name="mode"
                                                       id="mode3" value="seller_balance"
                                                       @if(old('mode') === 'seller_balance')checked="checked" @endif>
                                                <label class="form-check-label" for="checkout_payment_method_3">
                                                    Use Seller balance
                                                </label>
                                            </div>
                                        @endif
                                        <div class="form-check">
                                            <input class="form-check-input form-check-input_fill" type="radio"
                                                   name="mode"
                                                   id="mode4" value="paypal"
                                                   @if(old('mode') === 'paypal')checked="checked" @endif>
                                            <label class="form-check-label" for="checkout_payment_method_4">
                                                Paypal
                                            </label>
                                        </div>

                                        @error('mode')
                                        <div class="invalid-feedback d-block">
                                            Please select an option
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="p-3 text-center">
                                        <button type="button" id="btn-checkout"
                                                class="btn btn-primary btn-lg rounded-pill">Place Order
                                        </button>
                                    </div>
                                </div>
                            </div>
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
         let stripe = null;
         let card = null
        let mode = ''
        $(function () {
            const form = document.getElementById('btn-checkout');
        form.addEventListener('click', async (event) => {
            const cardElement = document.getElementById('card-element')
                event.preventDefault()
                if(mode === 'card' && cardElement) {
                     const {token, error} = await stripe.createToken(card);

            if (error) {
                alert(error)
                // Inform the customer that there was an error.
                const errorElement = document.getElementById('card-errors');
                errorElement.textContent = error.message;
            } else {
                document.getElementById('token').value = token.id;
                // Send the token to your server.
                console.log(document.getElementById('checkout-form'))
                document.getElementById('checkout-form').submit();
            }
                }
                document.getElementById('checkout-form').submit();
            });

            const modes = document.querySelectorAll('[name="mode"]')
            modes.forEach(el => {
               el.addEventListener('click', (event) => {
                const cardElement = document.getElementById('card-element')
                if(event.currentTarget.value === 'card' && cardElement) {
                   loadCard()
                }
               })
            })
        });

        function loadCard() {

            stripe = Stripe('{{env('STRIPE_KEY')}}');
           
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
        card = elements.create('card', {hidePostalCode: true, style});

        // Add an instance of the card Element into the `card-element` <div>.
        card.mount('#card-element');

        document.getElementById('card-container').classList.remove('d-none')

        mode = 'card'
        }
    </script>
@endpush
