@php use Illuminate\Support\Facades\Session; @endphp
@extends('layouts.admin')
@section('content')
    <div class="p-4">

        <div class="d-flex align-items-center justify-content-between mb-3">
            <div class="card col-lg-6 me-3">
                <div class="card-header">Order Totals</div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li><span class="fw-bold">Shipping</span> {{$transaction->shipping}} </li>
                        <li><span class="fw-bold">Discount</span> {{$transaction->discount}} </li>
                        <li><span class="fw-bold">Total</span> {{$transaction->total}} </li>
                        <li><span class="fw-bold">Status</span> {{$transaction->payment_status}} </li>
                        <li><span class="fw-bold">Payment Method</span> {{$transaction->payment_method}} </li>
                    </ul>
                </div>
            </div>

            <div class="card col-lg-6 me-3">
                <div class="card-header">Customer Details</div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li><span class="fw-bold">Name</span> {{$order->customer->name}} </li>
                        <li><span class="fw-bold">Email</span> {{$order->customer->email}} </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-between">
            <div class="card col-lg-6 me-3">
                <div class="card-header">Shipping Address</div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li>{{$order->address->name}}</li>
                        <li>{{$order->address->address1}} {{$order->address->address2}}</li>
                        <li>{{$order->address->city}}, {{$order->address->state}}</li>
                        <li>{{$order->address->zip}}</li>
                        <li>{{$order->country}}</li>
                        <li>Phone : {{$order->address->phone}}</li>
                    </ul>
                </div>
            </div>
            <div class="card col-lg-6">
                <div class="card-header">History</div>
                <div class="card-body">
                    <form action="{{route('admin.orders.update', ['id' => $order->id])}}" method="post">
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="col-md-3">
                                <label for="inputCity" class="form-label">Status</label>
                                <select id="status" name="status" class="form-control">
                                    <option value="ordered"
                                            @if($order->status === 'ordered') selected="selected" @endif>
                                        Ordered
                                    </option>
                                    <option value="delivered"
                                            @if($order->status === 'delivered') selected="selected" @endif>
                                        Delivered
                                    </option>
                                    <option value="cancelled"
                                            @if($order->status === 'cancelled') selected="selected" @endif>
                                        Cancelled
                                    </option>
                                </select>
                            </div>

                            <div class="col-sm-3" id="tracking-number-container">
                                <label for="inputCity" class="form-label">Tracking No</label>
                                <input type="text" class="form-control" id="tracking_number" name="tracking_number"
                                       value="{{$order->tracking_number}}">
                            </div>

                            <div class="col-sm-4" id="courier-name-container">
                                <label for="inputCity" class="form-label">Courier</label>
                                <input type="text" class="form-control" id="courier_name" name="courier_name"
                                       value="{{$order->courier_name}}">
                            </div>

                            <div class="col-md-2">
                                <button type="submit" class="btn btn-success">Update</button>
                            </div>
                        </div>

                    </form>

                    <ul class="list-unstyled">
                        @foreach($order->logs as $orderLog)
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Order {{$orderLog->status_to}}
                                   <span>{{$orderLog->created_at}}</span>
                                </li>
                            </ul>
                        @endforeach

                            @foreach($order->orderItems as $orderItem)
                                @foreach($orderItem->logs as $orderLog)
                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Order Item {{$orderLog->status_to}}
                                        <span>{{$orderLog->created_at}}</span>
                                    </li>
                                </ul>
                            @endforeach
                            @endforeach
                    </ul>
                </div>
            </div>
        </div>


        <div class="wg-box">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow">
                    <h5>Ordered Items</h5>
                </div>
                <a class="tf-button style-1 w208" href="orders.html">Back</a>
            </div>

            @if(Session::has('status'))
                <p class="alert alert-success">{{Session::get('status')}}</p>
            @endif

            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 35%">Name</th>
                        <th style="width: 10%" class="text-center">Price</th>
                        <th style="width: 10%" class="text-center">Quantity</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($items as $item)
                        <tr>

                            <td class="">
                                <div class="d-flex align-items-center justify-content-between">
                                    <img src="{{asset('images/products')}}/{{$item->product->image}}" alt=""
                                         class="image">
                                    <div>
                                        <div class="fw-bold">
                                            <a href="#" target="_blank"
                                               class="body-title-2">{{$item->product->name}}</a>
                                        </div>
                                        <ul class="list-unstyled">
                                            <li>Category: {{$item->product->category->name}}</li>
                                            <li>Brand: {{$item->product->brand->name}}</li>
                                            <li>SKU: {{$item->product->SKU}}</li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">{{$item->price}}</td>
                            <td class="text-center">{{$item->quantity}}</td>
                            <td>
                                <form action="{{route('admin.orders.updateItemDetails', ['orderItemId' => $item->id])}}"
                                      method="post">
                                    @csrf
                                    @method('put')
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="inputCity" class="form-label">Status</label>
                                            <select style="border: 1px solid #000;" id="status" name="status"
                                                    class="form-control">
                                                <option value="ordered"
                                                        @if($item->status === 'ordered') selected="selected" @endif>
                                                    Ordered
                                                </option>
                                                <option value="delivered"
                                                        @if($item->status === 'delivered') selected="selected" @endif>
                                                    Delivered
                                                </option>
                                                <option value="cancelled"
                                                        @if($item->status === 'cancelled') selected="selected" @endif>
                                                    Cancelled
                                                </option>
                                            </select>
                                        </div>

                                        <div class="col-sm-4" id="tracking-number-container">
                                            <label for="inputCity" class="form-label">Tracking No</label>
                                            <input style="border: 1px solid #000;" type="text" class="form-control"
                                                   id="tracking_number" name="tracking_number"
                                                   value="{{$order->tracking_number}}">
                                        </div>

                                        <div class="col-sm-4" id="courier-name-container">
                                            <label for="inputCity" class="form-label">Courier</label>
                                            <input style="border: 1px solid #000;" type="text" class="form-control"
                                                   id="courier_name" name="courier_name"
                                                   value="{{$order->courier_name}}">
                                        </div>

                                        <div class="col-md-2 mt-3">
                                            <button type="submit" class="btn btn-success">Update</button>
                                        </div>
                                    </div>

                                </form>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>

            <div class="divider"></div>
            <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
            @if($order->status !== 'delivered')
            $('#tracking-number-container').hide();
            $('#courier-name-container').hide();
            @endif
            $('#status').on('change', function () {
                if ($(this).val() === 'delivered') {
                    $('#tracking-number-container').show();
                    $('#courier-name-container').show();
                }
            })

        });
    </script>
@endpush
