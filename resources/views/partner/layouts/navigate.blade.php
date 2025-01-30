<link href="{{ asset('css/style.css') }}" rel="stylesheet">

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('partner.dashboard')}}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class=""></i>
        </div>
        <div class="sidebar-brand-text mx-3" style="color:#5271FF;">Partner</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Partners -->
    <li class="nav-item">
        <a class="nav-link" style="color:#5271FF;" href="{{ route('partner.profile', Auth::user()->id) }}">
            <i class="fas fa-fw fa-user" style="color:#5271FF;"></i>
            <span>Your Profile</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Promote your listing -->
    <li class="nav-item">
        <a class="nav-link" style="color:#5271FF;" href="{{route('auction.car')}}">
            <i class="fas fa-fw fa-bullhorn" style="color:#5271FF;"></i>
            <span>Cars at Auction</span>
        </a>
    </li>
    <hr class="sidebar-divider">

    <!-- Nav Item - Promote your listing -->
    <li class="nav-item">
        <a class="nav-link" style="color:#5271FF;" href="{{route('invoicepartner.show')}}">
            <i class="fas fa-fw fa-file-invoice-dollar" style="color:#5271FF;"></i>
            <span>Invoice</span>
        </a>
    </li>

<!-- Divider -->
<hr class="sidebar-divider">

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
