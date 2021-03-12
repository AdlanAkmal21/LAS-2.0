@extends('layouts.app')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Application Show <span class="text-primary">(ID: {{ $application->id }})</span></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('application.index') }}">Application List</a>
                    </li>
                    <li class="breadcrumb-item active">Application Show</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-xl-6 col-lg-6">
                    <div class="form-group">
                        <label class="label" for="name">Employee Name</label>
                        <input class="form-control" type="text" name="name" disabled
                            value="{{$application->user->name}}">
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6">
                    <div class="form-group">
                        <label class="label" for="leave_type_id">Leave Type</label>
                        <input class="form-control" type="text" name="leave_type_id" disabled
                            value="{{$application->refLeaveType->leave_type_name}}">
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-6 col-lg-6">
                    <div class="form-group">
                        <label class="label" for="from">From</label>
                        <input class="form-control" type="date" value="{{$application->from}}" disabled name="from"
                            id="from">
                    </div>
                </div>

                <div class="col-xl-6 col-lg-6">
                    <div class="form-group">
                        <label class="label" for="to">To</label>
                        <input class="form-control" type="date" value="{{$application->to}}" disabled name="to" id="to">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="{{ (isset($application->half_day)) ? 'col-xl-6 col-lg-6' : 'col-xl-12 col-lg-12' }}">
                    <div class="form-group">
                        <label class="label" for="days_taken">Days Taken</label>
                        <input class="form-control" type="text" value="{{$application->days_taken}}" disabled
                            name="days_taken" id="days_taken">
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6">
                    @if($application->half_day != null)
                    <div class="form-group">
                        <label class="label" for="half_day">Half Day:</label>
                        <input class="form-control" type="text"
                            value="{{ ($application->half_day==1) ? 'Morning' : (($application->half_day==2) ? 'Evening' : 'Null') }}"
                            disabled name="half_day" id="half_day">
                    </div>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-xl-6 col-lg-6">
                    <div class="form-group">
                        <label class="label" for="approver_id">Approved By</label>
                        <input class="form-control" type="text"
                            value="{{ ($application->user->userdetail->approver_id==null) ? 'None' : $application->user->userdetail->approver->name }}"
                            disabled name="approver_id" id="approver_id">
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6">
                    <div class="form-group">
                        <label class="label" for="reason">Reason</label>
                        <input class="form-control" type="text" value="{{$application->reason}}" disabled name="reason"
                            id="reason">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="label" for="file">Attachment:</label>
                @isset($file)
                <a class="form-control" href="{{asset("storage/$file->filecategory/$file->filename")}}"
                    name="file" id="file"><i class="fa fa-file fa-lg mr-2"></i>{{$file->filename}}</a>
                @endisset
                @empty($file)
                <input type="text" class="form-control" disabled value="No attachment available.">
                @endempty
            </div>

            <div class="row">
                <div class="{{ (isset($application->approval_date)) ? 'col-xl-6 col-lg-6' : 'col-xl-12 col-lg-12' }}">
                    <div class="form-group">
                        <label class="label" for="created_at">Applied At</label>
                        <input class="form-control" type="text"
                            value="{{date('Y-m-d (h:i:s)', strtotime($application->created_at))}}" disabled
                            name="created_at" id="created_at">
                    </div>
                </div>
                @isset($application->approval_date)
                <div class="col-xl-6 col-lg-6">
                    <div class="form-group">
                        <label for="approval_date">Approval Date:</label>
                        <input type="text" class="form-control" disabled name="approval_date" id="approval_date"
                            value="{{$application->approval_date}}">
                    </div>
                </div>
                @endisset
            </div>

            <div class="form-group">
                <label for="application_status_id">Application Status:</label>
                <input type="text"
                    class="form-control form-control-lg text-center text-monospace font-weight-bold text-uppercase {{ ($application->application_status_id == 2)?'text-success':(($application->application_status_id == 3)?'text-danger':'text-info') }}"
                    style="font-size: 32px;" disabled name="application_status_id"
                    value="{{$application->refAppStatus->application_status_name}}">
            </div>

        </div>
    </div>
</div>




@endsection
