<ul class="account-nav">
    <li><a href="{{route('user.index')}}" class="menu-link menu-link_us-s">Dashboard</a></li>
    <li><a href="{{route('orders.ordersCustomer')}}" class="menu-link menu-link_us-s">Orders</a></li>
    <li><a href="{{route('user.address')}}" class="menu-link menu-link_us-s">Addresses</a></li>
    <li><a href="account-details.html" class="menu-link menu-link_us-s">Account Details</a></li>
    <li><a href="{{route('user.wishlist')}}" class="menu-link menu-link_us-s">Wishlist</a></li>
    <li><a href="{{route('user.reviews')}}" class="menu-link menu-link_us-s">Reviews</a></li>
    <li><a href="{{route('user.askQuestion')}}" class="menu-link menu-link_us-s">Ask a Question</a></li>

    <li>
        <form method="post" action="{{route('logout')}}" id="logout-form">
            @csrf
            <a href="{{route('logout')}}" class="menu-link menu-link_us-s" onclick="event.preventDefault(); document.getElementById('logout-form').submit()">Logout</a>
        </form>
    </li>

</ul>
