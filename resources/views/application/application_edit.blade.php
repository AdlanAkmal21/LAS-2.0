@extends('layouts.app')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit Leave Application</h1>
                <p>If you're experiencing any problems, try refreshing the page or re-select the dates.
                </p>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('application.index') }}">Application List</a></li>
                    <li class="breadcrumb-item active">Edit Leave Application</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

@include('partials._validation')
@include('partials._notifications')

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <form method="post" action="{{ route('application.update', $application->id) }}">
                @method('PATCH')
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="label">Employee ID</label>
                            <input class="form-control" type="text" name="id" readonly
                                value="{{$application->user->id}}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="label" for="leave_type_id">Leave Type</label>
                            <input class="form-control" type="text" name="leave_type_id" id="leave_type_id" readonly
                                value="{{$application->refLeaveType->leave_type_name}}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="label" for="from">From</label>
                            <input class="form-control" placeholder="yyyy-mm-dd" type="text" name="from" id="from"
                                value="{{ old('from', $application->from )}}">
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label class="label" for="to">To</label>
                            <input class="form-control" placeholder="yyyy-mm-dd" type="text" name="to" id="to"
                                value="{{ old('to', $application->to )}}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label class="label">Reason</label>
                            <input name="reason" type="text" class="form-control"
                                value="{{ old('reason', $application->reason)}}">
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label class="label" for="days_taken">Days Taken</label>
                            <input class="form-control" type="text" id="days_taken" name="days_taken"
                                readonly="readonly" value="{{ old('days_taken', $application->days_taken)}}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    @if ($application->half_day != null || $application->days_taken == 1 || $application->days_taken == 0.5)
                    <div class="col-xl-6">
                        <fieldset class="form-group row">
                            <div class="col-sm-2">
                                <label class="label">Half Day</label>
                            </div>
                            <div class="col-sm-10">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="half_day" id="morning" value="1"
                                        {{ ($application->half_day == 1) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="morning">Morning</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="half_day" id="evening" value="2"
                                        {{ ($application->half_day == 2) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="evening">Evening</label>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    @endif
                    <div class="col-xl-6">
                        <div class="float-right">
                            <button type="submit" class="btn btn-success">Update</button>
                            <a class="btn btn-danger" href="{{ route('application.index')}}">Cancel</a>
                        </div>
                    </div>

                </div>

            </form>

        </div>
    </div>
</div>

@endsection
