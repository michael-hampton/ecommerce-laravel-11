@php use App\Helper;use App\Services\Cart\Facade\Cart ;use Illuminate\Support\Facades\Session@endphp
@extends('layouts.app')
@section('content')
    <style>
        body {
            background-color: #f8f9fa;
        }

        .filter-sidebar {
            background: white;
            border-radius: 12px;
            position: sticky;
            top: 20px;
            height: fit-content;
        }

        .product-card {
            background: white;
            border-radius: 12px;
            transition: all 0.3s ease;
            height: 100%;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .product-image {
            height: 200px;
            object-fit: cover;
            border-radius: 12px 12px 0 0;
        }

        .price {
            color: #2563eb;
            font-weight: 600;
        }

        .discount-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #dc2626;
            color: white;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 0.875rem;
        }

        .wishlist-btn {
            position: absolute;
            top: 10px;
            left: 10px;
            background: white;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .wishlist-btn:hover {
            background: #fee2e2;
            color: #dc2626;
        }

        .rating-stars {
            color: #fbbf24;
        }

        .category-badge {
            background: #e5e7eb;
            color: #4b5563;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 0.75rem;
        }

        .filter-group {
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 1rem;
            margin-bottom: 1rem;
        }

        .color-option {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            cursor: pointer;
            position: relative;
        }

        .color-option.selected::after {
            content: '';
            position: absolute;
            inset: -3px;
            border: 2px solid #2563eb;
            border-radius: 50%;
        }

        .sort-btn {
            background: white;
            border: 1px solid #e5e7eb;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .sort-btn:hover {
            background: #f3f4f6;
        }

        .cart-btn {
            background: #2563eb;
            color: white;
            border: none;
            transition: all 0.2s;
        }

        .cart-btn:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
        }

        .filled-heart {
            color: orange;
        }

        .wishlist-amount {
            width: 1rem;
            height: 1rem;
            border-radius: 100%;
            background: #b9a16b;
            color: #ffffff;
            font-size: 0.625rem;
            line-height: 1rem;
            text-align: center;
        }
    </style>
    <div class="container py-5">
        <!-- Top Bar -->
        <div class="shop-topbar">
            @include('front.partials.shop-topbar')
        </div>

        <div class="row g-4">
            <!-- Filters Sidebar -->
            <div class="col-lg-3">
                <div class="filter-sidebar p-4 shadow-sm">
                    <div class="filter-group">
                        <h6 class="mb-3">Categories</h6>
                        @foreach($categories->where('parent_id', 0) as $category)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="{{$category->name}}"
                                       value="{{$category->id}}" name="categories"
                                       @if(in_array($category->id, explode(',', $categoryId))) checked="checked" @endif>
                                <label class="form-check-label" for="{{$category->name}}">
                                    {{$category->name}}
                                    ({{$category->products->count()}})
                                </label>
                            </div>

                            <!-- subcategory -->
                            @if($category->subcategories->count() > 0)
                                @foreach($category->subcategories as $subcategory)
                                    <div class="form-check mb-2 ms-5">
                                        <input class="form-check-input" type="checkbox" id="{{$subcategory->name}}"
                                               value="{{$subcategory->id}}" name="categories"
                                               @if(in_array($subcategory->id, explode(',', $categoryId))) checked="checked" @endif>
                                        <label class="form-check-label" for="{{$subcategory->name}}">
                                            {{$subcategory->name}}
                                            ({{$subcategory->products->count()}})
                                        </label>
                                    </div>

                                    @if($subcategory->subcategories->count() > 0)
                                        @foreach($subcategory->subcategories as $grandparent)
                                            <div class="form-check mb-2" style="margin-left: 70px">
                                                <input class="form-check-input" type="checkbox"
                                                       id="{{$grandparent->name}}"
                                                       value="{{$grandparent->id}}" name="categories"
                                                       @if(in_array($grandparent->id, explode(',', $categoryId))) checked="checked" @endif>
                                                <label class="form-check-label" for="{{$grandparent->name}}">
                                                    {{$grandparent->name}}
                                                    ({{$grandparent->products->count()}})
                                                </label>
                                            </div>
                                        @endforeach
                                    @endif
                                @endforeach

                            @endif

                        @endforeach
                    </div>

                    <div class="filter-group">
                        <h6 class="mb-3">Sizes</h6>
                        <div class="d-flex flex-wrap">
                            <a href="#"
                               class="swatch-size btn btn-sm btn-outline-light mb-3 me-3 js-filter">XS</a>
                            <a href="#"
                               class="swatch-size btn btn-sm btn-outline-light mb-3 me-3 js-filter">S</a>
                            <a href="#"
                               class="swatch-size btn btn-sm btn-outline-light mb-3 me-3 js-filter">M</a>
                            <a href="#"
                               class="swatch-size btn btn-sm btn-outline-light mb-3 me-3 js-filter">L</a>
                            <a href="#"
                               class="swatch-size btn btn-sm btn-outline-light mb-3 me-3 js-filter">XL</a>
                            <a href="#"
                               class="swatch-size btn btn-sm btn-outline-light mb-3 me-3 js-filter">XXL</a>
                        </div>
                    </div>

                    <div class="filter-group">
                        <h6 class="mb-3">Price Range</h6>
                        <input type="range" class="form-range" min="1" max="5000" step="5" value="500"
                               name="price_range">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">{{$currency}}{{$minPrice}}</span>
                            <span class="text-muted">{{$currency}}{{$maxPrice}}</span>
                        </div>
                    </div>

                    <div class="filter-group">
                        <h6 class="mb-3">Colors</h6>
                        <div class="d-flex gap-2">
                            <div class="color-option selected" style="background: #000000;"></div>
                            <div class="color-option" style="background: #dc2626;"></div>
                            <div class="color-option" style="background: #2563eb;"></div>
                            <div class="color-option" style="background: #16a34a;"></div>
                        </div>
                    </div>

                    <div class="filter-group">
                        <h6 class="mb-3">Brands</h6>
                        @foreach($brands->where('parent_id', 0) as $brand)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="{{$brand->name}}"
                                       value="{{$brand->id}}" name="brands"
                                       @if(in_array($brand->id, explode(',', $brandId))) checked="checked" @endif>
                                <label class="form-check-label" for="{{$brand->name}}">
                                    {{$brand->name}}
                                   ({{$brand->products->count()}})
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <div class="filter-group">
                        <h6 class="mb-3">Rating</h6>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="rating" id="rating4">
                            <label class="form-check-label" for="rating4">
                                <i class="fa fa-star-fill text-warning"></i> 4 & above
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="rating" id="rating3">
                            <label class="form-check-label" for="rating3">
                                <i class="fa fa-star-fill text-warning"></i> 3 & above
                            </label>
                        </div>
                    </div>

                    <button class="btn btn-outline-primary w-100">Apply Filters</button>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="col-lg-9" id="product-list">
                @include('front.partials.product-search')
            </div>
        </div>
    </div>
    <form id="frmfilter" method="GET" action="{{route('shop.index')}}">
        <input type="hidden" name="page" id="page" value="{{$products->currentPage()}}">
        <input type="hidden" name="size" id="size" value="{{$size}}">
        <input type="hidden" name="orderBy" id="orderBy" value="{{$orderBy}}">
        <input type="hidden" name="brandId" id="brandId" value="{{$brandId}}">
        <input type="hidden" name="categoryId" id="categoryId" value="{{$categoryId}}">
        <input type="hidden" name="minPrice" id="minPrice" value="{{$minPrice}}">
        <input type="hidden" name="maxPrice" id="maxPrice" value="{{$maxPrice}}">
    </form>
