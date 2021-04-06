@extends('layouts.app')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Search Application</h1>
                <p class="m-0 text-muted">Search application(s) by Leave Type, 'From' & 'To' dates.</p>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Search Application</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="container-fluid">
    <div class="container mb-3">
        <form action="{{ route('admin.search_application_search') }}" method="post">
            @csrf
            <div class="row">
                <div class="col">
                    <label for="from">From</label>
                    <input class="form-control form-control-sm" type="date" name="from" id="from"
                        value="{{ old('from') }}">
                </div>
                <div class="col">
                    <label for="to">To</label>
                    <input class="form-control form-control-sm" type="date" name="to" id="to" value="{{ old('to') }}">
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="leave_type_id">Leave Type</label>
                    <select class="form-control form-control-sm" name="leave_type_id" id="leave_type_id">
                        <option selected disabled value="0">Select Leave Type</option>
                        @foreach ($refLeaveTypes as $refLeaveType)
                        <option @if(old('leave_type_id')==$refLeaveType->id
                            )
                            selected
                            @endif
                            value="{{$refLeaveType->id}}">{{$refLeaveType->leave_type_name}}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-primary btn-sm mt-4">Submit</button>
                    <button type="reset" class="btn btn-danger btn-sm mt-4">Clear</button>
                </div>
            </div>
        </form>
    </div>

    <div class="container">
        @if ($applications->isEmpty())
        <div class="card">
            <div class="card-body">
                <span>No records found.</span>
            </div>
        </div>
        @else
        <div class="table-responsive">
            <table class="table table-sm table-bordered table-striped text-center">
                <thead class="table-dark">
                    <tr>
                        <th>#.</th>
                        <th>Applicant Name</th>
                        <th>Leave Type</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Days Taken</th>
                        <th>Balance Leave</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($applications as $key => $application)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="text-left">{{ $application->user->name }}</td>
                        <td>{{ $application->refLeaveType->leave_type_name }}</td>
                        <td>{{ $application->from }}</td>
                        <td>{{ $application->to }}</td>
                        <td>{{ $application->days_taken }}</td>
                        <td>{{ $application->user->leavedetail->balance_leaves }}</td>
                        <td>
                            <a href="{{ route('admin.application_show', $application) }}"
                                class="btn btn-primary">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $applications->links() }}
        </div>
        @endif

    </div>
</div>

@endsection
