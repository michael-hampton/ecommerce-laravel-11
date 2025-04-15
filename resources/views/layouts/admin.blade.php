@php use Illuminate\Support\Facades\Auth; @endphp

@include('layouts.top')

<body class="body">
<div class="container-fluid">
    <div class="row flex-nowrap">
        @include('layouts.sidebar')
        <div class="col py-3">
            @yield('content')
        </div>
    </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary confirm-edit">Save changes</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Create</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary confirm-add">Save changes</button>
            </div>
        </div>
    </div>
</div>

</body>
<script src="{{ asset('js/jquery.min.js')}}"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/bootstrap-select.min.js')}}"></script>
<script src="{{asset('js/sweetalert.min.js')}}"></script>
<script src="{{asset('js/apexcharts/apexcharts.js')}}"></script>
<script src="{{asset('js/main.js')}}"></script>

<script>
    (function ($) {

        $('#search-keyword').on('keyup', delay(function (e) {
            var searchQuery = $(this).val();

            if (searchQuery.length < 3) {
                return;
            }

            $.ajax({
                type: 'GET',
                url: "{{route('shop.searchProducts')}}",
                data: {query: searchQuery},
                dataType: 'json',
                success: function (data) {
                    $('#box-content-search').html('');
                    $.each(data, function (index, item) {
                        var url = "{{route('admin.products.edit', ['id' => 'product_slug_pls'])}}";
                        var link = url.replace('product_slug_pls', item.id)

                        $('#box-content-search').append(`<li><ul class="list-unstyled"><li class="product-item gap14 mb-2 d-flex">
                            <div class="image d-flex align-items-center justify-content-center no-bg">
                            <img style="width:50px; height: 50px; padding: 5px; border-radius: 10px; gap: 10px" src="{{asset('storage/images/products')}}/${item.image}" alt="${item.name}">
                            </div>
                            <div class="d-flex align-items-center justify-content-between flex-grow-1 gap20">
                            <div class="name"><a href="${link}" class="body-text">${item.name}</a></div>
                            </div>
                            </li>
                            <li class="mb-10"><div class="divider"></li>
                            </ul></li>
                       `)
                    });
                }
            })
        }))

        var tfLineChart = (function () {

            var chartBar = function () {

                var options = {
                    series: [{
                        name: 'Total',
                        data: [0.00, 0.00, 0.00, 0.00, 0.00, 273.22, 208.12, 0.00, 0.00, 0.00, 0.00, 0.00]
                    }, {
                        name: 'Pending',
                        data: [0.00, 0.00, 0.00, 0.00, 0.00, 273.22, 208.12, 0.00, 0.00, 0.00, 0.00, 0.00]
                    },
                        {
                            name: 'Delivered',
                            data: [0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00]
                        }, {
                            name: 'Canceled',
                            data: [0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00]
                        }],
                    chart: {
                        type: 'bar',
                        height: 325,
                        toolbar: {
                            show: false,
                        },
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '10px',
                            endingShape: 'rounded'
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    legend: {
                        show: false,
                    },
                    colors: ['#2377FC', '#FFA500', '#078407', '#FF0000'],
                    stroke: {
                        show: false,
                    },
                    xaxis: {
                        labels: {
                            style: {
                                colors: '#212529',
                            },
                        },
                        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    },
                    yaxis: {
                        show: false,
                    },
                    fill: {
                        opacity: 1
                    },
                    tooltip: {
                        y: {
                            formatter: function (val) {
                                return "$ " + val + ""
                            }
                        }
                    }
                };

                chart = new ApexCharts(
                    document.querySelector("#line-chart-8"),
                    options
                );
                if ($("#line-chart-8").length > 0) {
                    chart.render();
                }
            };

            /* Function ============ */
            return {
                init: function () {
                },

                load: function () {
                    chartBar();
                },
                resize: function () {
                },
            };
        })();

        jQuery(document).ready(function () {
        });

        jQuery(window).on("load", function () {
            tfLineChart.load();
        });

        jQuery(window).on("resize", function () {
        });
    })(jQuery);

    function delay(callback, ms) {
        var timer = 0;
        return function() {
            var context = this, args = arguments;
            clearTimeout(timer);
            timer = setTimeout(function () {
                callback.apply(context, args);
            }, ms || 0);
        };
    }
</script>

@stack('scripts')
</body>

</html>

