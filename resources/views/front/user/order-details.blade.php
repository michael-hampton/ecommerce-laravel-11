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

                    <div id="alertMessage" class="alert alert-success alert-dismissable d-none"></div>

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
                                        <span class="badge {{ $order->statusBadge() }}">{{$order->statusText()}}</span>
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
                                    <th class="text-center">Insurance</th>
                                    <th class="text-center">Shipping</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Return Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderItems as $item)
                                    <tr>

                                        <td class="pname">
                                            <div class="image">
                                                <img style="width: 50px"
                                                    src="{{asset('images/products')}}/{{$item->product->image}}"
                                                    alt="{{$item->product->name}}" class="image">
                                            </div>
                                            <div class="name">
                                                <a href="{{route('shop.product.details', ['slug' => $item->product->slug])}}"
                                                    target="_blank" class="body-title-2">{{$item->product->name}}</a>
                                            </div>
                                        </td>
                                        <td class="text-center">{{$item->price}}</td>
                                        <td class="text-center">{{$item->quantity}}</td>
                                        <td class="text-center">{{$item->SKU}}</td>
                                        <td class="text-center">{{$item->product->category->name}}</td>
                                        <td class="text-center">{{round($item->commission, 2)}}</td>
                                        <td class="text-center">{{round($item->shipping_price, 2)}}</td>
                                        <td class="text-center">{{round($item->total(), 2)}}</td>
                                        <td class="text-center">{{$item->status == 0 ? 'No' : 'Yes'}}</td>
                                        <td class="text-center">
                                            @if(empty($item->approved_date) && !in_array($item->status, ['complete', 'refund_requested', 'issue_reported']))
                                                <a data-id="{{ $item->id }}" id="reportOrder" class="btn btn-warning btn-lg">Report
                                                    an issue</a>
                                            @else
                                                <span class="badge bg-success">Approved</span>
                                            @endif
                                            @if(in_array($order->status, ['complete', 'delivered']))
                                                <button type="button" class="btn btn-primary review-product"
                                                    data-id="{{ $item->id }}">
                                                    Review Product
                                                </button>
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
                                    <td>{{round($order->total, 2)}}</td>
                                    <th>Payment Mode</th>
                                    <td>{{$order->transaction->count() > 0 ? $order->transaction->first()->payment_method : 'Seller Balance'}}
                                    </td>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge bg-success">{{$order->status}}</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($order->status !== 'complete' && $order->orderItems->whereNotIn('status', ['complete', 'refund_requested', 'issue_reported'])->count() > 0)
                    <div class="wg-box mt-5 d-flex align-items-center justify-content-between">
                        <form action="{{route('orders.cancelOrder', ['orderId' => $order->id])}}" method="POST">
                            @csrf
                            @method('put')
                            <button type="submit" class="btn btn-danger cancel-order">Cancel Order</button>
                        </form>

                        <a id="approve-order" data-toggle="modal" data-target="#exampleModal" href="#"
                            class="btn btn-success btn-lg">I'm
                            happy with the order</a>
                    </div>
                @endif
            </div>
        </div>
