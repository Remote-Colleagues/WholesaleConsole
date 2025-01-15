@extends('admin.layouts.app')
@section('headerTitle', 'Consolers')

@section('content')

<div class="container-fluid">

    <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
    <h6 class="m-0 font-weight-bold text-primary" style="pointer-events: none; user-select: none;">List of Consolers </h6>
    <a href="{{ route('consolers.create') }}" class="btn btn-primary border-0" style="background-color:#00E1A1;">Add Consoler</a>
</div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-borderless " id="dataTable" width="100%" cellspacing="0">
                    <thead style="pointer-events: none; user-select: none; background-color:#FFDA4B;">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Console Name</th>
                            <th>Contact Person</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->consoler->console_name ?? 'N/A' }}</td>
                                <td>{{ $user->consoler->contact_person ?? 'N/A' }}</td>

                                <td>
                                    <a href="{{ route('consoler.details', $user->id) }}" class="btn btn-info">View Details</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
            
                    <tfoot style="pointer-events: none; user-select: none;">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Console Name</th>
                            <th>Contact Person</th>
                            <th>Details</th>
                        </tr>
                    </tfoot>
                 
                </table>
            </div>
        </div>
    </div>

</div>

@endsection <!-- End of content section -->
