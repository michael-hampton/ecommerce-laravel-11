@php use Illuminate\Support\Facades\Session; @endphp
@extends('layouts.admin')
@section('content')
    <div class="p-4">
        <div class="py-4">
            <h3>Orders</h3>
        </div>

        <div class="card p-3">
            <div class="card-body">
                <div class="table-responsive">
                    @if(Session::has('status'))
                        <p class="alert alert-success">{{Session::get('status')}}</p>
                    @endif
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th style="width:70px">OrderNo</th>
                            <th class="text-center">Cust Name</th>
                            <th class="text-center">Cust Phone</th>
                            <th class="text-center">Subtotal</th>
                            <th class="text-center">Shipping</th>
                            <th class="text-center">Commission</th>
                            <th class="text-center">Tax</th>
                            <th class="text-center">Total</th>

                            <th class="text-center">Status</th>
                            <th class="text-center">Order Date</th>
                            <th class="text-center">Total Items</th>
                            <th class="text-center">Delivered On</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td class="text-center">{{$order->id}}</td>
                                <td class="text-center">{{$order->address->name}}</td>
                                <td class="text-center">{{$order->address->phone}}</td>
                                <td class="text-center">{{$order->subtotal}}</td>
                                <td class="text-center">{{$order->shipping()}}</td>
                                <td class="text-center">{{$order->commission}}</td>
                                <td class="text-center">{{$order->tax}}</td>
                                <td class="text-center">{{$order->subtotal()}}</td>

                                <td class="text-center">{{$order->status}}</td>
                                <td class="text-center">{{$order->created_at}}</td>
                                <td class="text-center">{{$order->totalCount()}}</td>
                                <td class="text-center">{{$order->delivery_date}}</td>
                                <td></td>
                                <td class="text-center">
                                    <a href="{{route('admin.orderDetails', ['orderId' => $order->id])}}">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="item eye">
                                                <i class="icon-eye"></i>
                                            </div>
                                        </div>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            No records
                        @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="divider"></div>
            <div class="d-flex align-items-center justify-content-between flex-wrap">
                {{$orders->links('pagination::bootstrap-5')}}
            </div>
        </div>
    </div>
@endsection
