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
    </style>

    @yield('styles')
</head>
<body id="page-top">
    <div id="wrapper">
        @include('admin.layouts.navigate')
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('admin.layouts.header')
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
