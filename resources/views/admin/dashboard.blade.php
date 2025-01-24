@extends('admin.layouts.app')
@section('headerTitle', 'Dashboard')

@section('title', 'Dashboard')

@section('styles')
    <!-- Page level plugins -->
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4" style="pointer-events: none; user-select: none; color: #5271FF">Dashboard</h1>

        <div class="row">
            <!-- Left Column (Cards) -->
            <div class="col-md-6">
                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-6 col-md-12 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <i class="fas fa-car" style="color: #5271FF;"></i>
                                    <span style="color: #5271FF">Active Car Listing</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings (Annual) Card Example -->
                <div class="col-xl-6 col-md-12 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <i class="fas fa-house-user" style="color: #5271FF;"></i>
                                    <span style="color: #5271FF">Auction House</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tasks Card Example -->
                <div class="col-xl-6 col-md-12 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <i class="fas fa-clipboard-list" style="color: #5271FF;"></i>
                                    <span style="color: #5271FF">Auction happening today</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column (Map) -->
            <div class="col-md-6">
                <div id="australia-map" style="height: 500px; width: 100%;"></div>
            </div>
        </div>
    </div>
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

    <!-- Include Highcharts Scripts -->
    <script src="https://code.highcharts.com/maps/highmaps.js"></script>
    <script src="https://code.highcharts.com/mapdata/countries/au/au-all.js"></script>

    <script>
        const mapData = @json($mapData);
        Highcharts.mapChart('australia-map', {
            chart: {
                map: 'countries/au/au-all'
            },
            title: {
                text: 'Active Cars by Region',
                style:{
                    color:'#5271FF',
                }
            },
            series: [{
                data: mapData,
                name: 'Active Cars',
                states: {
                    hover: {
                        color: '#5271FF'
                    }
                },
                dataLabels: {
                    enabled: true,
                    format: '{point.name}<br>Cars: {point.value}',
                }
            }]
        });
    </script>
@endsection
