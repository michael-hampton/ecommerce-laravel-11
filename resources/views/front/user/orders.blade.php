@extends('layouts.app')
@section('content')
    <div class="container mt-4">
        <div class="row">
            @include('front.user.account-nav', ['current' => 'orders'])

            <div class="col-lg-9 my-lg-0 my-1">
                <div class="wg-table table-all-user">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th style="width: 80px">OrderNo</th>
                                <th>Name</th>
                                <th class="text-center">Phone</th>
                                <th class="text-center">Subtotal</th>
                                <th class="text-center">Tax</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Order Date</th>
                                <th class="text-center">Items</th>
                                <th class="text-center">Delivered On</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td class="text-center">{{$order->id}}</td>
                                    <td class="text-center">{{$order->customer->name}}</td>
                                    <td class="text-center">{{$order->address->phone}}</td>
                                    <td class="text-center">{{round($order->subtotal, 2)}}</td>
                                    <td class="text-center">{{round($order->tax, 2)}}</td>
                                    <td class="text-center">{{round($order->total, 2)}}</td>
                                    <td class="text-center">{{$order->created_at}}</td>
                                    <td class="text-center">{{$order->orderItems->count()}}</td>
                                    <td>{{$order->delivered_date}}</td>
                                    <td>{{$order->status}}</td>
                                    <td class="text-center">
                                        <a href="{{route('orders.orderDetailsCustomer', ['orderId' => $order->id])}}">
                                            <div class="d-flex view-icon">
                                                <div class="item eye">
                                                    <i class="fa fa-eye"></i>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                    {{$orders->links('pagination::bootstrap-5')}}
                </div>
            </div>
        </div>
@endsection
