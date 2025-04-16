@php use Illuminate\Support\Facades\Session; @endphp
@extends('layouts.admin')
@section('content')
    <div class="p-4">
        <div class="py-4">
            <h3>Products</h3>
        </div>
        <div class="card py-2 mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="input-group">
                            <input class="form-control border-end-0 border" type="search" placeholder="Search"
                                   id="example-search-input">
                            <span class="input-group-append">
                    <button class="btn btn-outline-secondary bg-white border-start-0 border-bottom-0 border ms-n5"
                            type="button">
                        <i class="fa fa-search"></i>
                    </button>
                </span>
                        </div>
                    </div>
                    <a href="{{route('admin.products.create')}}" class="btn btn-primary add">Add New Product</a>
                </div>
            </div>
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
                            <th>#</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>SalePrice</th>
                            <th>SKU</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Featured</th>
                            <th>Stock</th>
                            <th>Quantity</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                    </table>
                </div>

                <div class="divider"></div>
            </div>
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
                    url: "{{ route('admin.products') }}",
                    data: function (d) {
                            d.search = $('input[type="search"]').val()
                    }
                },
                pageLength: 10,
                columns: [
                    {data: 'id', name: 'id'},
                    {
                        data: 'name', name: 'name', className: 'd-flex', render: function (data, type, row) {
                            return '<div class="d-flex align-items-center justify-content-between me-3"> ' +
                                '<img src="{{asset('images/products')}}/' + row.image + '" alt="' + row.name + '" class="image"></div> ' +
                                '<div class="><a href="#" class="fw-bold">' + row.name + '</a><div class="text-tiny mt-3">' + row.SKU + '</div> </div>';
                        }
                    },
                    {data: 'regular_price', name: 'regular_price'},
                    {data: 'sale_price', name: 'sale_price'},
                    {data: 'SKU', name: 'SKU'},
                    {data: 'category', name: 'category'},
                    {data: 'brand', name: 'brand'},
                    {
                        data: 'featured', name: 'featured', render: function (data, type, row) {
                            return row.featured === 1 ? 'Yes' : 'No';
                        }
                    },
                    {
                        data: 'stock_status', name: 'stock_status', render: function (data, type, row) {
                            return row.has_stock === true ? 'Yes' : 'No';
                        }
                    },
                    {data: 'quantity', name: 'quantity'},
                    {
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            return '<div class="d-flex align-items-center justify-content-between">' +
                                '<a data-url="{{route('admin.products.edit', ['id' => 'test'])}}" data-id=' + row.id + ' href="#" target="_blank" class="edit">' +
                                '<i class="icon-eye"></i>' +
                                '</a>' +
                                '<a data-url="{{route('admin.products.destroy', ['id' => 'test'])}}" data-id=' + row.id + ' href="#" target="_blank" class="delete">' +
                                '<i class="fa fa-trash"></i>' +
                                '</a>' +
                                '</div>';
                        }
                    }
                ]
            });
        });
    </script>
@endpush


