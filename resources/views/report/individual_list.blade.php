@extends('layouts.app')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Individual Report List</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Individual Report List</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="container-fluid">
    @if (!$users->isEmpty())
    <form class="d-flex align-items-center flex-nowrap mb-2" method="GET" action="{{route('admin.search_report')}}">
        <input type="text" class="form-control mr-sm-2" name="search" placeholder="Search" aria-label="Search"
            value="@if(!empty($query)) {{$query}} @endif">
        <button type="submit" class="btn btn-outline-success">Search</button>
    </form>

    <div class="table-responsive-lg">
        <table class="table table-sm table-bordered table-striped">
            <thead class="table-dark">
                <tr class="text-center">
                    <th>#</th>
                    <th>Employee Name</th>
                    <th>Role</th>
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
                    <td class="text-center {{ ($user->emp_status_id == 2) ? 'text-danger' : (($user->emp_status_id == 3 || $user->emp_status_id == 4) ? 'text-success' : 'text-primary') }}">{{ $user->refEmpStatus->emp_status_name }}</td>
                    <td>
                        <a href="{{ route('report.view_individual', $user->id)}}" class="btn btn-primary btn-sm btn-block">
                            Show
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>
    {{ $users->links() }}
    @else
    <div class="card">
        <div class="card-body text-center">
            <span>No record found.</span>
        </div>
    </div>
    @endif

</div>

@endsection
