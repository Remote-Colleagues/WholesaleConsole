
@extends('consoler.layouts.app')
@section('headerTitle', 'Dashboard')

@section('title', 'Dashboard')

@section('styles')
    <!-- Page level plugins -->
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800" style="pointer-events: none; user-select: none;">Dashboard</h1>

        <!-- Content Row -->
        <div class="row">
            <!-- Earnings (Monthly) Card Example -->


            <!-- Earnings (Annual) Card Example -->


            <!-- Tasks Card Example -->



            <!-- /.container-fluid -->
            @endsection

            @section('scripts')
                <!-- Page level plugins -->
                <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
                <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
                <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
                <!-- Page level custom scripts -->
                <script src="{{ asset('js/demo/chart-area-demo.js') }}"></script>
                <script src="{{ asset('js/demo/chart-pie-demo.js') }}"></script>
@endsection
