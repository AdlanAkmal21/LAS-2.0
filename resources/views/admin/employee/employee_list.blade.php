@extends('layouts.app')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Employee List</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Employee List</li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.create') }}">Add Employee</a></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

@include('partials._validation')
@include('partials._notifications')

<div class="container-fluid">
    @if (!$users->isEmpty())
    <div class="container-fluid">
    <form class="d-flex align-items-center flex-nowrap mb-2" method="GET" action="{{route('admin.employee_search')}}">
        <input type="text" class="form-control mr-sm-2" name="search" placeholder="Search" aria-label="Search"
            value="@if(!empty($query)) {{$query}} @endif">
        <button type="submit" class="btn btn-outline-success">Search</button>
    </form>

    <div class="table-responsive-lg">
        <table class="table table-sm table-bordered table-striped">
            <thead class="table-dark">
                <tr class="d-flex">
                    <th class="col-1">#</th>
                    <th class="col-4">Employee Name</th>
                    <th class="col-2">Role</th>
                    <th class="col-2">Date Joined</th>
                    <th class="col-2">Employee Status</th>
                    <th class="col-1">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $key => $user)
                <tr class="d-flex">
                    <td class="col-1">{{ $users->firstItem() + $key }}.</td>
                    <td class="col-4">{{ $user->name }}</td>
                    <td class="col-2">{{ $user->refRole->role_name }}</td>
                    <td class="col-2">{{ $user->userdetail->date_joined }}</td>
                    <td class="col-2 {{ ($user->emp_status_id == 2) ? 'text-danger' : (($user->emp_status_id == 3 || $user->emp_status_id == 4) ? 'text-success' : 'text-primary') }}">{{ $user->refEmpStatus->emp_status_name }}</td>
                    <td class="col-1">
                        <div class="dropleft">
                            <button class="btn btn-primary btn-sm btn-block dropdown-toggle"
                                data-toggle="dropdown">More</button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('admin.show', $user->id)}}">Show</a>
                                <a class="dropdown-item text-success"
                                    href="{{ route('admin.edit', $user->id)}}">Edit</a>
                                <a class="dropdown-item text-info"  href="{{ route('admin.application_list_employee', $user->id) }}">Applications by Employee</a>
                                @if($user->emp_status_id != 2)
                                <div class="dropdown-divider"></div>
                                <form action="{{ route('admin.destroy', $user->id)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input class="dropdown-item text-danger" role="button" type="submit" value="Resign"
                                        onclick="return confirm('Resign this employee?');">
                                </form>
                                @endif
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $users->links() }}
    </div>
    @else
    <div class="card">
        <div class="card-body text-center">
            <span>No record found.</span>
        </div>
    </div>
    @endif
</div>




@endsection
