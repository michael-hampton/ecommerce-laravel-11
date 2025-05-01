@extends('layouts.app')
@section('content')
    <main class="content-wrapper">
        <div class="py-5 mb-2 mt-n2 mt-sm-1 my-md-3 my-lg-4 mb-xl-5 container">
            <div class="justify-content-center row">
                <div class="col-xxl-9 col-xl-10 col-lg-11">
                    <h1 class="h2 pb-2 pb-sm-3 pb-lg-4">Terms and conditions</h1>
                    <hr class="mt-0">
                    <div class="h6 pt-2 pt-lg-3"><span class="text-body-secondary fw-medium">Last updated:</span> June 26,
                        2025</div>
                    <p>Welcome to {{config('shop.shop_name')}}! These Terms and Conditions ("Terms") govern your access to and use of the
                        {{config('shop.shop_name')}} website and mobile application (collectively referred to as the "Platform"). Please read
                        these Terms carefully before using the Platform. By accessing or using the Platform, you agree to be
                        bound by these Terms.</p>
                    <h2 class="h4 pt-3 pt-lg-4">1. Overview</h2>
                    <p>{{config('shop.shop_name')}} provides an online platform that enables users to purchase groceries and other products
                        from local stores and have them delivered to their designated location. By using the Platform, you
                        acknowledge and agree that {{config('shop.shop_name')}} is not a store or retailer but merely acts as an intermediary
                        to facilitate transactions between users and participating stores.</p>
                    <p>Welcome to the family of websites and applications provided by {{config('shop.shop_name')}}. These Terms of Use govern
                        your access to and use of all {{config('shop.shop_name')}} Sites, among other things. By using the {{config('shop.shop_name')}} Sites, you
                        affirm that you are of legal age to enter into these Terms of Use, or, if you are not, that you have
                        obtained parental or guardian consent to enter into these Terms of Use and your parent or guardian
                        consents to these Terms of Use on your behalf. If you violate or do not agree to these Terms of Use,
                        then your access to and use of the {{config('shop.shop_name')}} Sites is unauthorized. Additional terms and conditions
                        apply to some services offered on the {{config('shop.shop_name')}} Sites (e.g., {{config('shop.shop_name')}} Pharmacy, {{config('shop.shop_name')}} +, and
                        Gift Cards) or through other channels. Those terms and conditions can be found where the relevant
                        service is offered on the {{config('shop.shop_name')}} Sites or otherwise and are incorporated into these Terms of Use
                        by reference.</p>
                    <h2 class="h4 pt-3 pt-lg-4">2. Your use of the {{config('shop.shop_name')}} Sites</h2>
                    <p>You certify that the Content you provide on or through the {{config('shop.shop_name')}} Sites is accurate and that the
                        information you provide on or through the {{config('shop.shop_name')}} Sites is complete. You are solely responsible
                        for maintaining the confidentiality and security of your account including username, password, and
                        PIN. {{config('shop.shop_name')}} is not responsible for any losses arising out of the unauthorized use of your
                        account. You agree that {{config('shop.shop_name')}} does not have any responsibility if you lose or share access to
                        your device. Any agreement between you and the issuer of your credit card, debit card, or other form
                        of payment will continue to govern your use of such payment method on the {{config('shop.shop_name')}} Sites. You agree
                        that {{config('shop.shop_name')}} is not a party to any such agreement, nor is {{config('shop.shop_name')}} responsible for the content,
                        accuracy, or unavailability of any method used for payment. Your account may be restricted or
                        terminated for any reason, at our sole discretion. Except as otherwise provided by law, at any time
                        without notice to you, we may (1) change, restrict access to, suspend, or discontinue the {{config('shop.shop_name')}}
                        Sites or any portion of the {{config('shop.shop_name')}} Sites, and (2) charge, modify, or waive any fees required to
                        use any services, functionality, or other content available through the {{config('shop.shop_name')}} Sites or any
                        portion of the {{config('shop.shop_name')}} Sites.</p>
                    <h3 class="h6">In connection with the {{config('shop.shop_name')}} Sites, you will not:</h3>
                    <ul class="gap-3">
                        <li>Make available any Content through or in connection with the {{config('shop.shop_name')}} Sites that is or may be
                            in violation of the content guidelines set forth in Section 3.C (Prohibited Content) below.</li>
                        <li>Make available through or in connection with the {{config('shop.shop_name')}} Sites any virus, worm, Trojan horse,
                            Easter egg, time bomb, spyware, or other computer code, file, or program that is or is
                            potentially harmful or invasive or intended to damage or hijack the operation of, or to monitor
                            the use of, any hardware, software, or equipment.</li>
                        <li>Use the {{config('shop.shop_name')}} Sites for any commercial purpose, or for any purpose that is fraudulent or
                            otherwise tortious or unlawful.</li>
                        <li>Harvest or collect information about users of the {{config('shop.shop_name')}} Sites.</li>
                        <li>Interfere with or disrupt the operation of the {{config('shop.shop_name')}} Sites or the systems, servers, or
                            networks used to make the {{config('shop.shop_name')}} Sites available, including by hacking or defacing any
                            portion of the {{config('shop.shop_name')}} Sites; or violate any requirement, procedure, or policy of such servers
                            or networks.</li>
                        <li>Reproduce, modify, adapt, translate, create derivative works of, sell, rent, lease, loan,
                            timeshare, distribute, or otherwise exploit any portion of (or any use of) the {{config('shop.shop_name')}} Sites
                            except as expressly authorized in these Terms of Use, without {{config('shop.shop_name')}}'s express prior written
                            consent.</li>
                        <li>Reverse engineer, decompile, or disassemble any portion of the {{config('shop.shop_name')}} Sites, except where
                            such restriction is expressly prohibited by applicable law.</li>
                        <li>Remove any copyright, trademark, or other proprietary rights notice from the {{config('shop.shop_name')}} Sites.
                        </li>
                        <li>You will not attempt to do anything, or permit, encourage, assist, or allow any third party to
                            do anything, prohibited in this Section, or attempt, permit, encourage, assist, or allow any
                            other violation of these Terms of Use.</li>
                    </ul>
                    <h2 class="h4 pt-3 pt-lg-4">3. Ordering and delivery</h2>
                    <p>When placing an order through {{config('shop.shop_name')}}, you are responsible for ensuring the accuracy of the items,
                        quantities, and delivery details. {{config('shop.shop_name')}} does not guarantee the availability of any specific
                        product and reserves the right to substitute products based on availability. Delivery times provided
                        are estimates and may vary due to various factors.</p>
                    <ul class="gap-3">
                        <li>Reverse engineer, decompile, or disassemble any portion of the {{config('shop.shop_name')}} Sites, except where
                            such restriction is expressly prohibited by applicable law.</li>
                        <li>Reproduce, modify, adapt, translate, create derivative works of, sell, rent, lease, loan,
                            timeshare, distribute, or otherwise exploit any portion of (or any use of) the {{config('shop.shop_name')}} Sites
                            except as expressly authorized in these Terms of Use, without {{config('shop.shop_name')}}'s express prior written
                            consent.</li>
                        <li>You will not attempt to do anything, or permit, encourage, assist, or allow any third party to
                            do anything, prohibited in this Section, or attempt, permit, encourage, assist, or allow any
                            other violation of these Terms of Use.</li>
                        <li>Remove any copyright, trademark, or other proprietary rights notice from the {{config('shop.shop_name')}} Sites.
                        </li>
                    </ul>
                    <h2 class="h4 pt-3 pt-lg-4">4. Payments</h2>
                    <p>{{config('shop.shop_name')}} facilitates payments for orders made through the Platform. By using {{config('shop.shop_name')}}'s payment
                        services, you agree to provide accurate payment information and authorize {{config('shop.shop_name')}} to charge the
                        applicable amount for your order. {{config('shop.shop_name')}} may use third-party payment processors to process
                        transactions and may store your payment information in accordance with its Privacy Policy.</p>
                    <h2 class="h4 pt-3 pt-lg-4">5. User conduct</h2>
                    <p>You agree to use the Platform in compliance with all applicable laws and regulations. You shall not
                        engage in any unlawful, harmful, or abusive behavior while using the Platform. {{config('shop.shop_name')}} reserves
                        the right to suspend or terminate your account if you violate these Terms or engage in any
                        prohibited activities.</p>
                    <h3 class="h6 pt-2">Intellectual property</h3>
                    <p>All content on the {{config('shop.shop_name')}} Platform, including but not limited to text, graphics, logos, and
                        software, is the property of {{config('shop.shop_name')}} or its licensors and is protected by intellectual property
                        laws. You may not use, reproduce, modify, or distribute any content from the Platform without prior
                        written consent from {{config('shop.shop_name')}}.</p>
                    <h3 class="h6 pt-2">Third-party links and content</h3>
                    <p>The Platform may contain links to third-party websites or resources. {{config('shop.shop_name')}} does not endorse,
                        control, or assume responsibility for any third-party content or websites. You acknowledge and agree
                        that {{config('shop.shop_name')}} is not liable for any loss or damage caused by your reliance on such content or
                        websites.</p>
                    <h3 class="h6 pt-2">Disclaimer of warranties</h3>
                    <p>The Platform is provided on an "as is" and "as available" basis, without warranties of any kind,
                        either express or implied. {{config('shop.shop_name')}} does not guarantee the accuracy, reliability, or availability
                        of the Platform and disclaims all warranties to the fullest extent permitted by law.</p>
                    <h3 class="h6 pt-2">Limitation of liability</h3>
                    <p>To the maximum extent permitted by law, {{config('shop.shop_name')}} and its affiliates shall not be liable for any
                        indirect, incidental, consequential, or punitive damages arising out of or in connection with the
                        use of the Platform, even if advised of the possibility of such damages.</p>
                    <h2 class="h4 pt-3 pt-lg-4">6. Entire agreement and severability</h2>
                    <p>These Terms, subject to any amendments, modifications, or additional agreements you enter into with
                        {{config('shop.shop_name')}}, shall constitute the entire agreement between you and {{config('shop.shop_name')}} with respect to the
                        Services and any use of the Services. If any provision of these Terms is found to be invalid by a
                        court of competent jurisdiction, that provision only will be limited to the minimum extent
                        necessary, and the remaining provisions will remain in full force and effect.</p>
                    <p>{{config('shop.shop_name')}} reserves the right to modify or update these Terms at any time without prior notice. Your
                        continued use of the Platform after any changes to the Terms constitutes acceptance of those
                        changes.</p>
                    <h2 class="h4 pt-3 pt-lg-4">7. Contact information</h2>
                    <p>If you have any questions, or comments about these Terms please contact {{config('shop.shop_name')}} at:</p>
                    <ul class="list-unstyled pb-1">
                        <li class="nav pt-1"><a class="nav-link align-items-start fs-base p-0" href="tel:+15053753082"><i
                                    class="ci-phone fs-xl mt-1 me-2"></i>+1&nbsp;50&nbsp;537&nbsp;53&nbsp;082</a></li>
                        <li class="nav pt-1"><a class="nav-link align-items-start fs-base p-0"
                                href="mailto:contact@catzillastore.com"><i
                                    class="ci-mail fs-xl mt-1 me-2"></i>contact@catzillastore.com</a></li>
                        <li class="nav pt-1"><a class="nav-link align-items-start fs-base p-0" href="#!"><i
                                    class="ci-map-pin fs-xl mt-1 me-2"></i>12 Beale St. Suite 600 San Francisco, California
                                94105</a></li>
                    </ul>
                    <p class="pb-3 mb-0">For customer service inquiries, please review Your Account Settings, visit
                        {{config('shop.shop_name')}}'s <a class="fw-medium" href="/help">Help Center.</a></p>
                    <hr class="my-3 my-lg-4">
                    <h2 class="h5 pt-3 mb-lg-4">Was this information helpful?</h2>
                    <div class="d-flex gap-3"><button type="button" class="btn btn-outline-secondary"><i
                                class="ci-thumbs-up fs-base me-2 ms-n1"></i>Yes</button><button type="button"
                            class="btn btn-outline-secondary"><i class="ci-thumbs-down fs-base me-2 ms-n1"></i>No</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection