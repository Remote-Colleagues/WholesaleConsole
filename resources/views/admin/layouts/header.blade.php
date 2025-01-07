<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- FontAwesome for icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

<!-- Navbar -->
<nav class="navbar navbar-expand navbar-light bg-blue topbar mb-4 static-top shadow" style="background-color: #5271FF;">
    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav w-100">
        <!-- Nav Item - User Information -->
        <li class="nav-item d-flex align-items-center">
            <span class="text-white ml-3 font-weight-bold">
                Home > 
                @php
                    $segments = Request::segments();
                    $breadcrumb = collect($segments)->map(fn($segment) => ucfirst(str_replace('-', ' ', $segment)))->join(' > ');
                @endphp
                {{ $breadcrumb ?: 'Dashboard' }}
            </span>
        </li>
    </ul>
</nav>

<!-- Bootstrap JS & jQuery (important for dropdown functionality) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
