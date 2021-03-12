@extends('layouts.app')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Applications List {{ $title }}</h1>
                <p>Total Applications : {{$alls->count()}}</p>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Application List</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="container-fluid">
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-link active" id="nav-all-tab" data-toggle="tab" href="#nav-all" role="tab"
                aria-controls="nav-all" aria-selected="true">All</a>
            <a class="nav-link" id="nav-pending-tab" data-toggle="tab" href="#nav-pending" role="tab"
                aria-controls="nav-pending" aria-selected="true">Pending</a>
            <a class="nav-link" id="nav-approved-tab" data-toggle="tab" href="#nav-approved" role="tab"
                aria-controls="nav-approved" aria-selected="false">Approved</a>
            <a class="nav-link" id="nav-rejected-tab" data-toggle="tab" href="#nav-rejected" role="tab"
                aria-controls="nav-rejected" aria-selected="false">Rejected</a>
        </div>
    </nav>
    <div class="tab-content py-3" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab">
            <div class="card shadow-sm border-left-primary mb-4">
                <div class="card-header">All Leave Application</div>
                <div class="card-body text-center">
                    @if($alls->isEmpty())
                    <span class="text-muted">No Leave Available</span>
                    @else
                    <div class="table-responsive-lg">
                        <table class="table table-bordered table-sm">
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
                                        <a href="{{ route('admin.application_show', $all->id)}}"
                                            class="btn btn-primary">Show</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
                <div class="card-footer">{{ $alls->links() }}</div>
            </div>
        </div>
        <div class="tab-pane fade" id="nav-pending" role="tabpanel" aria-labelledby="nav-pending-tab">
            <div class="card shadow-sm border-left-secondary mb-4">
                <div class="card-header">Pending Leave Application</div>
                <div class="card-body text-center">
                    @if($pendings->isEmpty())
                    <span class="text-muted">No Pending Leave Available</span>
                    @else
                    <div class="table-responsive-lg">
                        <table class="table table-bordered table-sm">
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
                                        <a href="{{ route('admin.application_show', $pending->id)}}"
                                            class="btn btn-primary">Show</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
                <div class="card-footer">{{ $pendings->links() }}</div>
            </div>
        </div>
        <div class="tab-pane fade" id="nav-approved" role="tabpanel" aria-labelledby="nav-approved-tab">
            <div class="card shadow-sm border-left-success mb-4">
                <div class="card-header">Approved Leave Application</div>
                <div class="card-body text-center">
                    @if($approveds->isEmpty())
                    <span class="text-muted">No Approved Leave Available</span>
                    @else
                    <div class="table-responsive-lg">
                        <table class="table table-bordered table-sm">
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
                                        <a href="{{ route('admin.application_show', $approved->id)}}"
                                            class="btn btn-primary">Show</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
                <div class="card-footer">{{ $approveds->links() }}</div>
            </div>
        </div>
        <div class="tab-pane fade" id="nav-rejected" role="tabpanel" aria-labelledby="nav-rejected-tab">
            <div class="card shadow-sm border-left-danger mb-4">
                <div class="card-header">Rejected Leave Application</div>
                <div class="card-body text-center">
                    @if($rejecteds->isEmpty())
                    <span class="text-muted">No Rejected Leave Available</span>
                    @else
                    <div class="table-responsive-lg">
                        <table class="table table-bordered table-sm">
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
                                        <a href="{{ route('admin.application_show', $rejected->id)}}"
                                            class="btn btn-primary">Show</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
                <div class="card-footer">{{ $rejecteds->links() }}</div>
            </div>
        </div>
    </div>
</div>

@endsection
