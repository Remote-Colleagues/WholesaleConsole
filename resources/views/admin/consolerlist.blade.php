@extends('admin.layouts.app')
@section('headerTitle', 'Consolers')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
    <h6 class="m-0 font-weight-bold" style="pointer-events: none; user-select: none; color: #5271FF;">List of Consolers </h6>
    <a href="{{ route('consolers.create') }}" class="btn border-3" style="color:#5271FF; border-color: #5271FF;">Add Consoler</a>
</div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-borderless " id="dataTable" width="100%" cellspacing="0">
                    <thead style="pointer-events: none; user-select: none; color:#5271FF">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Console Name</th>
                            <th>Status</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ ucwords(strtolower($user->name)) }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ ucwords(strtolower($user->consoler->console_name ?? 'N/A')) }}</td>
                                <td>{{ ucwords(strtolower($user->status ?? 'No Status')) }}</td>
                                <td>
                                    <a href="{{ route('consoler.details', $user->id) }}" class="btn border-2" style="color:#5271FF; border-color: #5271FF">View Details</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>

@endsection
