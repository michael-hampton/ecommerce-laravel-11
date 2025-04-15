<footer class="footer pb-4">
    <div class="container pb-md-3">

        <!-- Features -->
{{--        <div class="border-bottom py-5">--}}
{{--            <div class="row row-cols-2 row-cols-md-4 g-4 gx-sm-5 py-sm-1 py-md-2 py-lg-3 mb-n2 mb-md-0">--}}
{{--                <div class="col mb-2 mb-md-0">--}}
{{--                    <i class="ci-layers-2 fs-xl text-dark-emphasis mb-3"></i>--}}
{{--                    <h6 class="pb-2 mb-1">Regularly updated content</h6>--}}
{{--                    <p class="fs-sm text-body mb-0">Stay ahead of trends, always having fresh and modern assets.</p>--}}
{{--                </div>--}}
{{--                <div class="col mb-2 mb-md-0">--}}
{{--                    <i class="ci-click fs-xl text-dark-emphasis mb-3"></i>--}}
{{--                    <h6 class="pb-2 mb-1">Subscription-based access</h6>--}}
{{--                    <p class="fs-sm text-body mb-0">Find everything you need in one place, saving time and effort.</p>--}}
{{--                </div>--}}
{{--                <div class="col mb-2 mb-md-0">--}}
{{--                    <i class="ci-grid-2 fs-xl text-dark-emphasis mb-3"></i>--}}
{{--                    <h6 class="pb-2 mb-1">Exclusive collections</h6>--}}
{{--                    <p class="fs-sm text-body mb-0">Partner with renowned designers and artists to create exclusive collections.</p>--}}
{{--                </div>--}}
{{--                <div class="col mb-2 mb-md-0">--}}
{{--                    <i class="ci-check-search fs-xl text-dark-emphasis mb-3"></i>--}}
{{--                    <h6 class="pb-2 mb-1">User-friendly search </h6>--}}
{{--                    <p class="fs-sm text-body mb-0">Spend less time searching and more time creating.</p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

        <!-- Subscription + Links -->
        <div class="py-5">
            <div class="row py-sm-1 py-md-2 py-lg-3">

                <!-- Subscription + Social buttons -->
                <div class="col-lg-5 mb-4 mb-sm-5 mb-lg-0">
                    <h6 class="mb-4">Join our newsletter, get discounts 🔥</h6>
                    <form class="needs-validation d-flex gap-2 pb-sm-2 pb-lg-0 mb-4 mb-lg-5" novalidate="">
                        <input type="email" class="form-control form-control-lg w-100 rounded-pill" placeholder="Your email" style="max-width: 340px" required="">
                        <button type="submit" class="btn btn-lg btn-primary rounded-pill">Subscribe</button>
                    </form>
                    <div class="d-flex gap-3">
                        <a class="btn btn-icon btn-secondary rounded-circle" href="#!" aria-label="Instagram">
                            <i class="fa fa-instagram fs-base"></i>
                        </a>
                        <a class="btn btn-icon btn-secondary rounded-circle" href="#!" aria-label="Facebook">
                            <i class="fa fa-facebook fs-base"></i>
                        </a>
                        <a class="btn btn-icon btn-secondary rounded-circle" href="#!" aria-label="YouTube">
                            <i class="fa fa-youtube fs-base"></i>
                        </a>
                        <a class="btn btn-icon btn-secondary rounded-circle" href="#!" aria-label="Telegram">
                            <i class="fa fa-twitter fs-base"></i>
                        </a>
                    </div>
                </div>

                <!-- Columns with links that are turned into accordion on screens < 500px wide (sm breakpoint) -->
                <div class="col-lg-7">
                    <div class="accordion ps-lg-4" id="footerLinks">
                        <div class="row">
                            <div class="accordion-item col-sm-4 border-0">
                                <h6 class="accordion-header" id="categoriesHeading">
                                    <span class="text-dark-emphasis d-none d-sm-block">Company</span>
                                    <button type="button" class="accordion-button collapsed py-3 d-sm-none" data-bs-toggle="collapse" data-bs-target="#categoriesLinks" aria-expanded="false" aria-controls="categoriesLinks">Categories</button>
                                </h6>
                                <div class="accordion-collapse collapse d-sm-block" id="categoriesLinks" aria-labelledby="categoriesHeading" data-bs-parent="#footerLinks">
                                    <ul class="nav flex-column gap-2 pt-sm-3 pb-3 pb-sm-0 mt-n1 mb-1 mb-sm-0">
                                        <li class="d-flex w-100 pt-1">
                                            <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">About Us</a>
                                        </li>
                                        <li class="d-flex w-100 pt-1">
                                            <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Careers</a>
                                        </li>
                                        <li class="d-flex w-100 pt-1">
                                            <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Blog</a>
                                        </li>
                                        <li class="d-flex w-100 pt-1">
                                            <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Contact Us</a>
                                        </li>
                                    </ul>
                                </div>
                                <hr class="d-sm-none my-0">
                            </div>
                            <div class="accordion-item col-sm-4 border-0">
                                <h6 class="accordion-header" id="membersHeading">
                                    <span class="text-dark-emphasis d-none d-sm-block">Categories</span>
                                    <button type="button" class="accordion-button collapsed py-3 d-sm-none" data-bs-toggle="collapse" data-bs-target="#membersLinks" aria-expanded="false" aria-controls="membersLinks">For members</button>
                                </h6>
                                <div class="accordion-collapse collapse d-sm-block" id="membersLinks" aria-labelledby="membersHeading" data-bs-parent="#footerLinks">
                                    <ul class="nav flex-column gap-2 pt-sm-3 pb-3 pb-sm-0 mt-n1 mb-1 mb-sm-0">
                                        @foreach(\App\Models\Category::all()->where('parent_id', 0) as $category)
                                        <li class="d-flex w-100 pt-1">
                                            <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="{{route('shop.index', ['categoryId' => $category->id])}}">{{$category->name}}</a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <hr class="d-sm-none my-0">
                            </div>
                            <div class="accordion-item col-sm-4 border-0">
                                <h6 class="accordion-header" id="supportHeading">
                                    <span class="text-dark-emphasis d-none d-sm-block">Support</span>
                                    <button type="button" class="accordion-button collapsed py-3 d-sm-none" data-bs-toggle="collapse" data-bs-target="#supportLinks" aria-expanded="false" aria-controls="supportLinks">Support</button>
                                </h6>
                                <div class="accordion-collapse collapse d-sm-block" id="supportLinks" aria-labelledby="supportHeading" data-bs-parent="#footerLinks">
                                    <ul class="nav flex-column gap-2 pt-sm-3 pb-3 pb-sm-0 mt-n1 mb-1 mb-sm-0">
                                        <li class="d-flex w-100 pt-1">
                                            <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">FAQs</a>
                                        </li>
                                        <li class="d-flex w-100 pt-1">
                                            <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Search guide</a>
                                        </li>
                                        <li class="d-flex w-100 pt-1">
                                            <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Contact</a>
                                        </li>
                                    </ul>
                                </div>
                                <hr class="d-sm-none my-0">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <p class="fs-xs text-body text-center text-lg-start mb-0">
            © All rights reserved. Made with <i class="ci-heart-filled align-middle"></i> by <span class="animate-underline"><a class="animate-target text-white text-decoration-none" href="https://createx.studio/" target="_blank" rel="noreferrer">Createx Studio</a></span>
        </p>
    </div>
</footer>
