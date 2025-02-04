<link href="{{ asset('css/style.css') }}" rel="stylesheet">

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar" >
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('admin.dashboard')}}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class=""></i>
        </div>
        <div class="sidebar-brand-text mx-3" style="color:#5271FF">WC Admin</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Partner -->
    <li class="nav-item ">
        <a class="nav-link text-600" href="{{ route('partner.list') }}" style="color:#5271FF;" >
            <i class="fas fa-fw fa-users" style="color:#5271FF;"></i>
            <span>Partner</span>
        </a>
    </li>

    <!-- Nav Item - Consolers -->
    <li class="nav-item">
        <a class="nav-link" style="color:#5271FF;" href="{{ route('consoler.list') }}">
            <i class="fas fa-fw fa-cogs " style="color:#5271FF;"></i>
            <span>Consolers</span>
        </a>
    </li>

    <!-- Nav Item - Promote your listing -->
    <li class="nav-item">
        <a class="nav-link" style="color:#5271FF;" href="{{ route('auctions.index') }}">
            <i class="fas fa-fw fa-bullhorn" style="color:#5271FF;"></i>
            <span>Cars at Auction</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" style="color:#5271FF;" href="{{ route('auctions.shortlisted') }}">
            <i class="fas fa-fw fa-bullhorn" style="color:#5271FF;"></i>
            <span>Shortlisted Cars</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" style="color:#5271FF;" href="{{ route('calculate.list') }}">
            <i class="fas fa-fw fa-calculator" style="color:#5271FF;"></i>
            <span>Transport Calculator</span>
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
        <a class="nav-link" style="color:#5271FF;" href="{{route('invoices.index')}}">
            <i class="fas fa-fw fa-file-invoice" style="color:#5271FF;"></i>
            <span>Invoices</span>
        </a>
    </li>

    <!-- Nav Item - Username -->
     <li class="nav-item">
        <a class="nav-link" style="color:#5271FF;" href="{{route('admin.profile')}}">
            <i class="fas fa-fw fa-user-alt" style="color:#5271FF;"></i>
            <span>Profile</span>
        </a>
    </li>

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
{{--<hr class="sidebar-divider">--}}

<!-- Conditional Login/Logout Button -->

<li class="nav-item">
    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">
        <i class="fas fa-fw fa-sign-out-alt" style="color:#5271FF;"></i>
        <span style="color:#5271FF;">Logout</span>
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
</ul>
