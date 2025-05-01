@extends('layouts.app')
@section('content')

<style>
    .bg-body-tertiary {
    background-color: rgba(245,247, 250) !important;
}
</style>

    <main class="content-wrapper">
        <section class="pt-3 pt-sm-4 container">
            <div class="position-relative px-4 px-sm-5 px-xl-0 py-5"><span
                    class="position-absolute top-0 start-0 w-100 h-100 rounded-5 d-none-dark rtl-flip"
                    style="background: linear-gradient(-90deg, rgb(172, 203, 238) 0%, rgb(231, 240, 253) 100%);"></span><span
                    class="position-absolute top-0 start-0 w-100 h-100 rounded-5 d-none d-block-dark rtl-flip"
                    style="background: linear-gradient(-90deg, rgb(27, 39, 58) 0%, rgb(31, 38, 50) 100%);"></span>
                <div class="position-relative z-1">
                    <h1 class="h2 text-center pt-md-2 pt-lg-3 pt-xl-4 mb-4">How can we help?</h1>
                    <div class="position-relative mx-auto mb-4" style="max-width: 545px;"><i
                            class="ci-search position-absolute top-50 start-0 translate-middle-y text-body fs-lg ms-3"></i><input
                            placeholder="What do you need help with?" aria-label="Search field"
                            class="form-icon-start form-control form-control-lg" type="search"></div>
                    <div class="justify-content-center g-4 pt-2 pt-sm-3 pb-md-2 pb-lg-3 pb-xl-4 row">
                        <div class="text-center col-xl-2 col-md-3 col-6">
                            <div class="position-relative d-inline-block">
                                <div class="position-relative d-inline-flex justify-content-center align-items-center text-body-emphasis"
                                    style="width: 48px; height: 48px;"><span
                                        class="position-absolute top-0 start-0 w-100 h-100 bg-white bg-opacity-50 rounded-circle d-none-dark"></span><span
                                        class="position-absolute top-0 start-0 w-100 h-100 bg-white bg-opacity-10 rounded-circle d-none d-block-dark"></span><i
                                        class="ci-delivery position-relative z-1 fs-xl"></i></div>
                                <h3 class="text-dark fs-sm fw-medium pt-1 mt-2 mb-0"><a
                                        class="hover-effect-underline stretched-link text-decoration-none"
                                        href="/help/article">Track your order</a></h3>
                            </div>
                        </div>
                        <div class="text-center col-xl-2 col-md-3 col-6">
                            <div class="position-relative d-inline-block">
                                <div class="position-relative d-inline-flex justify-content-center align-items-center text-body-emphasis"
                                    style="width: 48px; height: 48px;"><span
                                        class="position-absolute top-0 start-0 w-100 h-100 bg-white bg-opacity-50 rounded-circle d-none-dark"></span><span
                                        class="position-absolute top-0 start-0 w-100 h-100 bg-white bg-opacity-10 rounded-circle d-none d-block-dark"></span><i
                                        class="ci-shopping-bag position-relative z-1 fs-xl"></i></div>
                                <h3 class="text-dark fs-sm fw-medium pt-1 mt-2 mb-0"><a
                                        class="hover-effect-underline stretched-link text-decoration-none"
                                        href="/help/article">Edit or cancel order</a></h3>
                            </div>
                        </div>
                        <div class="text-center col-xl-2 col-md-3 col-6">
                            <div class="position-relative d-inline-block">
                                <div class="position-relative d-inline-flex justify-content-center align-items-center text-body-emphasis"
                                    style="width: 48px; height: 48px;"><span
                                        class="position-absolute top-0 start-0 w-100 h-100 bg-white bg-opacity-50 rounded-circle d-none-dark"></span><span
                                        class="position-absolute top-0 start-0 w-100 h-100 bg-white bg-opacity-10 rounded-circle d-none d-block-dark"></span><i
                                        class="ci-refresh-cw position-relative z-1 fs-xl"></i></div>
                                <h3 class="text-dark fs-sm fw-medium pt-1 mt-2 mb-0"><a
                                        class="hover-effect-underline stretched-link text-decoration-none"
                                        href="/help/article">Returns &amp; refunds</a></h3>
                            </div>
                        </div>
                        <div class="text-center col-xl-2 col-md-3 col-6">
                            <div class="position-relative d-inline-block">
                                <div class="position-relative d-inline-flex justify-content-center align-items-center text-body-emphasis"
                                    style="width: 48px; height: 48px;"><span
                                        class="position-absolute top-0 start-0 w-100 h-100 bg-white bg-opacity-50 rounded-circle d-none-dark"></span><span
                                        class="position-absolute top-0 start-0 w-100 h-100 bg-white bg-opacity-10 rounded-circle d-none d-block-dark"></span><i
                                        class="ci-gift position-relative z-1 fs-xl"></i></div>
                                <h3 class="text-dark fs-sm fw-medium pt-1 mt-2 mb-0"><a
                                        class="hover-effect-underline stretched-link text-decoration-none"
                                        href="/help/article">My bonus account</a></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="pt-4 container">
            <div class="g-4 g-sm-3 g-md-4 row row-cols-lg-3 row-cols-sm-2 row-cols-1">
                <div class="col">
                    <div class="h-100 bg-body-tertiary border-0 p-md-2 card">
                        <div class="card-body">
                            <h3 class="h5 d-flex mb-4"><i class="ci-delivery fs-xl pe-1 mt-1 me-2"></i>Delivery</h3>
                            <ul class="flex-column gap-3 nav">
                                <li><a data-rr-ui-event-key="/help/article"
                                        class="hover-effect-underline fw-normal p-0 nav-link" href="/help/article">Can I
                                        track my order in real-time?</a></li>
                                <li><a data-rr-ui-event-key="/help/article"
                                        class="hover-effect-underline fw-normal p-0 nav-link" href="/help/article">Is there
                                        an option for express delivery?</a></li>
                                <li><a data-rr-ui-event-key="/help/article"
                                        class="hover-effect-underline fw-normal p-0 nav-link" href="/help/article">Will my
                                        parcel be charged customs charges?</a></li>
                                <li><a data-rr-ui-event-key="/help/article"
                                        class="hover-effect-underline fw-normal p-0 nav-link" href="/help/article">Do you
                                        offer international delivery?</a></li>
                                <li><a data-rr-ui-event-key="/help/article"
                                        class="hover-effect-underline fw-normal p-0 nav-link" href="/help/article">Why does
                                        my statement have a recurring charge?</a></li>
                            </ul>
                        </div>
                        <div class="bg-transparent border-0 pt-0 card-footer nav"><a data-rr-ui-event-key="#"
                                class="animate-underline px-0 py-2 nav-link" href="#"><span class="animate-target">View
                                    all</span><i class="ci-chevron-right fs-base ms-1"></i></a></div>
                    </div>
                </div>
                <div class="col">
                    <div class="h-100 bg-body-tertiary border-0 p-md-2 card">
                        <div class="card-body">
                            <h3 class="h5 d-flex mb-4"><i class="ci-refresh-cw fs-xl pe-1 mt-1 me-2"></i>Returns &amp;
                                refunds</h3>
                            <ul class="flex-column gap-3 nav">
                                <li><a data-rr-ui-event-key="/help/article"
                                        class="hover-effect-underline fw-normal p-0 nav-link" href="/help/article">What is
                                        your returns policy?</a></li>
                                <li><a data-rr-ui-event-key="/help/article"
                                        class="hover-effect-underline fw-normal p-0 nav-link" href="/help/article">I paid
                                        with Afterpay, how do returns work?</a></li>
                                <li><a data-rr-ui-event-key="/help/article"
                                        class="hover-effect-underline fw-normal p-0 nav-link" href="/help/article">What
                                        happens to my refund if I return 45 days?</a></li>
                                <li><a data-rr-ui-event-key="/help/article"
                                        class="hover-effect-underline fw-normal p-0 nav-link" href="/help/article">How do I
                                        return something to you?</a></li>
                                <li><a data-rr-ui-event-key="/help/article"
                                        class="hover-effect-underline fw-normal p-0 nav-link" href="/help/article">Can I
                                        return an exchange instead of a refund?</a></li>
                            </ul>
                        </div>
                        <div class="bg-transparent border-0 pt-0 card-footer nav"><a data-rr-ui-event-key="#"
                                class="animate-underline px-0 py-2 nav-link" href="#"><span class="animate-target">View
                                    all</span><i class="ci-chevron-right fs-base ms-1"></i></a></div>
                    </div>
                </div>
                <div class="col">
                    <div class="h-100 bg-body-tertiary border-0 p-md-2 card">
                        <div class="card-body">
                            <h3 class="h5 d-flex mb-4"><i class="ci-credit-card fs-xl pe-1 mt-1 me-2"></i>Payment options
                            </h3>
                            <ul class="flex-column gap-3 nav">
                                <li><a data-rr-ui-event-key="/help/article"
                                        class="hover-effect-underline fw-normal p-0 nav-link" href="/help/article">How do I
                                        place an order?</a></li>
                                <li><a data-rr-ui-event-key="/help/article"
                                        class="hover-effect-underline fw-normal p-0 nav-link" href="/help/article">My
                                        payment was declined, what should I do?</a></li>
                                <li><a data-rr-ui-event-key="/help/article"
                                        class="hover-effect-underline fw-normal p-0 nav-link" href="/help/article">When will
                                        I be charged for my order?</a></li>
                                <li><a data-rr-ui-event-key="/help/article"
                                        class="hover-effect-underline fw-normal p-0 nav-link" href="/help/article">How do I
                                        pay using Google Pay?</a></li>
                                <li><a data-rr-ui-event-key="/help/article"
                                        class="hover-effect-underline fw-normal p-0 nav-link" href="/help/article">How do I
                                        use my Gift Voucher to pay for an order?</a></li>
                            </ul>
                        </div>
                        <div class="bg-transparent border-0 pt-0 card-footer nav"><a data-rr-ui-event-key="#"
                                class="animate-underline px-0 py-2 nav-link" href="#"><span class="animate-target">View
                                    all</span><i class="ci-chevron-right fs-base ms-1"></i></a></div>
                    </div>
                </div>
                <div class="col">
                    <div class="h-100 bg-body-tertiary border-0 p-md-2 card">
                        <div class="card-body">
                            <h3 class="h5 d-flex mb-4"><i class="ci-shopping-bag fs-xl pe-1 mt-1 me-2"></i>Order issues</h3>
                            <ul class="flex-column gap-3 nav">
                                <li><a data-rr-ui-event-key="/help/article"
                                        class="hover-effect-underline fw-normal p-0 nav-link" href="/help/article">Can I
                                        amend my order after I've placed it?</a></li>
                                <li><a data-rr-ui-event-key="/help/article"
                                        class="hover-effect-underline fw-normal p-0 nav-link" href="/help/article">I've
                                        received a faulty item, what should I do?</a></li>
                                <li><a data-rr-ui-event-key="/help/article"
                                        class="hover-effect-underline fw-normal p-0 nav-link" href="/help/article">I've
                                        received an incorrect item, what do I do?</a></li>
                                <li><a data-rr-ui-event-key="/help/article"
                                        class="hover-effect-underline fw-normal p-0 nav-link" href="/help/article">I've
                                        bought a gift voucher, can I cancel or return it?</a></li>
                                <li><a data-rr-ui-event-key="/help/article"
                                        class="hover-effect-underline fw-normal p-0 nav-link" href="/help/article">What if
                                        isn't right on my customs invoice?</a></li>
                            </ul>
                        </div>
                        <div class="bg-transparent border-0 pt-0 card-footer nav"><a data-rr-ui-event-key="#"
                                class="animate-underline px-0 py-2 nav-link" href="#"><span class="animate-target">View
                                    all</span><i class="ci-chevron-right fs-base ms-1"></i></a></div>
                    </div>
                </div>
                <div class="col">
                    <div class="h-100 bg-body-tertiary border-0 p-md-2 card">
                        <div class="card-body">
                            <h3 class="h5 d-flex mb-4"><i class="ci-archive fs-xl pe-1 mt-1 me-2"></i>Products &amp; stock
                            </h3>
                            <ul class="flex-column gap-3 nav">
                                <li><a data-rr-ui-event-key="/help/article"
                                        class="hover-effect-underline fw-normal p-0 nav-link" href="/help/article">Where can
                                        I find your size guide?</a></li>
                                <li><a data-rr-ui-event-key="/help/article"
                                        class="hover-effect-underline fw-normal p-0 nav-link" href="/help/article">Where can
                                        I find your care instructions?</a></li>
                                <li><a data-rr-ui-event-key="/help/article"
                                        class="hover-effect-underline fw-normal p-0 nav-link" href="/help/article">Can you
                                        tell me more about Collusion?</a></li>
                                <li><a data-rr-ui-event-key="/help/article"
                                        class="hover-effect-underline fw-normal p-0 nav-link" href="/help/article">How do I
                                        change my Fit Assistant Information?</a></li>
                                <li><a data-rr-ui-event-key="/help/article"
                                        class="hover-effect-underline fw-normal p-0 nav-link" href="/help/article">What are
                                        your adhesive product guidelines?</a></li>
                            </ul>
                        </div>
                        <div class="bg-transparent border-0 pt-0 card-footer nav"><a data-rr-ui-event-key="#"
                                class="animate-underline px-0 py-2 nav-link" href="#"><span class="animate-target">View
                                    all</span><i class="ci-chevron-right fs-base ms-1"></i></a></div>
                    </div>
                </div>
                <div class="col">
                    <div class="h-100 bg-body-tertiary border-0 p-md-2 card">
                        <div class="card-body">
                            <h3 class="h5 d-flex mb-4"><i class="ci-settings fs-xl pe-1 mt-1 me-2"></i>Managing account</h3>
                            <ul class="flex-column gap-3 nav">
                                <li><a data-rr-ui-event-key="/help/article"
                                        class="hover-effect-underline fw-normal p-0 nav-link" href="/help/article">How do I
                                        create an account?</a></li>
                                <li><a data-rr-ui-event-key="/help/article"
                                        class="hover-effect-underline fw-normal p-0 nav-link" href="/help/article">I'm
                                        having trouble signing into my account.</a></li>
                                <li><a data-rr-ui-event-key="/help/article"
                                        class="hover-effect-underline fw-normal p-0 nav-link" href="/help/article">I'm
                                        having problems using your App.</a></li>
                                <li><a data-rr-ui-event-key="/help/article"
                                        class="hover-effect-underline fw-normal p-0 nav-link" href="/help/article">Do I need
                                        to create an account to shop with you?</a></li>
                                <li><a data-rr-ui-event-key="/help/article"
                                        class="hover-effect-underline fw-normal p-0 nav-link" href="/help/article">I'd like
                                        to delete my account what should I do?</a></li>
                            </ul>
                        </div>
                        <div class="bg-transparent border-0 pt-0 card-footer nav"><a data-rr-ui-event-key="#"
                                class="animate-underline px-0 py-2 nav-link" href="#"><span class="animate-target">View
                                    all</span><i class="ci-chevron-right fs-base ms-1"></i></a></div>
                    </div>
                </div>
            </div>
        </section>
        <section class="mt-1 my-sm-2 my-md-3 my-lg-4 mt-xl-5 pb-xl-2">
            <div class="py-5 container">
                <h2 class="text-center pb-2 pb-sm-3 pb-lg-4">Popular articles</h2>
                <div class="g-0 overflow-x-auto pb-3 mb-2 mb-md-3 mb-lg-4 row">
                    <div class="mx-auto col-auto">
                        <ul class="flex-nowrap text-nowrap nav nav-pills">
                            <li class="nav-item"><a role="button" class="rounded nav-link active" tabindex="0"
                                    href="#">Delivery</a></li>
                            <li class="nav-item"><a role="button" class="rounded nav-link" tabindex="0" href="#">Returns
                                    &amp; refunds</a></li>
                            <li class="nav-item"><a role="button" class="rounded nav-link" tabindex="0" href="#">Payment</a>
                            </li>
                            <li class="nav-item"><a role="button" class="rounded nav-link" tabindex="0" href="#">Order
                                    issues</a></li>
                            <li class="nav-item"><a role="button" class="rounded nav-link" tabindex="0" href="#">Products
                                    &amp; stock</a></li>
                            <li class="nav-item"><a role="button" class="rounded nav-link" tabindex="0" href="#">Account</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="position-relative mx-2 mx-sm-0">
                    <div class="swiper swiper-initialized swiper-horizontal swiper-autoheight swiper-backface-hidden">
                        <div class="swiper-wrapper" style="height: 410px; transform: translate3d(0px, 0px, 0px);">
                            <div class="swiper-slide swiper-slide-active" data-swiper-slide-index="0"
                                style="width: 416px; margin-right: 24px;"><a
                                    class="d-flex hover-effect-scale bg-body-secondary rounded overflow-hidden"
                                    href="/help/article"><img alt="Image" loading="lazy" width="624" height="459"
                                        decoding="async" data-nimg="1" class="hover-effect-target"
                                        srcset="/_next/image?url=%2Fimg%2Fhelp%2Farticle01.jpg&amp;w=640&amp;q=75 1x, /_next/image?url=%2Fimg%2Fhelp%2Farticle01.jpg&amp;w=1920&amp;q=75 2x"
                                        src="/_next/image?url=%2Fimg%2Fhelp%2Farticle01.jpg&amp;w=1920&amp;q=75"
                                        style="color: transparent;"></a>
                                <div class="pt-4">
                                    <div class="text-body-tertiary fs-xs pb-2 mt-n1 mb-1">October 2, 2025</div>
                                    <h3 class="h5 mb-0"><a class="hover-effect-underline" href="/help/article">When should I
                                            place an order to ensure Express Delivery?</a></h3>
                                </div>
                            </div>
                            <div class="swiper-slide swiper-slide-next" data-swiper-slide-index="1"
                                style="width: 416px; margin-right: 24px;"><a
                                    class="d-flex hover-effect-scale bg-body-secondary rounded overflow-hidden"
                                    href="/help/article"><img alt="Image" loading="lazy" width="624" height="459"
                                        decoding="async" data-nimg="1" class="hover-effect-target"
                                        srcset="/_next/image?url=%2Fimg%2Fhelp%2Farticle02.jpg&amp;w=640&amp;q=75 1x, /_next/image?url=%2Fimg%2Fhelp%2Farticle02.jpg&amp;w=1920&amp;q=75 2x"
                                        src="/_next/image?url=%2Fimg%2Fhelp%2Farticle02.jpg&amp;w=1920&amp;q=75"
                                        style="color: transparent;"></a>
                                <div class="pt-4">
                                    <div class="text-body-tertiary fs-xs pb-2 mt-n1 mb-1">July 17, 2025</div>
                                    <h3 class="h5 mb-0"><a class="hover-effect-underline" href="/help/article">Why does my
                                            statement have a recurring delivery charge?</a></h3>
                                </div>
                            </div>
                            <div class="swiper-slide" data-swiper-slide-index="2" style="width: 416px; margin-right: 24px;">
                                <a class="d-flex hover-effect-scale bg-body-secondary rounded overflow-hidden"
                                    href="/help/article"><img alt="Image" loading="lazy" width="624" height="459"
                                        decoding="async" data-nimg="1" class="hover-effect-target"
                                        srcset="/_next/image?url=%2Fimg%2Fhelp%2Farticle03.jpg&amp;w=640&amp;q=75 1x, /_next/image?url=%2Fimg%2Fhelp%2Farticle03.jpg&amp;w=1920&amp;q=75 2x"
                                        src="/_next/image?url=%2Fimg%2Fhelp%2Farticle03.jpg&amp;w=1920&amp;q=75"
                                        style="color: transparent;"></a>
                                <div class="pt-4">
                                    <div class="text-body-tertiary fs-xs pb-2 mt-n1 mb-1">June 13, 2025</div>
                                    <h3 class="h5 mb-0"><a class="hover-effect-underline" href="/help/article">How can I
                                            find information about your international delivery?</a></h3>
                                </div>
                            </div>
                            <div class="swiper-slide" data-swiper-slide-index="3" style="width: 416px; margin-right: 24px;">
                                <a class="d-flex hover-effect-scale bg-body-secondary rounded overflow-hidden"
                                    href="/help/article"><img alt="Image" loading="lazy" width="624" height="459"
                                        decoding="async" data-nimg="1" class="hover-effect-target"
                                        srcset="/_next/image?url=%2Fimg%2Fhelp%2Farticle04.jpg&amp;w=640&amp;q=75 1x, /_next/image?url=%2Fimg%2Fhelp%2Farticle04.jpg&amp;w=1920&amp;q=75 2x"
                                        src="/_next/image?url=%2Fimg%2Fhelp%2Farticle04.jpg&amp;w=1920&amp;q=75"
                                        style="color: transparent;"></a>
                                <div class="pt-4">
                                    <div class="text-body-tertiary fs-xs pb-2 mt-n1 mb-1">May 30, 2025</div>
                                    <h3 class="h5 mb-0"><a class="hover-effect-underline" href="/help/article">Will my
                                            parcel be charged additional customs charges?</a></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="position-absolute top-50 start-0 z-2 translate-middle hover-effect-target mt-n5"><button
                            type="button" aria-label="Prev"
                            class="btn-prev btn-icon bg-body animate-slide-start rounded-circle btn btn-outline-secondary"><i
                                class="ci-chevron-left fs-lg animate-target"></i></button></div>
                    <div class="position-absolute top-50 start-100 z-2 translate-middle hover-effect-target mt-n5"><button
                            type="button" aria-label="Next"
                            class="btn-next btn-icon bg-body animate-slide-end rounded-circle btn btn-outline-secondary"><i
                                class="ci-chevron-right fs-lg animate-target"></i></button></div>
                </div>
            </div>
        </section>
        <section class="border-top">
            <div class="py-5 container">
                <div class="py-1 py-sm-2 py-md-3 py-lg-4 py-xl-5 row">
                    <div class="mb-4 mb-md-0 col-xl-3 col-md-4" style="margin-top: -120px;">
                        <div class="sticky-md-top text-center text-md-start pe-md-4 pe-lg-5 pe-xl-0"
                            style="padding-top: 120px;">
                            <h2>Popular FAQs</h2>
                            <p class="pb-2 pb-md-3">Still have unanswered questions and need to get in touch?</p><a
                                role="button" tabindex="0" href="#" class="btn btn-primary btn-lg">Contact us</a>
                        </div>
                    </div>
                    <div class="offset-xl-1 col-md-8">
                        <div class="accordion">
                            <div class="accordion-item">
                                <h3 class="hover-effect-underline accordion-header"><button type="button"
                                        aria-expanded="false" class="accordion-button collapsed"><span class="me-2">How long
                                            will delivery take?</span></button></h3>
                                <div class="accordion-collapse collapse">
                                    <div class="accordion-body">Delivery times vary based on your location and the chosen
                                        shipping method. Generally, our standard delivery takes up to 5 days, while our
                                        Express Delivery ensures your order reaches you within 1 day. Please note that these
                                        times may be subject to occasional variations due to unforeseen circumstances, but
                                        we do our best to meet these estimates.</div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h3 class="hover-effect-underline accordion-header"><button type="button"
                                        aria-expanded="false" class="accordion-button collapsed"><span class="me-2">What
                                            payment methods do you accept?</span></button></h3>
                                <div class="accordion-collapse collapse">
                                    <div class="accordion-body">We offer a range of secure payment options to provide you
                                        with flexibility and convenience. Accepted methods include major credit/debit cards,
                                        PayPal, and other secure online payment gateways. You can find the complete list of
                                        accepted payment methods during the checkout process.</div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h3 class="hover-effect-underline accordion-header"><button type="button"
                                        aria-expanded="false" class="accordion-button collapsed"><span class="me-2">Do you
                                            ship internationally?</span></button></h3>
                                <div class="accordion-collapse collapse">
                                    <div class="accordion-body">Yes, we proudly offer international shipping to cater to our
                                        global customer base. Shipping costs and delivery times will be automatically
                                        calculated at the checkout based on your selected destination. Please note that any
                                        customs duties or taxes applicable in your country are the responsibility of the
                                        customer.</div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h3 class="hover-effect-underline accordion-header"><button type="button"
                                        aria-expanded="false" class="accordion-button collapsed"><span class="me-2">Do I
                                            need an account to place an order?</span></button></h3>
                                <div class="accordion-collapse collapse">
                                    <div class="accordion-body">While you can place an order as a guest, creating an account
                                        comes with added benefits. By having an account, you can easily track your orders,
                                        manage your preferences, and enjoy a quicker checkout process for future purchases.
                                        It also allows us to provide you with personalized recommendations and exclusive
                                        offers.</div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h3 class="hover-effect-underline accordion-header"><button type="button"
                                        aria-expanded="false" class="accordion-button collapsed"><span class="me-2">How can
                                            I track my order?</span></button></h3>
                                <div class="accordion-collapse collapse">
                                    <div class="accordion-body">Once your order is dispatched, you will receive a
                                        confirmation email containing a unique tracking number. You can use this tracking
                                        number on our website to monitor the real-time status of your shipment.
                                        Additionally, logging into your account will grant you access to a comprehensive
                                        order history, including tracking information.</div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h3 class="hover-effect-underline accordion-header"><button type="button"
                                        aria-expanded="false" class="accordion-button collapsed"><span class="me-2">What are
                                            the product refund conditions?</span></button></h3>
                                <div class="accordion-collapse collapse">
                                    <div class="accordion-body">Our refund policy is designed to ensure customer
                                        satisfaction. Details can be found in our [refund policy page](insert link). In
                                        essence, we accept returns within [insert number] days of receiving the product,
                                        provided it is in its original condition with all tags and packaging intact. Refunds
                                        are processed promptly once the returned item is inspected and approved.</div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h3 class="hover-effect-underline accordion-header"><button type="button"
                                        aria-expanded="false" class="accordion-button collapsed"><span class="me-2">Where
                                            can I find your size guide?</span></button></h3>
                                <div class="accordion-collapse collapse">
                                    <div class="accordion-body">Our comprehensive size guide is conveniently located on each
                                        product page to assist you in choosing the right fit. Additionally, you can find the
                                        size guide in the main menu under "Size Guide." We recommend referring to these
                                        resources to ensure your selected items match your preferred sizing.</div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h3 class="hover-effect-underline accordion-header"><button type="button"
                                        aria-expanded="false" class="accordion-button collapsed"><span class="me-2">Do I
                                            need to create an account to shop with you?</span></button></h3>
                                <div class="accordion-collapse collapse">
                                    <div class="accordion-body">While guest checkout is available for your convenience,
                                        creating an account enhances your overall shopping experience. With an account, you
                                        can easily track your order status, save multiple shipping addresses, and enjoy a
                                        streamlined checkout process. Moreover, account holders receive early access to
                                        promotions and exclusive offers. Signing up is quick and hassle-free!</div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h3 class="hover-effect-underline accordion-header"><button type="button"
                                        aria-expanded="false" class="accordion-button collapsed"><span class="me-2">Is there
                                            a minimum order value for free shipping?</span></button></h3>
                                <div class="accordion-collapse collapse">
                                    <div class="accordion-body">Yes, we offer free shipping on orders exceeding $250. Orders
                                        below this threshold are subject to standard shipping fees, which will be displayed
                                        during the checkout process.</div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h3 class="hover-effect-underline accordion-header"><button type="button"
                                        aria-expanded="false" class="accordion-button collapsed"><span class="me-2">Can I
                                            modify or cancel my order after placing it?</span></button></h3>
                                <div class="accordion-collapse collapse">
                                    <div class="accordion-body">Once an order is confirmed, our system processes it promptly
                                        to ensure timely dispatch. Therefore, modifications or cancellations are challenging
                                        after this point. However, please contact our customer support as soon as possible,
                                        and we will do our best to assist you based on the order status.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection