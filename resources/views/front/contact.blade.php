@extends('layouts.app')
@section('content')

    <main class="content-wrapper">
        <div class="py-5 mb-2 mb-sm-3 mb-md-4 mb-lg-5 mt-lg-3 mt-xl-4 container">
            <h1 class="text-center">Contact us</h1>
            <p class="text-center pb-2 pb-sm-3">Fill out the form below and we will reply as soon as we can</p>
            @if(Session::has('success'))
                <div class="alert alert-success">
                    {{Session::get('success')}}
                </div>
            @endif
            <section class="g-0 overflow-hidden rounded-5 row row-cols-md-2 row-cols-1">
                <div class="bg-body-tertiary py-5 px-4 px-xl-5 col">
                    <form method="POST" class="py-md-2 px-md-1 px-lg-3 mx-lg-3" action="{{ route('contact.store') }}"
                        id="contactUSForm">
                        {{ csrf_field() }}
                        <div class="position-relative mb-4">
                            <label class="form-label" for="name">Name *</label>
                            <input required="" id="name" name="name" class="rounded-pill form-control form-control-lg"
                                type="text" value="{{ old('name') }}">
                            @if ($errors->has('name'))
                                <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                        <div class="position-relative mb-4"><label class="form-label" for="email">Email *</label><input
                                required="" id="email" name="email" class="rounded-pill form-control form-control-lg"
                                type="email" value="{{ old('email') }}">
                            @if ($errors->has('email'))
                                <div class="invalid-ffedback">{{ $errors->first('email') }}</div>
                            @endif
                        </div>
                        <div class="position-relative mb-4"><label class="form-label" for="email">Phone *</label><input
                                required="" id="phone" name="phone" class="rounded-pill form-control form-control-lg"
                                type="text" value="{{ old('phone') }}">
                            @if ($errors->has('phone'))
                                <div class="invalid-ffedback">{{ $errors->first('phone') }}</div>
                            @endif
                        </div>
                        <div class="position-relative mb-4"><label class="form-label">Subject *</label>
                            <div aria-label="Subject select">
                                <div class="choices" data-type="select-one" tabindex="0" role="listbox" aria-haspopup="true"
                                    aria-expanded="false">
                                    <div class="form-select">
                                        <select name="subject"
                                            class="form-select form-select-lg rounded-pill choices__input" required="">
                                            <option value="" selected="">Select subject</option>
                                            <option value="General inquiry">General inquiry</option>
                                            <option value="Order status">Order status</option>
                                            <option value="Product information">Product information</option>
                                            <option value="Technical support">Technical support</option>
                                            <option value="Website feedback">Website feedback</option>
                                            <option value="Account assistance">Account assistance</option>
                                            <option value="Security concerns">Security concerns</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @if ($errors->has('subject'))
                                <span class="invalid-feedback">{{ $errors->first('subject') }}</span>
                            @endif
                        </div>
                </div>
                <div class="position-relative mb-4">
                    <label class="form-label" for="message">Message*</label>
                    <textarea rows="5" required="" id="message" name="message"
                        class="rounded-6 form-control form-control-lg"></textarea>
                    @if ($errors->has('message'))
                        <span class="invalid-feedback">{{ $errors->first('message') }}</span>
                    @endif
                </div>
                <div class="pt-2">
                    <button type="submit" class="rounded-pill btn btn-dark btn-lg">Send message</button>
                </div>
                </form>
        </div>
        <div class="position-relative col"><img alt="Image" decoding="async" data-nimg="fill" class="object-fit-cover"
                sizes="972px"
                srcset="/_next/image?url=%2Fimg%2Fcontact%2Fform-image.jpg&amp;w=16&amp;q=75 16w, /_next/image?url=%2Fimg%2Fcontact%2Fform-image.jpg&amp;w=32&amp;q=75 32w, /_next/image?url=%2Fimg%2Fcontact%2Fform-image.jpg&amp;w=48&amp;q=75 48w, /_next/image?url=%2Fimg%2Fcontact%2Fform-image.jpg&amp;w=64&amp;q=75 64w, /_next/image?url=%2Fimg%2Fcontact%2Fform-image.jpg&amp;w=96&amp;q=75 96w, /_next/image?url=%2Fimg%2Fcontact%2Fform-image.jpg&amp;w=128&amp;q=75 128w, /_next/image?url=%2Fimg%2Fcontact%2Fform-image.jpg&amp;w=256&amp;q=75 256w, /_next/image?url=%2Fimg%2Fcontact%2Fform-image.jpg&amp;w=384&amp;q=75 384w, /_next/image?url=%2Fimg%2Fcontact%2Fform-image.jpg&amp;w=640&amp;q=75 640w, /_next/image?url=%2Fimg%2Fcontact%2Fform-image.jpg&amp;w=750&amp;q=75 750w, /_next/image?url=%2Fimg%2Fcontact%2Fform-image.jpg&amp;w=828&amp;q=75 828w, /_next/image?url=%2Fimg%2Fcontact%2Fform-image.jpg&amp;w=1080&amp;q=75 1080w, /_next/image?url=%2Fimg%2Fcontact%2Fform-image.jpg&amp;w=1200&amp;q=75 1200w, /_next/image?url=%2Fimg%2Fcontact%2Fform-image.jpg&amp;w=1920&amp;q=75 1920w, /_next/image?url=%2Fimg%2Fcontact%2Fform-image.jpg&amp;w=2048&amp;q=75 2048w, /_next/image?url=%2Fimg%2Fcontact%2Fform-image.jpg&amp;w=3840&amp;q=75 3840w"
                src="/_next/image?url=%2Fimg%2Fcontact%2Fform-image.jpg&amp;w=3840&amp;q=75"
                style="position: absolute; height: 100%; width: 100%; inset: 0px; color: transparent;"></div>
        </section>
        <section class="g-4 pt-5 pb-3 pb-md-4 pb-lg-3 mt-lg-0 mt-xxl-4 row row-cols-lg-4 row-cols-sm-2 row-cols-1">
            <div class="text-center pt-1 pt-sm-2 pt-md-3 col">
                <div
                    class="position-relative d-inline-block bg-body-tertiary text-dark-emphasis fs-xl rounded-circle p-4 mb-3">
                    <i class="ci-phone-outgoing position-absolute top-50 start-50 translate-middle"></i>
                </div>
                <h3 class="h6">Call us directly</h3>
                <ul class="list-unstyled m-0">
                    <li class="nav animate-underline justify-content-center">Customers:<a href="tel:+15053753082"
                            class="nav-link animate-target fs-base ms-1 p-0">+1 50 537 53 082</a></li>
                    <li class="nav animate-underline justify-content-center">Franchise:<a href="tel:+15053753000"
                            class="nav-link animate-target fs-base ms-1 p-0">+1 50 537 53 000</a></li>
                </ul>
            </div>
            <div class="text-center pt-1 pt-sm-2 pt-md-3 col">
                <div
                    class="position-relative d-inline-block bg-body-tertiary text-dark-emphasis fs-xl rounded-circle p-4 mb-3">
                    <i class="ci-mail position-absolute top-50 start-50 translate-middle"></i>
                </div>
                <h3 class="h6">Send a message</h3>
                <ul class="list-unstyled m-0">
                    <li class="nav animate-underline justify-content-center">Customers:<a href="mailto:info@cartzilla.com"
                            class="nav-link animate-target fs-base ms-1 p-0">info@cartzilla.com</a></li>
                    <li class="nav animate-underline justify-content-center">Franchise:<a
                            href="mailto:franchise@cartzilla.com"
                            class="nav-link animate-target fs-base ms-1 p-0">franchise@cartzilla.com</a></li>
                </ul>
            </div>
            <div class="text-center pt-1 pt-sm-2 pt-md-3 col">
                <div
                    class="position-relative d-inline-block bg-body-tertiary text-dark-emphasis fs-xl rounded-circle p-4 mb-3">
                    <i class="ci-map-pin position-absolute top-50 start-50 translate-middle"></i>
                </div>
                <h3 class="h6">Store location</h3>
                <ul class="list-unstyled m-0">
                    <li class="">New York 11741, USA</li>
                    <li class="">396 Lillian Bolavandy, Holbrook</li>
                </ul>
            </div>
            <div class="text-center pt-1 pt-sm-2 pt-md-3 col">
                <div
                    class="position-relative d-inline-block bg-body-tertiary text-dark-emphasis fs-xl rounded-circle p-4 mb-3">
                    <i class="ci-clock position-absolute top-50 start-50 translate-middle"></i>
                </div>
                <h3 class="h6">Working hours</h3>
                <ul class="list-unstyled m-0">
                    <li class="">Mon - Fri 8:00 - 18:00</li>
                    <li class="">Sut - Sun 10:00 - 16:00</li>
                </ul>
            </div>
        </section>
        <hr class="my-lg-5">
        <section class="text-center pb-xxl-3 pt-4 pt-lg-3">
            <h2 class="pt-md-2 pt-lg-0">Looking for support?</h2>
            <p class="pb-2 pb-sm-3">We might already have what you're looking for. See our FAQs or head to our dedicated
                Help Center.</p><a class="btn btn-lg btn-outline-dark rounded-pill" href="#">Help Center</a>
        </section>
        </div>
    </main>
@endsection