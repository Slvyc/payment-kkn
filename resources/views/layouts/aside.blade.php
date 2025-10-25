<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2  bg-white my-2"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand px-4 py-3 m-0" href="{{ route('dashboard') }}" target="_blank">
            <img src="{{ asset('assets/img/Unaya.png') }}" class="navbar-brand-img" width="26" height="26"
                alt="main_logo">
            <span class="ms-1 text-sm text-dark">Payment KKN Unaya</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                    href="{{ route('dashboard') }}">
                    <i class="material-symbols-rounded opacity-5">dashboard</i>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('table') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                    href="{{ route('table') }}">
                    <i class="material-symbols-rounded opacity-5">table_view</i>
                    <span class="nav-link-text ms-1">Tables</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('billing') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                    href="{{ route('billing') }}">
                    <i class="material-symbols-rounded opacity-5">receipt_long</i>
                    <span class="nav-link-text ms-1">Billing</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('profile') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                    href="{{ route('profile') }}">
                    <i class="material-symbols-rounded opacity-5">person</i>
                    <span class="nav-link-text ms-1">Profile</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="sidenav-footer position-absolute w-100 bottom-0 ">
        <div class="mx-3">
            @if (Auth()->user())
                <a href="{{ route('logout.admin') }}" class="btn bg-gradient-dark w-100"
                    href="https://www.creative-tim.com/product/material-dashboard-pro?ref=sidebarfree" type="button">
                    Logout
                </a>
            @else
                <a href="{{ route('logout') }}" class="btn bg-gradient-dark w-100"
                    href="https://www.creative-tim.com/product/material-dashboard-pro?ref=sidebarfree" type="button">
                    Logout
                </a>
            @endif
        </div>
    </div>
</aside>