@endsection

@push('scripts')
    <script>
        $(function () {
            $('#pagesize').on('change', function () {
                $('#size').val($('#pagesize option:selected').val());
                getData();
            });

            $('#total-number').on('change', function () {
                $('#orderBy').val($('#total-number option:selected').val());
                getData();
            });

            $('input[name="brands"]').on('change', function () {
                var brands = [];
                $('input[name="brands"]').each(function () {
                    var brandId = $(this).val()
                    if ($(this).is(':checked')) {
                        brands.push($(this).val())
                    } else {
                        brands = brands.filter(function (elem) {
                            return elem !== brandId
                        });
                    }
                })

                $('#brandId').val(brands.join(','));
                getData();

            })

            $('input[name="categories"]').on('change', function () {
                var categories = [];
                $('input[name="categories"]').each(function () {
                    var categoryId = $(this).val()
                    if ($(this).is(':checked')) {
                        categories.push($(this).val())
                    } else {
                        categories = categories.filter(function (elem) {
                            return elem !== categoryId
                        });
                    }
                })

                $('#categoryId').val(categories.join(','));
                getData();

            });

            $('[name="price_range"]').on('change', function () {
                var min = $(this).val().split(',')[0];
                var max = $(this).val().split(',')[1];

                $('#minPrice').val(min);
                $('#maxPrice').val(max);

                setTimeout(() => {
                    getData();
                }, 2000)

            });
        });

        $(document).off('click', '.pagination li a');
        $(document).on('click', '.pagination li a', function (event) {
            $('li').removeClass('active');
            $(this).parent('li').addClass('active');
            event.preventDefault();

            var myurl = $(this).attr('href');
            var page = $(this).attr('href').split('page=')[1];

            $('#page').val(page)

            getData()

        });


        function refreshTopbar() {
            let formData = Array
                .from(new FormData(document.getElementById('frmfilter')))
                .filter(function ([k, v]) {
                    return v
                });
            const params = new URLSearchParams(formData);

            $.ajax({
                url: "{{route('shop.refreshShopBreadcrumbs')}}" + '?' + params,
                type: "get",
                datatype: "html",
            })
                .done(function (data) {
                    $(".shop-topbar").empty().html(data);
                    //location.hash = page;
                })
                .fail(function (jqXHR, ajaxOptions, thrownError) {
                    alert('No response from server');
                });
        }

        function getData() {
            let formData = Array
                .from(new FormData(document.getElementById('frmfilter')))
                .filter(function ([k, v]) {
                    return v
                });
            const params = new URLSearchParams(formData);

            history.replaceState(null, null, "?" + params.toString());

            $.ajax({
                url: $('#frmfilter').attr('action') + '?' + params,
                type: "get",
                datatype: "html",
            })
                .done(function (data) {
                    $("#product-list").empty().html(data);
                    refreshTopbar();
                    //location.hash = page;
                })
                .fail(function (jqXHR, ajaxOptions, thrownError) {
                    alert('No response from server');
                });
        }
    </script>
@endpush
