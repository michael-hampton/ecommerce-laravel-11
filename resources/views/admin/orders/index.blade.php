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
                    <table id="admin-table" class="table table-striped table-bordered">
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
                            <th class="text-center">Cancelled On</th>
                            <th></th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="divider"></div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {

            $('#admin-table').DataTable({
                processing: true,
                serverSide: true,
                bFilter: false,
                ajax: {
                    url: "{{ route('admin.orders') }}",
                    data: function (d) {
                        d.search = $('input[type="search"]').val()
                    }
                },
                pageLength: 10,
                columns: [
                    {data: 'id', name: 'id'},
                    {
                        data: 'customer', name: 'customer', className: 'd-flex', render: function (data, type, row) {
                            return '<div class="d-flex align-items-center justify-content-between me-3"> ' +
                                '<img src="{{asset('images/users')}}/' + row.customer.image + '" alt="' + row.customer.name + '" class="image"></div> ' +
                                '<div class="><a href="#" class="fw-bold">' + row.customer.name + '</a></div>';
                        }
                    },
                    {data: 'customer', name: 'customer', render: function (data, type, row) {
                        return row.customer.mobile
                    }},
                    {data: 'subtotal', name: 'subtotal'},
                    {data: 'shipping', name: 'shipping'},
                    {data: 'commission', name: 'commission'},
                    {data: 'tax', name: 'tax'},
                    {data: 'total', name: 'total'},
                    {data: 'status', name: 'status'},
                    {data: 'order_date', name: 'order_date'},
                    {data: 'number_of_items', name: 'number_of_items'},
                    {data: 'delivered_date', name: 'delivered_date'},
                    {data: 'cancelled_date', name: 'cancelled_date'},
                    {
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            var route = "{{route('admin.orderDetails', ['orderId' => 'test'])}}"
                            return '<a href="'+route.replace('test', row.id)+'">'+
                                '<div class="d-flex align-items-center justify-content-between">' +
                                '<div class="item eye">' +
                                '<i class="icon-eye"></i>' +
                                '</div>' +
                                '</div>' +
                                '</a>';
                        }
                    }
                ]
            });
        });
    </script>
@endpush
