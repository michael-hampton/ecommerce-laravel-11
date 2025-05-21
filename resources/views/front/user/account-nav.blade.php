<?php if(empty($current)) $current = 'account'; ?>

<div class="col-lg-3 my-lg-0 my-md-1">
    <div id="sidebar" class="bg-secondary">
        <div class="h4 text-white">Account</div>
        <ul>
            <li @if($current === 'account') class="active"@endif>
                <a href="{{route('user.index')}}" class="text-decoration-none d-flex align-items-start">
                    <div class="fa fa-box pt-2 me-3"></div>
                    <div class="d-flex flex-column">
                        <div class="link">My Account</div>
                        <div class="link-desc">View & Manage orders and returns</div>
                    </div>
                </a>
            </li>
            <li @if($current === 'orders') class="active"@endif>
                <a href="{{route('orders.ordersCustomer')}}" class="text-decoration-none d-flex align-items-start">
                    <div class="fa fa-box-open pt-2 me-3"></div>
                    <div class="d-flex flex-column">
                        <div class="link">My Orders</div>
                        <div class="link-desc">View & Manage orders and returns</div>
                    </div>
                </a>
            </li>
            <li @if($current === 'address') class="active"@endif>
                <a href="{{route('user.address')}}" class="text-decoration-none d-flex align-items-start">
                    <div class="fa fa-address-book pt-2 me-3"></div>
                    <div class="d-flex flex-column">
                        <div class="link">Address Book</div>
                        <div class="link-desc">View & Manage Addresses</div>
                    </div>
                </a>
            </li>
            <li @if($current === 'profile') class="active"@endif>
                <a href="#" class="text-decoration-none d-flex align-items-start">
                    <div class="fa fa-user pt-2 me-3"></div>
                    <div class="d-flex flex-column">
                        <div class="link">My Profile</div>
                        <div class="link-desc">Change your profile details & password</div>
                    </div>
                </a>
            </li>
            <li @if($current === 'reviews') class="active"@endif>
                <a href="{{route('user.reviews')}}" class="text-decoration-none d-flex align-items-start">
                    <div class="fa fa-star pt-2 me-3"></div>
                    <div class="d-flex flex-column">
                        <div class="link">Reviews</div>
                        <div class="link-desc">View your reviews</div>
                    </div>
                </a>
            </li>
            <li @if($current === 'wishlist') class="active"@endif>
                <a href="{{route('user.wishlist')}}" class="text-decoration-none d-flex align-items-start">
                    <div class="fa fa-heart pt-2 me-3"></div>
                    <div class="d-flex flex-column">
                        <div class="link">Wishlist</div>
                        <div class="link-desc">View your wishlist</div>
                    </div>
                </a>
            </li>
            <li @if($current === 'messages') class="active"@endif>
                <a href="{{route('user.askQuestion')}}" class="text-decoration-none d-flex align-items-start">
                    <div class="fa fa-envelope pt-2 me-3"></div>
                    <div class="d-flex flex-column">
                        <div class="link">Messages</div>
                        <div class="link-desc">Messages you have sent to sellers</div>
                    </div>
                </a>
            </li>
            <li @if($current === 'help') class="active"@endif>
                <a href="#" class="text-decoration-none d-flex align-items-start">
                    <div class="fa fa-info pt-2 me-3"></div>
                    <div class="d-flex flex-column">
                        <div class="link">Help & Support</div>
                        <div class="link-desc">Contact Us for help and support</div>
                    </div>
                </a>
            </li>
            <li @if($current === 'logout') class="active"@endif>
                <form method="post" action="{{route('logout')}}" id="logout-form">
                    @csrf
                    <a href="#" class="text-decoration-none d-flex align-items-start" onclick="event.preventDefault(); document.getElementById('logout-form').submit()">
                        <div class="fa fa-headset pt-2 me-3"></div>
                        <div class="d-flex flex-column">
                            <div class="link">Logout</div>
                            {{--                        <div class="link-desc">Contact Us for help and support</div>--}}
                        </div>
                    </a>
                </form>
            </li>
        </ul>
    </div>
</div>
