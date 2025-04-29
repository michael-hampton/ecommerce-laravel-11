@extends('layouts.app')
@section('content')
    <div class="container mt-4">
        <div class="row">
            @include('front.user.account-nav', ['current' => 'orders'])

            <div class="col-lg-9 my-lg-0 my-1">
                <div class="wg-box mt-5 mb-5">
                    <div class="row">
                        <div class="col-6">
                            <h5>Ordered Details</h5>
                        </div>
                        <div class="col-6 text-right">
                            <a class="btn btn-sm btn-danger" href="{{route('orders.ordersCustomer')}}">Back</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-transaction">
                            <tbody>
                            <tr>
                                <th>Order No</th>
                                <td>{{$order->id}}</td>
                                <th>Mobile</th>
                                <td>{{$order->address->phone}}</td>
                                <th>Pin/Zip Code</th>
                                <td>{{$order->address->zip}}</td>
                            </tr>
                            <tr>
                                <th>Order Date</th>
                                <td>{{$order->created_at}}</td>
                                <th>Delivered Date</th>
                                <td>{{$order->delivered_date}}</td>
                                <th>Canceled Date</th>
                                <td>{{$order->cancelled_date}}</td>
                            </tr>
                            <tr>
                                <th>Order Status</th>
                                <td colspan="5">
                                    <span class="badge bg-danger">Canceled</span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="wg-box wg-table table-all-user">
                    <div class="row">
                        <div class="col-6">
                            <h5>Ordered Items</h5>
                        </div>
                        <div class="col-6 text-right">

                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">SKU</th>
                                <th class="text-center">Category</th>
                                <th class="text-center">Brand</th>
                                <th class="text-center">Options</th>
                                <th class="text-center">Return Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order->orderItems as $item)
                                <tr>

                                    <td class="pname">
                                        <div class="image">
                                            <img
                                                src="{{asset('storage/images/products')}}/{{$item->product->image}}"
                                                alt="{{$item->product->name}}"
                                                class="image">
                                        </div>
                                        <div class="name">
                                            <a href="{{route('shop.product.details', ['slug' => $item->product->slug])}}"
                                               target="_blank" class="body-title-2">Product1</a>
                                        </div>
                                    </td>
                                    <td class="text-center">{{$item->price}}</td>
                                    <td class="text-center">{{$item->quantity}}</td>
                                    <td class="text-center">{{$item->SKU}}</td>
                                    <td class="text-center">{{$item->product->category->name}}</td>
                                    <td class="text-center">{{$item->product->brand->name}}</td>
                                    <td class="text-center"></td>
                                    <td class="text-center">{{$item->status == 0 ? 'No' : 'Yes'}}</td>
                                    <td class="text-center">
                                        @if(empty($item->approved_date))
                                        <a href="{{route('orders.reportOrder', ['orderItemId' => $item->id])}}"
                                           class="btn btn-warning btn-lg">Report an issue</a>
                                           <a href="{{route('orders.approveOrderItem', ['orderItemId' => $item->id])}}"
                                            class="btn btn-success btn-sm">I'm happy with the item</a>
                                            @else
                                            <span class="badge bg-success">Approved</span
                                            @endif
                                        @if($order->status === 'delivered')
                                            <a href="{{route('createReview', ['orderItemId' => $item->id])}}">
                                                Review Product
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">

                </div>

                <div class="wg-box mt-5">
                    <h5>Shipping Address</h5>
                    <div class="my-account__address-item col-md-6">
                        <div class="my-account__address-item__detail">
                            <p>{{$order->customer->name}}</p>
                            <p>{{$order->address->address1}} {{$order->address->address2}}</p>
                            <p>{{$order->address->city}}, {{$order->address->state}}</p>
                            <p>{{$order->address->country}} </p>
                            <p>{{$order->address->zip}}</p>
                            <br>
                            <p>Mobile : {{$order->address->phone}}</p>
                        </div>
                    </div>
                </div>

                <div class="wg-box mt-5">
                    <h5>Transactions</h5>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-transaction">
                            <tbody>
                            <tr>
                                <th>Subtotal</th>
                                <td>{{$order->subtotal()}}</td>
                                <th>Tax</th>
                                <td>{{$order->tax}}</td>
                                <th>Discount</th>
                                <td>{{$order->discount}}</td>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <td>{{$order->total}}</td>
                                <th>Payment Mode</th>
                                <td>{{$order->transaction->count() > 0 ? $order->transaction->first()->payment_method : 'Seller Balance'}}</td>
                                <th>Status</th>
                                <td>
                                    <span class="badge bg-success">{{$order->status}}</span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($order->status !== 'complete')
                    <div class="wg-box mt-5 d-flex align-items-center justify-content-between">
                        <form action="{{route('orders.cancelOrder', ['orderId' => $order->id])}}" method="POST">
                            @csrf
                            @method('put')
                            <button type="submit" class="btn btn-danger cancel-order">Cancel Order</button>
                        </form>

                        <a href="{{route('orders.approveOrder', ['orderId' => $order->id])}}"
                           class="btn btn-success btn-lg">I'm happy with the order</a>
                    </div>
                @endif
            </div>
        </div>
        @endsection


        @push('scripts')
            <script>
                $(function () {
                    $(".cancel-order").on('click', function (e) {
                        e.preventDefault();
                        var selectedForm = $(this).closest('form');
                        swal({
                            title: "Are you sure?",
                            text: "You want to delete this record?",
                            type: "warning",
                            buttons: ["No!", "Yes!"],
                            confirmButtonColor: '#dc3545'
                        }).then(function (result) {
                            if (result) {
                                selectedForm.submit();
                            }
                        });
                    });
                });
            </script>
    @endpush
