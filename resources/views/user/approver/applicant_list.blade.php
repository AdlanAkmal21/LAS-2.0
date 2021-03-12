@extends('layouts.app')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mt-3 mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Applicant List</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Applicant List</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="container-fluid">
    <div class="table-responsive-lg">
        <table class="table table-bordered table-sm table-striped">
            <thead class="table-dark">
                <tr class="text-center">
                    <th>#</th>
                    <th>Employee Name</th>
                    <th>Role</th>
                    <th>Date Joined</th>
                    <th>Employee Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $key => $user)
                <tr>
                    <td>{{ $users->firstItem() + $key }}.</td>
                    <td>{{ $user->name }}</td>
                    <td class="text-center">{{ $user->refRole->role_name }}</td>
                    <td class="text-center">{{ $user->date_joined }}</td>
                    <td
                        class="text-center {{ ($user->emp_status_id == 2) ? 'text-danger' : (($user->emp_status_id == 3 || $user->emp_status_id == 4) ? 'text-success' : 'text-primary') }}">
                        {{ $user->refEmpStatus->emp_status_name }}</td>
                    <td>
                        <a class="btn btn-primary" href="{{ route('approver.applicant_show', $user->userid )}}">Show</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $users->links() }}

</div>

@endsection
