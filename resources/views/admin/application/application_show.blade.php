@extends('layouts.app')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-sm-6">
                <div class="row">
                    <div class="col">
                        <h1 class="m-0 text-dark">Application Show</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col mt-2">
                        <p>Show application details for application (ID: {{ $application->id }} )</p>
                    </div>
                </div>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <div class="row">
                    <div class="col">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.application_list') }}">Application
                                    List</a>
                            </li>
                            <li class="breadcrumb-item active">Application Show</li>
                        </ol>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col text-right">
                        <a href="{{ route('print.generate_application_pdf', $application) }}" class="btn btn-sm btn-warning">Generate PDF</a>
                    </div>
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <form>
                <div class="row">
                    <div class="col-12 col-xl-6 col-lg-6">
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Employee Name</label>
                            <div class="col-sm-9">
                                <input type="text" disabled class="form-control form-control-sm" id="name"
                                    value="{{$application->user->name}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-6 col-lg-6">
                        <div class="form-group row">
                            <label for="approver_id" class="col-sm-3 col-form-label">Approved By</label>
                            <div class="col-sm-9">
                                <input type="text" disabled class="form-control form-control-sm" id="approver_id"
                                    value="{{ ($application->user->userdetail->approver_id==null) ? 'None' : $application->user->userdetail->approver->name }}">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <form>
                <div class="form-row">
                    <div class="col-12 col-xl-6 col-lg-6">
                        <div class="form-group row">
                            <label for="leave_type_id" class="col-sm-3 col-form-label">Leave Type</label>
                            <div class="col-sm-9">
                                <input type="text" disabled class="form-control form-control-sm" id="leave_type_id"
                                    value="{{$application->refLeaveType->leave_type_name}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-6 col-lg-6">
                        <div class="form-group row">
                            <label for="from" class="col-sm-3 col-form-label">From - To</label>
                            <div class="col-sm-9">
                                <div class="row">
                                    <div class="col">
                                        <input type="text" disabled class="form-control form-control-sm" id="from"
                                            value="{{$application->from}}">
                                    </div>
                                    <div class="col">
                                        <input type="text" disabled class="form-control form-control-sm" id="to"
                                            value="{{$application->to}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-12 col-xl-6 col-lg-6">
                        <div class="form-group row">
                            <label for="days_taken" class="col-sm-3 col-form-label">Days Taken</label>
                            <div class="col-sm-9">
                                <input type="text" disabled class="form-control form-control-sm" id="days_taken"
                                    value="{{$application->days_taken}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-6 col-lg-6">
                        <div class="form-group row">
                            <label for="half_day" class="col-sm-3 col-form-label">Half Day</label>
                            <div class="col-sm-9">
                                <input type="text" disabled class="form-control form-control-sm" id="half_day"
                                    value="{{ ($application->half_day==1) ? 'Morning' : (($application->half_day==2) ? 'Evening' : 'None') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-12 col-xl-6 col-lg-6">
                        <div class="form-group row">
                            <label for="reason" class="col-sm-3 col-form-label">Reason</label>
                            <div class="col-sm-9">
                                <input type="text" disabled class="form-control form-control-sm" id="reason"
                                    value="{{ ($application->reason == '')? 'None' : $application->reason}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-6 col-lg-6">
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">Attachment</label>
                            <div class="col-sm-9">
                                @isset($file)
                                <a class="form-control border-0"
                                    href="{{asset("storage/$file->filecategory/$file->filename")}}" name="file"
                                    id="file"><i class="fa fa-file fa-lg mr-2"></i>{{$file->filename}}</a>
                                @endisset
                                @empty($file)
                                <input type="text" class="form-control form-control-sm" disabled
                                    value="No attachment available.">
                                @endempty
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-12 col-xl-6 col-lg-6">
                        <div class="form-group row">
                            <label for="created_at" class="col-sm-3 col-form-label">Applied At</label>
                            <div class="col-sm-9">
                                <input type="text" disabled class="form-control form-control-sm" id="created_at"
                                    value="{{date('Y-m-d (h:i:s)', strtotime($application->created_at))}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-6 col-lg-6">
                        <div class="form-group row">
                            <label for="approval_date" class="col-sm-3 col-form-label">Approval Date</label>
                            <div class="col-sm-9">
                                <input type="text" disabled class="form-control form-control-sm" id="approval_date"
                                    value="{{($application->approval_date == null)?'None':$application->approval_date}}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-12 col-xl-6 col-lg-6">
                        <div class="form-group row">
                            <label for="application_status_id" class="col-sm-3 col-form-label">Application
                                Status</label>
                            <div class="col-sm-9">
                                <input type="text" disabled
                                    class="form-control form-control-sm {{ ($application->application_status_id == 2)?'text-success':(($application->application_status_id == 3)?'text-danger':'text-info') }}"
                                    id="application_status_id"
                                    value="{{$application->refAppStatus->application_status_name}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-6 col-lg-6"></div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
