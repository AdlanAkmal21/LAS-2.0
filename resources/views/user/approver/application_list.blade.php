@extends('layouts.app')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Application List (Approver)</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Application List (Approver)</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

@include('partials._notifications')

<div class="container-fluid">
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-link active" id="nav-pending-tab" data-toggle="tab" href="#nav-pending" role="tab"
                aria-controls="nav-pending" aria-selected="true">Pending</a>
            <a class="nav-link" id="nav-approved-tab" data-toggle="tab" href="#nav-approved" role="tab"
                aria-controls="nav-approved" aria-selected="false">Approved</a>
            <a class="nav-link" id="nav-rejected-tab" data-toggle="tab" href="#nav-rejected" role="tab"
                aria-controls="nav-rejected" aria-selected="false">Rejected</a>
        </div>
    </nav>
    <div class="tab-content py-3" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-pending" role="tabpanel" aria-labelledby="nav-pending-tab">
            @if ($approver_list_array['pendings']->isEmpty())
            <div class="card">
                <div class="card-body text-center">
                    <span class="text-muted">No Pending Application Available</span>
                </div>
            </div>
            @else
            <div class="table-responsive-lg">
                <table class="table table-bordered table-sm">
                    <thead class="table-secondary text-center">
                        <tr>
                            <th>#</th>
                            <th>Employee Name</th>
                            <th>Balance Leaves</th>
                            <th>Days Taken</th>
                            <th>Leave Type</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($approver_list_array['pendings'] as $key => $pending)
                        <tr>
                            <td>{{ $approver_list_array['pendings']->firstItem() +$key }}.</td>
                            <td>{{ $pending->user->name }}</td>
                            <td class="text-center">{{ $pending->user->leavedetail->balance_leaves }}</td>
                            <td class="text-center">{{ $pending->days_taken }}</td>
                            <td class="text-center">{{ $pending->refLeaveType->leave_type_name }}</td>
                            <td class="text-center">{{ $pending->from }}</td>
                            <td class="text-center">{{ $pending->to }}</td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-primary btn-sm btn-block dropdown-toggle"
                                        data-toggle="dropdown">More</button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item"
                                            href="{{ route('approver.approver_list_show', $pending)}}">Show</a>

                                        <div class="dropdown-divider"></div>

                                        <form action="{{ route('approver.approve', $pending)}}" method="post">
                                            @csrf
                                            @method('GET')
                                            <input class="dropdown-item text-success" role="button" type="submit"
                                                value="Approve">
                                        </form>

                                        <form action="{{ route('approver.reject', $pending)}}" method="post">
                                            @csrf
                                            @method('GET')
                                            <input class="dropdown-item text-danger" role="button" type="submit"
                                                value="Reject">
                                        </form>
                                    </div>
                                </div>

                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $approver_list_array['pendings']->links() }}
            @endif
        </div>
        <div class="tab-pane fade" id="nav-approved" role="tabpanel" aria-labelledby="nav-approved-tab">
            @if ($approver_list_array['approveds']->isEmpty())
            <div class="card">
                <div class="card-body text-center">
                    <span class="text-muted">No Approved Application Available</span>
                </div>
            </div>
            @else
            <div class="table-responsive-lg">
                <table class="table table-bordered table-sm">
                    <thead class="table-success text-center">
                        <tr>
                            <th>#</th>
                            <th>Employee Name</th>
                            <th>Balance Leaves</th>
                            <th>Days Taken</th>
                            <th>Leave Type</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($approver_list_array['approveds'] as $key => $approve)
                        <tr>
                            <td>{{ $approver_list_array['approveds']->firstItem() +$key }}.</td>
                            <td>{{ $approve->user->name }}</td>
                            <td class="text-center">{{ $approve->user->leavedetail->balance_leaves }}</td>
                            <td class="text-center">{{ $approve->days_taken }}</td>
                            <td class="text-center">{{ $approve->refLeaveType->leave_type_name }}</td>
                            <td class="text-center">{{ $approve->from }}</td>
                            <td class="text-center">{{ $approve->to }}</td>
                            <td class="text-center">
                                <a class="btn btn-primary" href="{{ route('approver.approver_list_show', $approve)}}">
                                    Show</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $approver_list_array['approveds']->links() }}
            @endif
        </div>
        <div class="tab-pane fade" id="nav-rejected" role="tabpanel" aria-labelledby="nav-rejected-tab">
            @if ($approver_list_array['rejecteds']->isEmpty())
            <div class="card">
                <div class="card-body text-center">
                    <span class="text-muted">No Rejected Application Available</span>
                </div>
            </div>
            @else
            <div class="table-responsive-lg">
                <table class="table table-bordered table-sm">
                    <thead class="table-danger text-center">
                        <tr>
                            <th>#</th>
                            <th>Employee Name</th>
                            <th>Balance Leaves</th>
                            <th>Days Taken</th>
                            <th>Leave Type</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($approver_list_array['rejecteds'] as $key => $reject)
                        <tr>
                            <td>{{ $approver_list_array['rejecteds']->firstItem() +$key }}.</td>
                            <td>{{ $reject->user->name }}</td>
                            <td class="text-center">{{ $reject->user->leavedetail->balance_leaves }}</td>
                            <td class="text-center">{{ $reject->days_taken }}</td>
                            <td class="text-center">{{ $reject->refLeaveType->leave_type_name }}</td>
                            <td class="text-center">{{ $reject->from }}</td>
                            <td class="text-center">{{ $reject->to }}</td>
                            <td class="text-center">
                                <a class="btn btn-primary" href="{{ route('approver.approver_list_show', $reject)}}">
                                    Show</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $approver_list_array['rejecteds']->links() }}
            @endif
        </div>
    </div>
</div>

@endsection
