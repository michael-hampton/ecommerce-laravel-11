<div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
    <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
        <a href="/" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <span class="fs-5 d-none d-sm-inline">Shop Pinoy</span>
        </a>
        <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
            <li>
                <a href="{{route('admin.index')}}" class="nav-link px-0 align-middle">
                    <i class="fs-4 fa-people"></i> <span class="ms-1 d-none d-sm-inline">Dashboard</span> </a>
            </li>
            <li>
                <a href="{{route('admin.products')}}" class="nav-link px-0 align-middle ">
                    <i class="fs-4 fa-bootstrap"></i> <span class="ms-1 d-none d-sm-inline">Products</span></a>
            </li>
            <li>
                <a href="{{route('admin.brands')}}" class="nav-link px-0 align-middle">
                    <i class="text-white fs-4 fa fa-grid"></i> <span class="ms-1 d-none d-sm-inline">Brands</span> </a>
            </li>
            <li>
                <a href="{{route('admin.categories')}}" class="nav-link px-0 align-middle">
                    <i class="fs-4 fa-grid"></i> <span class="ms-1 d-none d-sm-inline">Categories</span> </a>
            </li>

            <li>
                <a href="{{route('admin.coupons')}}" class="nav-link px-0 align-middle">
                    <i class="fs-4 fa-grid"></i> <span class="ms-1 d-none d-sm-inline">Coupons</span> </a>
            </li>

            <li>
                <a href="{{route('admin.orders')}}" class="nav-link px-0 align-middle">
                    <i class="fs-4 fa-people"></i> <span class="ms-1 d-none d-sm-inline">Orders</span> </a>
            </li>

            <li>
                <a href="{{route('admin.slides')}}" class="nav-link px-0 align-middle">
                    <i class="fs-4 fa-grid"></i> <span class="ms-1 d-none d-sm-inline">Slides</span> </a>
            </li>

            <li>
                <a href="{{route('admin.askQuestion')}}" class="nav-link px-0 align-middle">
                    <i class="fs-4 fa-people"></i> <span class="ms-1 d-none d-sm-inline">Ask a Question</span> </a>
            </li>

            <li>
                <a href="{{route('admin.users')}}" class="nav-link px-0 align-middle">
                    <i class="fs-4 fa-people"></i> <span class="ms-1 d-none d-sm-inline">Users</span> </a>
            </li>

            <li>
                <a href="{{route('admin.askQuestion')}}" class="nav-link px-0 align-middle">
                    <i class="fs-4 fa-people"></i> <span class="ms-1 d-none d-sm-inline">Settings</span> </a>
            </li>

            <li>
                <a href="{{route('change-password')}}" class="nav-link px-0 align-middle">
                    <i class="fs-4 fa-people"></i> <span class="ms-1 d-none d-sm-inline">Change Password</span> </a>
            </li>

            <li>
                <a class="nav-link px-0 align-middle" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fs-4 fa fa-people"></i> <span class="ms-1 d-none d-sm-inline">Logout</span>
                </a>
            </li>
        </ul>
        <hr>
{{--        <div class="dropdown pb-4">--}}
{{--            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">--}}
{{--                <img src="https://github.com/mdo.png" alt="hugenerd" width="30" height="30" class="rounded-circle">--}}
{{--                <span class="d-none d-sm-inline mx-1">loser</span>--}}
{{--            </a>--}}
{{--            <ul class="dropdown-menu dropdown-menu-dark text-small shadow">--}}
{{--                <li><a class="dropdown-item" href="#">New project...</a></li>--}}
{{--                <li><a class="dropdown-item" href="#">Settings</a></li>--}}
{{--                <li><a class="dropdown-item" href="#">Profile</a></li>--}}
{{--                <li>--}}
{{--                    <hr class="dropdown-divider">--}}
{{--                </li>--}}
{{--                <li><a class="dropdown-item" href="#">Sign out</a></li>--}}
{{--            </ul>--}}
{{--        </div>--}}
    </div>
</div>