@endsection

    <!-- Approve Order Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Approve Items</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-success alert-dismissable d-none" id="bulkSuccess">
                        Thankyou for approving the items. The seller has been notified. Please feel free to leave a
                        review
                    </div>
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">
                                    <input class="form-check-input" type="checkbox" id="selectAll">
                                </th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                            </tr>

                        </thead>
                        <tbody>
                            @foreach($order->orderItems->whereNotIn('status', ['complete', 'refund_requested', 'issue_reported']) as $item)
                                <tr>
                                    <td><input class="form-check-input row-checkbox" type="checkbox"
                                            value="{{ $item->id }}"></td>
                                    <td>{{$item->product->name}}</td>
                                    <td>{{$item->seller->name}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-success" id="deleteSelected" disabled>Approve Selected Items</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Report Order Modal -->
    <div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Report Item</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-success alert-dismissable d-none" id="bulkSuccess">
                        Thankyou for approving the items. The seller has been notified. Please feel free to leave a
                        review
                    </div>

                    <form id="reportForm">
                        <input type="hidden" id="itemId">
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="6"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="formFileMultiple" class="form-label">Upload images to show issue</label>
                            <input class="form-control" type="file" name="images[]" id="formFileMultiple" multiple>
                        </div>
                    </form>

                    How can the issue be resolved?
                    <div class="d-grid gap-2">
                        <button id="returnRefund" class="btn btn-primary" type="button">Return Item and Refund</button>
                        <button id="refundNoReturn" class="btn btn-primary" type="button">Refund No return</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Review Modal -->
    <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Review Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="reviewForm">

                </div>
            </div>
        </div>
    </div>


    @push('scripts')
        <script>
            /* const closeButton = document.getElementsByClassName('close')
             Array.from(closeButton).forEach(element => {
                 element.addEventListener('click', () => {
                     var myModal = new bootstrap.Modal(document.getElementById("exampleModal"), {});
                     myModal.hide();

                      var myModal2 = new bootstrap.Modal(document.getElementById("reviewModal"), {});
                     myModal.hide();
                 })
             });*/
            const reviewButton = document.getElementsByClassName('review-product')[0]

            reviewButton?.addEventListener('click', function (event) {
                $.ajax({
                    url: "{{ route('createReview', ['orderItemId' => 'test']) }}".replace('test', event.currentTarget.getAttribute('data-id')),
                    type: "GET",
                }).done(function (msg) {
                    const reviewForm = document.getElementById('reviewForm')
                    reviewForm.innerHTML = msg.view
                    var myModal = new bootstrap.Modal(document.getElementById("reviewModal"), {});
                    myModal.show();

                    setTimeout(() => {
                        StarRating()
                        submitForm()
                    }, 200);
                });
            });

            const reportButton = document.getElementById('reportOrder')

            reportButton?.addEventListener('click', (e) => {
                const itemId = e.currentTarget.getAttribute('data-id')
                document.getElementById('itemId').value = itemId
                e.preventDefault()
                var myModal = new bootstrap.Modal(document.getElementById("reportModal"), {});
                myModal.show();
            })

            const submitReportBtn = document.getElementById('refundNoReturn');

            submitReportBtn.addEventListener('click', () => {
                submitOrderReport('refundNoReturn')
            });

            const submitReportBtn2 = document.getElementById('returnRefund');

            submitReportBtn2.addEventListener('click', () => {
                submitOrderReport('returnRefund')
            });

            const approveButton = document.getElementById('approve-order')
            approveButton.addEventListener('click', (e) => {
                e.preventDefault();
                var myModal = new bootstrap.Modal(document.getElementById("exampleModal"), {});
                myModal.show();
            })

            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.row-checkbox');
            const deleteBtn = document.getElementById('deleteSelected');

            deleteBtn.addEventListener('click', () => {
                const values = Array.from(checkboxes).map(x => x.value)

                fetch("{{ route('orders.approveOrder', ['orderId' => $order->id]) }}", {
                    method: "POST",
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ values: values, _token: "{{ csrf_token() }}" })
                }).then(res => {
                    var successMessage = document.getElementById('bulkSuccess')
                    successMessage.classList.remove('d-none')
                    var myModalEl = document.getElementById('reportModal');
                    var modal = bootstrap.Modal.getInstance(myModalEl)
                    modal.hide();
                });
            });

            function submitOrderReport(reason) {
                var form = document.getElementById('reportForm')
                var postData = new FormData(form);
                postData.append('_token', "{{ csrf_token() }}")
                postData.append('reason', reason.trim())


                $.ajax({
                    url: "{{ route('orders.reportOrder', ['orderItemId' => 'test']) }}".replace('test', document.getElementById('itemId').value),
                    type: "POST",
                    data: postData,
                    processData: false,
                    contentType: false
                }).done(function (msg) {
                    console.log(msg);
                    var myModalEl = document.getElementById('reportModal');
                    var modal = bootstrap.Modal.getInstance(myModalEl)
                    modal.hide();
                });

            }

            function updateSelectAll() {
                selectAll.checked = Array.from(checkboxes).every(cb => cb.checked);
            }

            function updateDeleteButton() {
                const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
                deleteBtn.disabled = !anyChecked;

            }

            function updateRowHighlight() {
                checkboxes.forEach(cb => {
                    cb.closest('tr').classList.toggle('selected-row', cb.checked);
                });
            }

            selectAll.addEventListener('change', () => {
                checkboxes.forEach(cb => cb.checked = selectAll.checked);
                updateRowHighlight();
                updateDeleteButton();
            });

            checkboxes.forEach(cb => {
                cb.addEventListener('change', () => {
                    updateSelectAll();
                    updateRowHighlight();
                    updateDeleteButton();
                });
            });

            deleteBtn.addEventListener('click', () => {
                checkboxes.forEach(cb => {
                    if (cb.checked) {
                        cb.closest('tr').remove();
                    }
                });

                updateDeleteButton();
                updateSelectAll();

            });
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

            function StarRating() {
                let stars = Array.from(document.querySelectorAll('.fa-star'));
                let user_selected_star = document.querySelector('#form-input-rating');

                stars.forEach(star => {
                    // Mouseover event
                    star.addEventListener('mouseover', (e) => {
                        stars.forEach((item, current_index) => {
                            if (current_index <= stars.indexOf(e.target)) {
                                item.classList.add('text-warning');
                            } else {
                                if (!item.classList.contains('is-selected')) {
                                    item.classList.remove('text-warning');
                                }
                            }
                        })
                    })

                    // Mouseover event
                    star.addEventListener('mouseleave', (e) => {
                        stars.forEach((item) => {
                            if (!item.classList.contains('is-selected')) {
                                item.classList.remove('text-warning');
                            }
                        })
                    })

                    // Click event
                    star.addEventListener('click', (e) => {
                        const selected_index = stars.indexOf(e.target);
                        user_selected_star.value = selected_index + 1;
                        stars.forEach((item, current_index) => {
                            if (current_index <= stars.indexOf(e.target)) {
                                item.classList.add('is-selected', 'text-warning');
                            } else {
                                item.classList.remove('is-selected', 'text-warning');
                            }
                        })
                    })
                })
            }

            function submitForm() {
                const reviewForm = document.querySelector('[name="customer-review-form"]')

                reviewForm.addEventListener('submit', (event) => {
                    event.preventDefault()
                    const action = event.currentTarget.getAttribute('action')

                    $.ajax({
                        url: action,
                        type: "POST",
                        data: {
                            review: document.querySelector('[name="review"]').value,
                            rating: document.querySelector('#form-input-rating').value,
                            _token: "{{ csrf_token() }}"
                        },
                    }).done(function (msg) {
                        const successMessage = document.getElementById('alertMessage')
                        successMessage.innerHTML = 'Review was added successfully. Thankyou'
                        successMessage.classList.remove('d-none')
                        var myModalEl = document.getElementById('reviewModal');
                        var modal = bootstrap.Modal.getInstance(myModalEl)
                        modal.hide();
                    });
                })
            }
        </script>
    @endpush