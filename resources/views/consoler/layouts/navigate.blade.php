<link href="{{ asset('css/style.css') }}" rel="stylesheet">

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('consoler.dashboard')}}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class=""></i>
        </div>
        <div class="sidebar-brand-text mx-3">Consoler</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Consolers -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('consoler.profile', Auth::user()->id) }}">
            <i class="fas fa-fw fa-user"></i>
            <span>Your Profile</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Promote your listing -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('auctions.car')}}">
            <i class="fas fa-fw fa-bullhorn"></i>
            <span>Cars at Auction</span>
        </a>
    </li>
    <hr class="sidebar-divider">

    <!-- Nav Item - Promote your listing -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('invoices.show')}}">
            <i class="fas fa-fw fa-file-invoice-dollar"></i>
            <span>Invoice</span>
        </a>
    </li>

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
