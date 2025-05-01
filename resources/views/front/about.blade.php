@extends('layouts.app')
@section('content')
    <main class="content-wrapper">
        <div aria-label="breadcrumb" class="pt-3 my-3 my-md-4 container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/home">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">About</li>
            </ol>
        </div>
        <section class="container">
            <div class="row">
                <div class="order-md-2 mb-4 mb-md-0 col-md-7">
                    <div class="position-relative h-100">
                        <div class="ratio ratio-16x9"></div><img alt="Image" decoding="async" data-nimg="fill"
                            class="object-fit-cover rounded-5" sizes="1000px"
                            srcset="/_next/image?url=%2Fimg%2Fabout%2Fv1%2Fhero.jpg&amp;w=16&amp;q=75 16w, /_next/image?url=%2Fimg%2Fabout%2Fv1%2Fhero.jpg&amp;w=32&amp;q=75 32w, /_next/image?url=%2Fimg%2Fabout%2Fv1%2Fhero.jpg&amp;w=48&amp;q=75 48w, /_next/image?url=%2Fimg%2Fabout%2Fv1%2Fhero.jpg&amp;w=64&amp;q=75 64w, /_next/image?url=%2Fimg%2Fabout%2Fv1%2Fhero.jpg&amp;w=96&amp;q=75 96w, /_next/image?url=%2Fimg%2Fabout%2Fv1%2Fhero.jpg&amp;w=128&amp;q=75 128w, /_next/image?url=%2Fimg%2Fabout%2Fv1%2Fhero.jpg&amp;w=256&amp;q=75 256w, /_next/image?url=%2Fimg%2Fabout%2Fv1%2Fhero.jpg&amp;w=384&amp;q=75 384w, /_next/image?url=%2Fimg%2Fabout%2Fv1%2Fhero.jpg&amp;w=640&amp;q=75 640w, /_next/image?url=%2Fimg%2Fabout%2Fv1%2Fhero.jpg&amp;w=750&amp;q=75 750w, /_next/image?url=%2Fimg%2Fabout%2Fv1%2Fhero.jpg&amp;w=828&amp;q=75 828w, /_next/image?url=%2Fimg%2Fabout%2Fv1%2Fhero.jpg&amp;w=1080&amp;q=75 1080w, /_next/image?url=%2Fimg%2Fabout%2Fv1%2Fhero.jpg&amp;w=1200&amp;q=75 1200w, /_next/image?url=%2Fimg%2Fabout%2Fv1%2Fhero.jpg&amp;w=1920&amp;q=75 1920w, /_next/image?url=%2Fimg%2Fabout%2Fv1%2Fhero.jpg&amp;w=2048&amp;q=75 2048w, /_next/image?url=%2Fimg%2Fabout%2Fv1%2Fhero.jpg&amp;w=3840&amp;q=75 3840w"
                            src="/_next/image?url=%2Fimg%2Fabout%2Fv1%2Fhero.jpg&amp;w=3840&amp;q=75"
                            style="position: absolute; height: 100%; width: 100%; inset: 0px; color: transparent;">
                    </div>
                </div>
                <div class="order-md-1 col-md-5">
                    <div class="position-relative py-5 px-4 px-sm-5"><span
                            class="position-absolute top-0 start-0 w-100 h-100 rounded-5 d-none-dark rtl-flip"
                            style="background: linear-gradient(-90deg, rgb(172, 203, 238) 0%, rgb(231, 240, 253) 100%);"></span><span
                            class="position-absolute top-0 start-0 w-100 h-100 rounded-5 d-none d-block-dark rtl-flip"
                            style="background: linear-gradient(-90deg, rgb(27, 39, 58) 0%, rgb(31, 38, 50) 100%);"></span>
                        <div class="position-relative z-1 py-md-2 py-lg-4 py-xl-5 px-xl-2 px-xxl-4 my-xxl-3">
                            <h1 class="pb-1 pb-md-2 pb-lg-3">Cartzilla - More than a retailer</h1>
                            <p class="text-dark-emphasis pb-sm-2 pb-lg-0 mb-4 mb-lg-5">Since 2015, we have been fulfilling
                                the small dreams and big plans of millions of people. You can find literally everything
                                here.</p><a role="button" tabindex="0" href="#mission"
                                class="animate-slide-down btn btn-outline-dark btn-lg">Learn more<i
                                    class="ci-arrow-down fs-lg animate-target ms-2 me-n1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-5 mt-md-2 mt-lg-4 container">
            <div class="g-4 row row-cols-md-4 row-cols-2">
                <div class="text-center col">
                    <div class="display-4 text-dark-emphasis mb-2">14k</div>
                    <p class="fs-sm mb-0">products available for purchase</p>
                </div>
                <div class="text-center col">
                    <div class="display-4 text-dark-emphasis mb-2">120m</div>
                    <p class="fs-sm mb-0">users visited site from 2015</p>
                </div>
                <div class="text-center col">
                    <div class="display-4 text-dark-emphasis mb-2">800+</div>
                    <p class="fs-sm mb-0">employees around the world</p>
                </div>
                <div class="text-center col">
                    <div class="display-4 text-dark-emphasis mb-2">92%</div>
                    <p class="fs-sm mb-0">of our customers return</p>
                </div>
            </div>
        </section>
        <section id="mission" class="pt-3 pt-sm-4 pt-lg-5 mt-lg-2 mt-xl-4 mt-xxl-5 container"
            style="scroll-margin-top: 60px;">
            <div class="text-center mx-auto" style="max-width: 690px;">
                <h2 class="text-body fs-sm fw-normal">Mission</h2>
                <h3 class="h1 pb-2 pb-md-3 mx-auto" style="max-width: 400px;">The best products at fair prices</h3>
                <p class="fs-xl pb-2 pb-md-3 pb-lg-4">"We believe that things exist to make life easier, more pleasant and
                    kinder. That's why the search for the right thing should be quick, convenient and enjoyable. We do not
                    just sell household appliances and electronics, but comfort and accessibility."</p>
                <div class="d-inline-flex mb-3" style="width: 64px;"><img alt="Avatar" loading="lazy" width="128"
                        height="128" decoding="async" data-nimg="1" class="rounded-circle"
                        srcset="/_next/image?url=%2Fimg%2Fabout%2Fv1%2Favatar.jpg&amp;w=128&amp;q=75 1x, /_next/image?url=%2Fimg%2Fabout%2Fv1%2Favatar.jpg&amp;w=256&amp;q=75 2x"
                        src="/_next/image?url=%2Fimg%2Fabout%2Fv1%2Favatar.jpg&amp;w=256&amp;q=75"
                        style="color: transparent;"></div>
                <h6 class="mb-0">William Lacker, Cartzilla CEO</h6>
            </div>
        </section>
        <section class="pt-5 container">
            <div class="pt-2 pt-sm-3 pt-md-4 pt-lg-5 row">
                <div class="pb-1 pb-sm-2 pb-md-0 mb-4 mb-md-0 col-lg-6 col-md-5"><img alt="Image" loading="lazy" width="954"
                        height="954" decoding="async" data-nimg="1" class="rounded-5"
                        srcset="/_next/image?url=%2Fimg%2Fabout%2Fv1%2Fdelivery.jpg&amp;w=1080&amp;q=75 1x, /_next/image?url=%2Fimg%2Fabout%2Fv1%2Fdelivery.jpg&amp;w=1920&amp;q=75 2x"
                        src="/_next/image?url=%2Fimg%2Fabout%2Fv1%2Fdelivery.jpg&amp;w=1920&amp;q=75"
                        style="color: transparent;"></div>
                <div class="pt-md-3 pt-xl-4 pt-xxl-5 col-lg-6 col-md-7">
                    <div class="ps-md-3 ps-lg-4 ps-xl-5 ms-xxl-4">
                        <h2 class="text-body fs-sm fw-normal">Principles</h2>
                        <h3 class="h1 pb-1 pb-sm-2 pb-lg-3">The main principles that will allow us to grow</h3>
                        <p class="pb-xl-3">In the Philippines, the ecommerce landscape is rapidly evolving, presenting a world of opportunity for both consumers and businesses alike. Trustworthiness in online shopping is paramount, and we have stepped up to ensure safe and secure transactions. With rigorous customer feedback systems and transparent policies, we continue to build on our reputation that fosters consumer confidence. 
                            Our commitment to continuous improvement is evident, and as such we regularly update our services based on user experiences and market trends. 
                            For instance, enhanced payment methods and user-friendly interfaces are being integrated to streamline the shopping process. 
                            As a result, customers can enjoy a seamless experience while supporting local enterprises. 
                            This growing emphasis on reliability and innovation not only reinforces trust in online shopping 
                            but also strengthens the overall economy, proving that ecommerce in the Philippines is not just a trend, 
                            but a vital component of modern commerce that is here to stay.</p>
                        <div class="accordion-alt-icon accordion">
                            <div class="accordion-item">
                                <h3 class="animate-underline accordion-header"><button type="button" aria-expanded="true"
                                        class="accordion-button"><span class="animate-target me-2">Customer
                                            focus</span></button></h3>
                                <div class="accordion-collapse collapse show">
                                    <div class="accordion-body">We prioritize understanding and anticipating our customers'
                                        needs, delivering an exceptional and personalized experience from start to finish.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h3 class="animate-underline accordion-header"><button type="button" aria-expanded="false"
                                        class="accordion-button collapsed"><span class="animate-target me-2">Betting on
                                            reputation</span></button></h3>
                                <div class="accordion-collapse collapse">
                                    <div class="accordion-body">We value a solid reputation built on integrity,
                                        transparency, and quality - ensuring our customers trust and rely on our brand.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h3 class="animate-underline accordion-header"><button type="button" aria-expanded="false"
                                        class="accordion-button collapsed"><span class="animate-target me-2">Fast,
                                            convenient and enjoyable</span></button></h3>
                                <div class="accordion-collapse collapse">
                                    <div class="accordion-body">We've streamlined our process for speed, convenience, and an
                                        enjoyable shopping experience, redefining online standards for our delighted
                                        customers.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="container-start pt-5">
            <div class="align-items-center g-0 pt-2 pt-sm-3 pt-md-4 pt-lg-5 row">
                <div class="pb-1 pb-md-0 pe-3 ps-md-0 mb-4 mb-md-0 col-lg-3 col-md-4">
                    <div class="d-flex flex-md-column align-items-end align-items-md-start">
                        <div class="mb-md-5 me-3 me-md-0">
                            <h2 class="text-body fs-sm fw-normal">Values</h2>
                            <h3 class="h1 mb-0">Simple values to achieve goals</h3>
                        </div>
                        <div class="hstack gap-2"><button type="button" id="prev-values" aria-label="Prev"
                                class="btn-icon animate-slide-start rounded-circle me-1 btn btn-outline-secondary"><i
                                    class="ci-chevron-left fs-lg animate-target"></i></button><button type="button"
                                id="next-values" aria-label="Next"
                                class="btn-icon animate-slide-end rounded-circle btn btn-outline-secondary"><i
                                    class="ci-chevron-right fs-lg animate-target"></i></button></div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-8">
                    <div class="ps-md-4 ps-lg-5">
                        <div class="swiper swiper-initialized swiper-horizontal swiper-backface-hidden">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide swiper-slide-active w-auto h-auto" data-swiper-slide-index="0"
                                    style="margin-right: 24px;">
                                    <div class="h-100 rounded-4 px-3 card" style="max-width: 306px;">
                                        <div class="py-5 px-3 card-body">
                                            <div class="h4 h5 d-flex align-items-center"><i
                                                    class="ci-user-plus fs-4 me-3"></i>People</div>
                                            <p class="mb-0">The most important value of the Company is people (employees,
                                                partners, clients). Behind any success there is, first and foremost, a
                                                specific person. It is he who creates the product, technology, and
                                                innovation.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide swiper-slide-next w-auto h-auto" data-swiper-slide-index="1"
                                    style="margin-right: 24px;">
                                    <div class="h-100 rounded-4 px-3 card" style="max-width: 306px;">
                                        <div class="py-5 px-3 card-body">
                                            <div class="h4 h5 d-flex align-items-center"><i
                                                    class="ci-shopping-bag fs-4 me-3"></i>Service</div>
                                            <p class="mb-0">Care, attention, desire and ability to be helpful (to a
                                                colleague in his department, other departments, clients, customers and all
                                                other people who surround us).</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide w-auto h-auto" data-swiper-slide-index="2"
                                    style="margin-right: 24px;">
                                    <div class="h-100 rounded-4 px-3 card" style="max-width: 306px;">
                                        <div class="py-5 px-3 card-body">
                                            <div class="h4 h5 d-flex align-items-center"><i
                                                    class="ci-trending-up fs-4 me-3"></i>Responsibility</div>
                                            <p class="mb-0">Responsibility is our key quality. We don't shift it to external
                                                circumstances or other people. If we see something that could be improved,
                                                we don't just criticize, but offer our own options.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide w-auto h-auto" data-swiper-slide-index="3"
                                    style="margin-right: 24px;">
                                    <div class="h-100 rounded-4 px-3 card" style="max-width: 306px;">
                                        <div class="py-5 px-3 card-body">
                                            <div class="h4 h5 d-flex align-items-center"><i
                                                    class="ci-rocket fs-4 me-3"></i>Innovation</div>
                                            <p class="mb-0">We foster a culture of continuous improvement and innovation.
                                                Embracing change and staying ahead of the curve are essential for our
                                                success. We encourage creative thinking, experimentation, and the pursuit of
                                                new ideas.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide w-auto h-auto" data-swiper-slide-index="4"
                                    style="margin-right: 24px;">
                                    <div class="h-100 rounded-4 px-3 card" style="max-width: 306px;">
                                        <div class="py-5 px-3 card-body">
                                            <div class="h4 h5 d-flex align-items-center"><i
                                                    class="ci-star fs-4 me-3"></i>Leadership</div>
                                            <p class="mb-0">Cartzilla people are young, ambitious and energetic individuals.
                                                With identified leadership qualities, with a desire to be the best at what
                                                they do.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide w-auto h-auto" data-swiper-slide-index="5"
                                    style="margin-right: 24px;">
                                    <div class="h-100 rounded-4 px-3 card" style="max-width: 306px;">
                                        <div class="py-5 px-3 card-body">
                                            <div class="h4 h5 d-flex align-items-center"><i
                                                    class="ci-leaf fs-4 me-3"></i>Sustainability</div>
                                            <p class="mb-0">We are committed to minimizing our environmental impact and
                                                promoting sustainable practices. From responsible sourcing to eco-friendly
                                                packaging, we aim to make a positive contribution to the well-being of our
                                                planet.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="pt-5 mt-2 mt-sm-3 mt-md-4 mt-lg-5 container">
            <div class="g-4 row row-cols-md-2 row-cols-1">
                <div class="col">
                    <div class="position-relative h-100">
                        <div class="ratio ratio-16x9"></div><img alt="Image" loading="lazy" decoding="async"
                            data-nimg="fill" class="object-fit-cover rounded-5" sizes="(max-width: 768px) 100vw, 50vw"
                            srcset="/_next/image?url=%2Fimg%2Fabout%2Fv1%2Fvideo-cover.jpg&amp;w=384&amp;q=75 384w, /_next/image?url=%2Fimg%2Fabout%2Fv1%2Fvideo-cover.jpg&amp;w=640&amp;q=75 640w, /_next/image?url=%2Fimg%2Fabout%2Fv1%2Fvideo-cover.jpg&amp;w=750&amp;q=75 750w, /_next/image?url=%2Fimg%2Fabout%2Fv1%2Fvideo-cover.jpg&amp;w=828&amp;q=75 828w, /_next/image?url=%2Fimg%2Fabout%2Fv1%2Fvideo-cover.jpg&amp;w=1080&amp;q=75 1080w, /_next/image?url=%2Fimg%2Fabout%2Fv1%2Fvideo-cover.jpg&amp;w=1200&amp;q=75 1200w, /_next/image?url=%2Fimg%2Fabout%2Fv1%2Fvideo-cover.jpg&amp;w=1920&amp;q=75 1920w, /_next/image?url=%2Fimg%2Fabout%2Fv1%2Fvideo-cover.jpg&amp;w=2048&amp;q=75 2048w, /_next/image?url=%2Fimg%2Fabout%2Fv1%2Fvideo-cover.jpg&amp;w=3840&amp;q=75 3840w"
                            src="/_next/image?url=%2Fimg%2Fabout%2Fv1%2Fvideo-cover.jpg&amp;w=3840&amp;q=75"
                            style="position: absolute; height: 100%; width: 100%; inset: 0px; color: transparent;">
                        <div class="position-absolute start-0 bottom-0 d-flex align-items-end w-100 h-100 z-2 p-4"><a
                                class="btn btn-lg btn-light rounded-pill m-md-2"
                                href="https://www.youtube.com/watch?v=Sqqj_14wBxU" data-prevent-progress="true"
                                data-glightbox="" data-gallery="video"><i class="ci-play fs-lg ms-n1 me-2"></i>Play</a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="bg-body-tertiary rounded-5 py-5 px-4 px-sm-5">
                        <div class="py-md-3 py-lg-4 py-xl-5 px-lg-4 px-xl-5 my-lg-2 my-xl-4 my-xxl-5">
                            <h2 class="h3 pb-sm-1 pb-lg-2">The role of philanthropy in building a better world</h2>
                            <p class="pb-sm-2 pb-lg-0 mb-4 mb-lg-5">Charitable contributions are a vital aspect of building
                                a better world. These contributions come in various forms, including monetary donations...
                            </p><a class="btn btn-lg btn-outline-dark" href="#">Learn more</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-5 mt-2 mb-1 my-sm-3 my-md-4 my-lg-5 container">
            <div class="d-flex align-items-end justify-content-between pb-3 mb-1 mb-md-3">
                <div class="me-4">
                    <h2 class="text-body fs-sm fw-normal">Career</h2>
                    <h3 class="h1 mb-0">Open positions</h3>
                </div>
                <div class="hstack gap-2"><button type="button" id="prev-positions" aria-label="Prev"
                        class="btn-icon animate-slide-start rounded-circle me-1 btn btn-outline-secondary"><i
                            class="ci-chevron-left fs-lg animate-target"></i></button><button type="button"
                        id="next-positions" aria-label="Next"
                        class="btn-icon animate-slide-end rounded-circle btn btn-outline-secondary"><i
                            class="ci-chevron-right fs-lg animate-target"></i></button></div>
            </div>
            <div class="swiper swiper-initialized swiper-horizontal py-2 swiper-backface-hidden">
                <div class="swiper-wrapper">
                    <div class="swiper-slide swiper-slide-active h-auto" data-swiper-slide-index="0"
                        style="width: 306px; margin-right: 24px;"><a
                            class="btn btn-outline-secondary w-100 h-100 align-items-start text-wrap text-start rounded-4 px-0 px-xl-2 py-4 py-xl-5 card"
                            href="#">
                            <div class="pb-0 pt-3 pt-xl-0 card-body"><span class="fs-xs badge rounded-pill bg-info">Full
                                    time</span>
                                <h4 class="h5 py-3 my-2 my-xl-3">Supply Chain and Logistics Coordinator</h4>
                            </div>
                            <div
                                class="w-100 bg-transparent border-0 text-body fs-sm fw-normal pt-0 pb-3 pb-xl-0 card-footer">
                                New York</div>
                        </a></div>
                    <div class="swiper-slide swiper-slide-next h-auto" data-swiper-slide-index="1"
                        style="width: 306px; margin-right: 24px;"><a
                            class="btn btn-outline-secondary w-100 h-100 align-items-start text-wrap text-start rounded-4 px-0 px-xl-2 py-4 py-xl-5 card"
                            href="#">
                            <div class="pb-0 pt-3 pt-xl-0 card-body"><span class="fs-xs badge rounded-pill bg-success">Part
                                    time</span>
                                <h4 class="h5 py-3 my-2 my-xl-3">Content Manager for Social Networks</h4>
                            </div>
                            <div
                                class="w-100 bg-transparent border-0 text-body fs-sm fw-normal pt-0 pb-3 pb-xl-0 card-footer">
                                Remote</div>
                        </a></div>
                    <div class="swiper-slide h-auto" data-swiper-slide-index="2" style="width: 306px; margin-right: 24px;">
                        <a class="btn btn-outline-secondary w-100 h-100 align-items-start text-wrap text-start rounded-4 px-0 px-xl-2 py-4 py-xl-5 card"
                            href="#">
                            <div class="pb-0 pt-3 pt-xl-0 card-body"><span class="fs-xs badge rounded-pill bg-info">Full
                                    time</span>
                                <h4 class="h5 py-3 my-2 my-xl-3">Customer Service Representative</h4>
                            </div>
                            <div
                                class="w-100 bg-transparent border-0 text-body fs-sm fw-normal pt-0 pb-3 pb-xl-0 card-footer">
                                London</div>
                        </a>
                    </div>
                    <div class="swiper-slide h-auto" data-swiper-slide-index="3" style="width: 306px; margin-right: 24px;">
                        <a class="btn btn-outline-secondary w-100 h-100 align-items-start text-wrap text-start rounded-4 px-0 px-xl-2 py-4 py-xl-5 card"
                            href="#">
                            <div class="pb-0 pt-3 pt-xl-0 card-body"><span
                                    class="fs-xs badge rounded-pill bg-warning">Freelance</span>
                                <h4 class="h5 py-3 my-2 my-xl-3">Data Analyst/Analytics Specialist</h4>
                            </div>
                            <div
                                class="w-100 bg-transparent border-0 text-body fs-sm fw-normal pt-0 pb-3 pb-xl-0 card-footer">
                                Remote</div>
                        </a>
                    </div>
                    <div class="swiper-slide h-auto" data-swiper-slide-index="4" style="width: 306px; margin-right: 24px;">
                        <a class="btn btn-outline-secondary w-100 h-100 align-items-start text-wrap text-start rounded-4 px-0 px-xl-2 py-4 py-xl-5 card"
                            href="#">
                            <div class="pb-0 pt-3 pt-xl-0 card-body"><span class="fs-xs badge rounded-pill bg-info">Full
                                    time</span>
                                <h4 class="h5 py-3 my-2 my-xl-3">E-commerce Manager/Director</h4>
                            </div>
                            <div
                                class="w-100 bg-transparent border-0 text-body fs-sm fw-normal pt-0 pb-3 pb-xl-0 card-footer">
                                In house</div>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        {{-- <section class="bg-body-tertiary py-5"> --}}
            {{-- <div class="pt-sm-2 pt-md-3 pt-lg-4 pt-xl-5 container">
                <div class="row">
                    <div class="mb-5 mb-md-0 col-lg-5 col-md-6">
                        <h2 class="h4 mb-2">Sign up to our newsletter</h2>
                        <p class="text-body pb-2 pb-ms-3">Receive our latest updates about our products &amp; promotions</p>
                        <form novalidate="" class="d-flex pb-1 pb-sm-2 pb-md-3 pb-lg-0 mb-4 mb-lg-5"><input
                                placeholder="Your email" required="" class="w-100 me-2 form-control form-control-lg"
                                type="email"><button type="submit" class="btn btn-primary btn-lg">Subscribe</button></form>
                        <div class="d-flex gap-3"><a role="button" tabindex="0" href="#" aria-label="Follow us on Instagram"
                                class="btn-icon rounded-circle btn btn-secondary"><i class="ci-instagram fs-base"></i></a><a
                                role="button" tabindex="0" href="#" aria-label="Follow us on Facebook"
                                class="btn-icon rounded-circle btn btn-secondary"><i class="ci-facebook fs-base"></i></a><a
                                role="button" tabindex="0" href="#" aria-label="Follow us on YouTube"
                                class="btn-icon rounded-circle btn btn-secondary"><i class="ci-youtube fs-base"></i></a><a
                                role="button" tabindex="0" href="#" aria-label="Follow us on Telegram"
                                class="btn-icon rounded-circle btn btn-secondary"><i class="ci-telegram fs-base"></i></a>
                        </div>
                    </div>
                    <div class="offset-lg-1 offset-xl-2 col-xl-4 col-lg-5 col-md-6">
                        <ul class="list-unstyled d-flex flex-column gap-4 ps-md-4 ps-lg-0 mb-3">
                            <li class="flex-nowrap align-items-center position-relative nav">
                                <div class="flex-shrink-0" style="width: 140px;"><img alt="Cover image" loading="lazy"
                                        width="280" height="172" decoding="async" data-nimg="1" class="rounded"
                                        srcset="/_next/image?url=%2Fimg%2Fhome%2Felectronics%2Fvlog%2F01.jpg&amp;w=384&amp;q=75 1x, /_next/image?url=%2Fimg%2Fhome%2Felectronics%2Fvlog%2F01.jpg&amp;w=640&amp;q=75 2x"
                                        src="/_next/image?url=%2Fimg%2Fhome%2Felectronics%2Fvlog%2F01.jpg&amp;w=640&amp;q=75"
                                        style="color: transparent;"></div>
                                <div class="ps-3">
                                    <div class="fs-xs text-body-secondary lh-sm mb-2">6:16</div><a data-rr-ui-event-key="#"
                                        class="fs-sm hover-effect-underline stretched-link p-0 nav-link" href="#">5 New Cool
                                        Gadgets You Must See on Cartzilla - Cheap Budget</a>
                                </div>
                            </li>
                            <li class="flex-nowrap align-items-center position-relative nav">
                                <div class="flex-shrink-0" style="width: 140px;"><img alt="Cover image" loading="lazy"
                                        width="280" height="172" decoding="async" data-nimg="1" class="rounded"
                                        srcset="/_next/image?url=%2Fimg%2Fhome%2Felectronics%2Fvlog%2F02.jpg&amp;w=384&amp;q=75 1x, /_next/image?url=%2Fimg%2Fhome%2Felectronics%2Fvlog%2F02.jpg&amp;w=640&amp;q=75 2x"
                                        src="/_next/image?url=%2Fimg%2Fhome%2Felectronics%2Fvlog%2F02.jpg&amp;w=640&amp;q=75"
                                        style="color: transparent;"></div>
                                <div class="ps-3">
                                    <div class="fs-xs text-body-secondary lh-sm mb-2">10:20</div><a data-rr-ui-event-key="#"
                                        class="fs-sm hover-effect-underline stretched-link p-0 nav-link" href="#">5 Super
                                        Useful Gadgets on Cartzilla You Must Have in 2025</a>
                                </div>
                            </li>
                            <li class="flex-nowrap align-items-center position-relative nav">
                                <div class="flex-shrink-0" style="width: 140px;"><img alt="Cover image" loading="lazy"
                                        width="280" height="172" decoding="async" data-nimg="1" class="rounded"
                                        srcset="/_next/image?url=%2Fimg%2Fhome%2Felectronics%2Fvlog%2F03.jpg&amp;w=384&amp;q=75 1x, /_next/image?url=%2Fimg%2Fhome%2Felectronics%2Fvlog%2F03.jpg&amp;w=640&amp;q=75 2x"
                                        src="/_next/image?url=%2Fimg%2Fhome%2Felectronics%2Fvlog%2F03.jpg&amp;w=640&amp;q=75"
                                        style="color: transparent;"></div>
                                <div class="ps-3">
                                    <div class="fs-xs text-body-secondary lh-sm mb-2">8:40</div><a data-rr-ui-event-key="#"
                                        class="fs-sm hover-effect-underline stretched-link p-0 nav-link" href="#">Top 5 New
                                        Amazing Gadgets on Cartzilla You Must See</a>
                                </div>
                            </li>
                        </ul>
                        <div class="ps-md-4 ps-lg-0 nav"><a data-rr-ui-event-key="#"
                                class="btn animate-underline text-decoration-none px-0 nav-link" href="#"><span
                                    class="animate-target">View all</span><i class="ci-chevron-right fs-base ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div> --}}
        {{-- </section> --}}
    </main>
@endsection