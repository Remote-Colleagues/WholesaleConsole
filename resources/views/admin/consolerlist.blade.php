@extends('admin.layouts.app') 

@section('content')

<div class="container-fluid">

    <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
    <h6 class="m-0 font-weight-bold text-primary" style="pointer-events: none; user-select: none;">Consoler Users List</h6>
    <a href="{{ route('consolers.create') }}" class="btn btn-primary">Add Consoler</a> 
</div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead style="pointer-events: none; user-select: none; background-color:#FFDA4B;">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>view details</th>
                        </tr>
                    </thead>
                    <tfoot style="pointer-events: none; user-select: none;">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>view details</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($consolers as $consoler)
                            <tr>
                                <td>{{ $consoler->name }}</td>
                                <td>{{ $consoler->email }}</td>
                                <td>{{ $consoler->status }}</td>
                                <td>
                                    <a href="{{ route('consoler.details', $consoler->id) }}" class="btn btn-info btn-sm">View Details</a> 
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

@endsection <!-- End of content section -->

<!-- Page level plugins -->
<script src="vendor/datatables/jquery.dataTables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="js/demo/datatables-demo.js"></script>
