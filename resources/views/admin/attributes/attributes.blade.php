@extends('layouts.admin')
@section('content')
    <div>
        <style>
            nav svg{
                height: 20px;
            }
            nav .hidden{
                display: block !important;
            }
            .sclist{
                list-style: none;
            }
            .sclist li{
                line-height: 33px;
                border-bottom: 1px solid #ccc;
            }
            .slink i{
                font-size:16px;
                margin-left:12px;
            }
        </style>
        <div class="container" style="padding:30px 0;">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-6">
                                    All Attributes
                                </div>
                                <div class="col-md-6">
                                    <a href="{{route('admin.add_attribute')}}" class="btn btn-success pull-right">Add New</a>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            @if(Session::has('message'))
                                <div class="alert alert-success" role="alert">{{Session::get('message')}}</div>
                            @endif
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($pattributes as $pattribute)
                                    <tr>
                                        <td>{{$pattribute->id}}</td>
                                        <td>{{$pattribute->name}}</td>
                                        <td>{{$pattribute->created_at}}</td>
                                        <td>
                                            <a href="{{route('admin.edit_attribute',['attribute_id'=>$pattribute->id])}}"><i class="fa fa-edit fa-2x"></i></a>

                                            <form action="{{route('admin.attributes.destroy', ['id' => $pattribute->id])}}" method="POST">
                                                @csrf
                                                @method('delete')
                                                <div class="item text-danger delete">
                                                    <i class="icon-trash-2"></i>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{$pattributes->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function(){
            $(".delete").on('click',function(e){
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
