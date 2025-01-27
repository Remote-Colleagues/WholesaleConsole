<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>@yield('title', 'Default Title')</title>

    <!-- Custom fonts for this template -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">

    <!-- Apply Font Styling Globally -->
    <style>
        body {
            /*font-family: 'Josefin Sans', sans-serif !important;*/
            font-family: 'Open Sans', system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", "Noto Sans", "Liberation Sans", Arial, sans-serif !important;
        }

        /* Make header fixed and sticky */
        .header-fixed {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            width: 100%;
            z-index: 1030; /* Ensure it's above other content */
            background-color: white; /* Add background color to avoid transparency */
            box-shadow: 0 2px 5px rgba(0,0,0,0.1); /* Optional: Add shadow to make it stand out */
        }

      
    </style>

    @yield('styles')
</head>
<body id="page-top">
    <div id="wrapper">
        @include('admin.layouts.navigate')
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('admin.layouts.header', ['class' => 'header-fixed']) <!-- Add fixed class -->
                @yield('content')
            </div>
            @include('admin.layouts.footer')
        </div>
    </div>

    <!-- Scroll to Top Button -->
    <a class="scroll-to-top rounded" href="#"><i class="fas fa-angle-up"></i></a>
    @yield('scripts')
</body>
</html>
