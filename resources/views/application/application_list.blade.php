@extends('layouts.app')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Application List {{ $title }}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Application List</li>
                    <li class="breadcrumb-item"><a href="{{ route('application.create') }}">Apply Leave</a></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

@include('partials._validation')
@include('partials._notifications')

<div class="container-fluid">
    @if(Auth::user()->leavedetail)
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-link active" id="nav-all-tab" data-toggle="tab" href="#nav-all" role="tab"
                aria-controls="nav-all" aria-selected="true">All</a>
            <a class="nav-link " id="nav-pending-tab" data-toggle="tab" href="#nav-pending" role="tab"
                aria-controls="nav-pending" aria-selected="true">Pending</a>
            <a class="nav-link" id="nav-approved-tab" data-toggle="tab" href="#nav-approved" role="tab"
                aria-controls="nav-approved" aria-selected="false">Approved</a>
            <a class="nav-link" id="nav-rejected-tab" data-toggle="tab" href="#nav-rejected" role="tab"
                aria-controls="nav-rejected" aria-selected="false">Rejected</a>
        </div>
    </nav>
    <div class="tab-content py-3" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab">
            @if($alls->isEmpty())
            <div class="card">
                <div class="card-body text-center">
                    <span class="text-muted">No Leave Available</span>
                </div>
            </div>
            @else
            <div class="table-responsive-lg">
                <table class="table table-bordered table-sm text-center">
                    <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>Leave Type</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Applied At</th>
                            <th>Status</th>

                            <th colspan=2>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($alls as $key => $all)
                        <tr>
                            <td>{{ $alls->firstItem() + $key }}.</td>
                            <td>{{ $all->refLeaveType->leave_type_name }}</td>
                            <td>{{ $all->from }}</td>
                            <td>{{ $all->to }}</td>
                            <td>{{ $all->created_at }}</td>
                            <td
                                class="{{ ($all->application_status_id == 2)?'text-success':(($all->application_status_id == 3)?'text-danger':'text-info') }}">
                                {{ $all->refAppStatus->application_status_name }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary btn-sm btn-block dropdown-toggle"
                                        data-toggle="dropdown">More</button>
                                    <div class="dropdown-menu">
                                        <a href="{{ route('application.show', $all->id)}}"
                                            class="dropdown-item">Show</a>
                                        @if ($all->application_status_id == 1 && $all->leave_type_id == 1)
                                        <a href="{{ route('application.edit', $all->id)}}"
                                            class="dropdown-item text-success">Edit</a>
                                        @endif
                                        <div class="dropdown-divider"></div>
                                        <form action="{{ route('application.destroy', $all->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <input class="dropdown-item text-danger" role="button" type="submit"
                                                value="Delete" onclick="return confirm('Delete Application?');">
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
            {{ $alls->links() }}
        </div>
        <div class="tab-pane fade" id="nav-pending" role="tabpanel" aria-labelledby="nav-pending-tab">
            @if($pendings->isEmpty())
            <div class="card">
                <div class="card-body text-center">
                    <span class="text-muted">No Pending Leave Available</span>
                </div>
            </div>
            @else
            <div class="table-responsive-lg">
                <table class="table table-bordered table-sm text-center">
                    <thead class="table-secondary">
                        <tr>
                            <th>#</th>
                            <th>Leave Type</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Applied At</th>
                            <th>Status</th>

                            <th colspan=2>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendings as $key => $pending)
                        <tr>
                            <td>{{ $pendings->firstItem() + $key }}.</td>
                            <td>{{ $pending->refLeaveType->leave_type_name }}</td>
                            <td>{{ $pending->from }}</td>
                            <td>{{ $pending->to }}</td>
                            <td>{{ $pending->created_at }}</td>
                            <td
                                class="{{ ($pending->application_status_id == 2)?'text-success':(($pending->application_status_id == 3)?'text-danger':'text-info') }}">
                                {{ $pending->refAppStatus->application_status_name }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary btn-sm btn-block dropdown-toggle"
                                        data-toggle="dropdown">More</button>
                                    <div class="dropdown-menu">
                                        <a href="{{ route('application.show', $pending->id)}}"
                                            class="dropdown-item">Show</a>
                                        @if ($pending->application_status_id == 1)
                                        <a href="{{ route('application.edit', $pending->id)}}"
                                            class="dropdown-item text-success">Edit</a>
                                        @endif
                                        <div class="dropdown-divider"></div>
                                        <form action="{{ route('application.destroy', $pending->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <input class="dropdown-item text-danger" role="button" type="submit"
                                                value="Delete" onclick="return confirm('Delete Application?');">
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
            {{ $pendings->links() }}
        </div>
        <div class="tab-pane fade" id="nav-approved" role="tabpanel" aria-labelledby="nav-approved-tab">
            @if($approveds->isEmpty())
            <div class="card">
                <div class="card-body text-center">
                    <span class="text-muted">No Approved Leave Available</span>
                </div>
            </div>
            @else
            <div class="table-responsive-lg">
                <table class="table table-bordered table-sm text-center">
                    <thead class="table-success">
                        <tr>
                            <th>#</th>
                            <th>Leave Type</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Applied At</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($approveds as $key => $approved)
                        <tr>
                            <td>{{ $approveds->firstItem() + $key }}.</td>
                            <td>{{ $approved->refLeaveType->leave_type_name }}</td>
                            <td>{{ $approved->from }}</td>
                            <td>{{ $approved->to }}</td>
                            <td>{{ $approved->created_at }}</td>
                            <td
                                class="{{ ($approved->application_status_id == 2)?'text-success':(($approved->application_status_id == 3)?'text-danger':'text-info') }}">
                                {{ $approved->refAppStatus->application_status_name }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary btn-sm btn-block dropdown-toggle"
                                        data-toggle="dropdown">More</button>
                                    <div class="dropdown-menu">
                                        <a href="{{ route('application.show', $approved->id)}}"
                                            class="dropdown-item">Show</a>
                                        <form action="{{ route('application.destroy', $approved->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <input class="dropdown-item text-danger" role="button" type="submit"
                                                value="Delete" onclick="return confirm('Delete Application?');">
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
            {{ $approveds->links() }}
        </div>
        <div class="tab-pane fade" id="nav-rejected" role="tabpanel" aria-labelledby="nav-rejected-tab">
            @if($rejecteds->isEmpty())
            <div class="card">
                <div class="card-body text-center">
                    <span class="text-muted">No Rejected Leave Available</span>
                </div>
            </div>
            @else
            <div class="table-responsive-lg">
                <table class="table table-bordered table-sm text-center">
                    <thead class="table-danger">
                        <tr>
                            <th>#</th>
                            <th>Leave Type</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Applied At</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rejecteds as $key => $rejected)
                        <tr>
                            <td>{{ $rejecteds->firstItem() + $key }}.</td>
                            <td>{{ $rejected->refLeaveType->leave_type_name }}</td>
                            <td>{{ $rejected->from }}</td>
                            <td>{{ $rejected->to }}</td>
                            <td>{{ $rejected->created_at }}</td>
                            <td
                                class="{{ ($rejected->application_status_id == 2)?'text-success':(($rejected->application_status_id == 3)?'text-danger':'text-info') }}">
                                {{ $rejected->refAppStatus->application_status_name }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary btn-sm btn-block dropdown-toggle"
                                        data-toggle="dropdown">More</button>
                                    <div class="dropdown-menu">
                                        <a href="{{ route('application.show', $rejected->id)}}"
                                            class="dropdown-item">Show</a>
                                        <form action="{{ route('application.destroy', $rejected->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <input class="dropdown-item text-danger" role="button" type="submit"
                                                value="Delete" onclick="return confirm('Delete Application?');">
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
            {{ $rejecteds->links() }}
        </div>
    </div>
    @else
    <div class="card shadow mt-3">
        <div class="card-body text-center">
            <span class="text-muted">No Leave Record Found.</span>
        </div>
    </div>
    @endif
</div>

@endsection
