<link href="{{ asset('css/style.css') }}" rel="stylesheet">

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class=""></i>
        </div>
        <div class="sidebar-brand-text mx-3">WC Admin</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Partner -->
    <li class="nav-item ">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-users"></i>
            <span>Partner</span>
        </a>
    </li>

    <!-- Nav Item - Consolers -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('consoler.list') }}">
            <i class="fas fa-fw fa-cogs"></i>
            <span>Consolers</span>
        </a>
    </li>

    <!-- Nav Item - Promote your listing -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('auctions.index') }}">
            <i class="fas fa-fw fa-bullhorn"></i>
            <span>Cars at Auction</span>
        </a>
    </li>

    <!-- Nav Item - Upcoming Event -->
{{--     <li class="nav-item">--}}
{{--        <a class="nav-link" href="#">--}}
{{--            <i class="fas fa-fw fa-calendar-alt"></i>--}}
{{--            <span>Upcoming Event</span>--}}
{{--        </a>--}}
{{--    </li> --}}

    <!-- Nav Item - Promote your event -->
    <!-- <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-calendar-plus"></i>
            <span>Promote your event</span>
        </a>
    </li> -->

    <!-- Nav Item - Invoices -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('invoices.index')}}">
            <i class="fas fa-fw fa-file-invoice"></i>
            <span>Invoices</span>
        </a>
    </li>

    <!-- Nav Item - Username -->
    <!-- <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-user"></i>
            <span>Username</span>
        </a>
    </li> -->

    <!-- Nav Item - Our Profiles -->
    <!-- <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-users"></i>
            <span>Our Profiles</span>
        </a>
    </li> -->

    <!-- Nav Item - Raise Tickets -->
    <!-- <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-ticket-alt"></i>
            <span>Raise Tickets</span>
        </a>
    </li> -->

    <!-- Nav Item - Terms and Conditions -->
    <!-- <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Terms and Conditions</span>
        </a>
    </li> -->

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Conditional Login/Logout Button -->

<li class="nav-item">
    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">
        <i class="fas fa-fw fa-sign-out-alt"></i>
        <span>Logout</span>
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
</ul>
