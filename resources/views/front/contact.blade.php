@extends('layouts.app')
@section('content')

    <main class="content-wrapper">
        <div class="py-5 mb-2 mb-sm-3 mb-md-4 mb-lg-5 mt-lg-3 mt-xl-4 container">
            <h1 class="text-center">Contact us</h1>
            <p class="text-center pb-2 pb-sm-3">Fill out the form below and we will reply within 24 hours</p>
            <section class="g-0 overflow-hidden rounded-5 row row-cols-md-2 row-cols-1">
                <div class="bg-body-tertiary py-5 px-4 px-xl-5 col">
                    <form novalidate="" class="py-md-2 px-md-1 px-lg-3 mx-lg-3">
                        <div class="position-relative mb-4"><label class="form-label" for="name">First name *</label><input
                                required="" id="name" class="rounded-pill form-control form-control-lg" type="text">
                            <div class="bg-transparent z-0 py-0 ps-3 invalid-tooltip">Enter your name!</div>
                        </div>
                        <div class="position-relative mb-4"><label class="form-label" for="email">Email *</label><input
                                required="" id="email" class="rounded-pill form-control form-control-lg" type="email">
                            <div class="bg-transparent z-0 py-0 ps-3 invalid-tooltip">Enter your email address!</div>
                        </div>
                        <div class="position-relative mb-4"><label class="form-label">Subject *</label>
                            <div aria-label="Subject select">
                                <div class="choices" data-type="select-one" tabindex="0" role="listbox" aria-haspopup="true"
                                    aria-expanded="false">
                                    <div class="form-select form-select-lg rounded-pill"><select
                                            class="form-select form-select-lg rounded-pill choices__input" required=""
                                            hidden="" tabindex="-1" data-choice="active">
                                            <option value="" selected="">Select subject</option>
                                            <option value="General inquiry">General inquiry</option>
                                            <option value="Order status">Order status</option>
                                            <option value="Product information">Product information</option>
                                            <option value="Technical support">Technical support</option>
                                            <option value="Website feedback">Website feedback</option>
                                            <option value="Account assistance">Account assistance</option>
                                            <option value="Security concerns">Security concerns</option>
                                        </select>
                                        <div class="choices__list choices__list--single">
                                            <div class="choices__item choices__placeholder choices__item--selectable"
                                                data-item="" data-id="1" data-value="" aria-selected="true" role="option"
                                                data-placeholder="" data-deletable="">Select subject<button type="button"
                                                    class="choices__button" aria-label="Remove item: " data-button="">Remove
                                                    item</button></div>
                                        </div>
                                    </div>
                                    <div class="choices__list choices__list--dropdown" aria-expanded="false">
                                        <div class="choices__list" role="listbox">
                                            <div id="choices--6m9q-item-choice-1"
                                                class="choices__item choices__item--choice is-selected choices__placeholder choices__item--selectable is-highlighted"
                                                role="option" data-choice="" data-id="1" data-value=""
                                                data-choice-selectable="" aria-selected="true">Select subject</div>
                                            <div id="choices--6m9q-item-choice-2"
                                                class="choices__item choices__item--choice choices__item--selectable"
                                                role="option" data-choice="" data-id="2" data-value="General inquiry"
                                                data-choice-selectable="">General inquiry</div>
                                            <div id="choices--6m9q-item-choice-3"
                                                class="choices__item choices__item--choice choices__item--selectable"
                                                role="option" data-choice="" data-id="3" data-value="Order status"
                                                data-choice-selectable="">Order status</div>
                                            <div id="choices--6m9q-item-choice-4"
                                                class="choices__item choices__item--choice choices__item--selectable"
                                                role="option" data-choice="" data-id="4" data-value="Product information"
                                                data-choice-selectable="">Product information</div>
                                            <div id="choices--6m9q-item-choice-5"
                                                class="choices__item choices__item--choice choices__item--selectable"
                                                role="option" data-choice="" data-id="5" data-value="Technical support"
                                                data-choice-selectable="">Technical support</div>
                                            <div id="choices--6m9q-item-choice-6"
                                                class="choices__item choices__item--choice choices__item--selectable"
                                                role="option" data-choice="" data-id="6" data-value="Website feedback"
                                                data-choice-selectable="">Website feedback</div>
                                            <div id="choices--6m9q-item-choice-7"
                                                class="choices__item choices__item--choice choices__item--selectable"
                                                role="option" data-choice="" data-id="7" data-value="Account assistance"
                                                data-choice-selectable="">Account assistance</div>
                                            <div id="choices--6m9q-item-choice-8"
                                                class="choices__item choices__item--choice choices__item--selectable"
                                                role="option" data-choice="" data-id="8" data-value="Security concerns"
                                                data-choice-selectable="">Security concerns</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-transparent z-0 py-0 ps-3 invalid-tooltip">Select the subject of your message!
                            </div>
                        </div>
                        <div class="position-relative mb-4"><label class="form-label" for="message">Message
                                *</label><textarea rows="5" required="" id="message"
                                class="rounded-6 form-control form-control-lg"></textarea>
                            <div class="bg-transparent z-0 py-0 ps-3 invalid-tooltip">Write your message!</div>
                        </div>
                        <div class="pt-2"><button type="submit" class="rounded-pill btn btn-dark btn-lg">Send
                                message</button></div>
                    </form>
                </div>
                <div class="position-relative col"><img alt="Image" decoding="async" data-nimg="fill"
                        class="object-fit-cover" sizes="972px"
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
                        <li class="nav animate-underline justify-content-center">Customers:<a
                                href="mailto:info@cartzilla.com"
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