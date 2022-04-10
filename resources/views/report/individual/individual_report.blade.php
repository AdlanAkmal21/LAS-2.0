@extends('layouts.app')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Individual Report</h1>
                <h4 class="m-0 text-dark">({{ $user->name }} - <span class="text-primary">ID: {{ $user->id }}</span> )</h4>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('report.individual') }}">Individual Report List</a>
                    </li>
                    <li class="breadcrumb-item active">Individual Report</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="container-fluid">
    <!-- Employee Details-->
    <div class="card my-3">
        <div class="card-header">{{ __('Employee Detail') }}</div>
        <div class="card-body">

            <div class="row">
                <div class="col-xl-12">
                    <div class="form-group">
                        <label class="label" for="name">Employee Name</label>
                        <input class="form-control" type="text" name="name" disabled value="{{ $user->name }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-6">
                    <div class="form-group">
                        <label class="label" for="email">Email</label>
                        <input class="form-control" type="email" name="email" disabled value="{{ $user->email }}">
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group">
                        <label class="label" for="phoneNum">Phone Number</label>
                        <input class="form-control" type="text" name="phoneNum" disabled
                            value="{{ $user->userdetail->phoneNum }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-6">
                    <div class="form-group">
                        <label class="label" for="date_joined">Date Joined</label>
                        <input class="form-control" type="date" name="date_joined" disabled
                            value="{{ $user->userdetail->date_joined }}">
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group">
                        <label class="label" for="approver_id">Approved By</label>
                        <input class="form-control" type="text" name="approver_id" disabled
                            value="{{ ($user->userdetail->approver_id == null) ? 'None' : $user->userdetail->approver->name }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-6">
                    <div class="form-group">
                        <label class="label" for="role_id">Role</label>
                        <input class="form-control" type="text" name="role_id" disabled
                            value="{{ $user->refRole->role_name }}">
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group">
                        <label class="label" for="emp_status_id">Employee Status</label>
                        <input class="form-control" type="text" name="emp_status_id" disabled
                            value="{{ $user->refEmpStatus->emp_status_name }}">
                    </div>
                </div>
            </div>


        </div>
    </div>

    <!-- Leave Details Validation -->
    @if ($user->leavedetail)
    <!-- Leave Details -->
    <div class="card my-3">
        <div class="card-header">{{ __('Leave Details') }}</div>
        <div class="card-body">

            <div class="row">
                <div class="col-xl-6">
                    <div class="form-group">
                        <label class="label" for="annual_e">Annual Entitlement</label>
                        <input class="form-control" type="text" name="annual_e" disabled
                            value="{{ $user->leavedetail->annual_e }}">
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group">
                        <label class="label" for="carry_over">Carry Over</label>
                        <input class="form-control" type="text" name="carry_over" disabled
                            value="{{ $user->leavedetail->carry_over }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-6">
                    <div class="form-group">
                        <label class="label" for="total_leaves">Total Leaves (Current Year)</label>
                        <input class="form-control" type="text" name="total_leaves" disabled
                            value="{{ $user->leavedetail->total_leaves }}">
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group">
                        <label class="label" for="taken_so_far">Leaves Taken (Current Year)</label>
                        <input class="form-control" type="text" name="taken_so_far" disabled
                            value="{{ $user->leavedetail->taken_so_far }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="form-group">
                        <label class="label" for="balance_leaves">Balance Leaves</label>
                        <input class="form-control" type="text" name="balance_leaves" disabled
                            value="{{ $user->leavedetail->balance_leaves }}">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Application Details -->
    <div class="row my-3">
        <div class="col">
            <div class="card my-3">
                <div class="card-header">{{ __('Application Details') }}</div>
                <div class="card-body">

                    <div class="row px-2">
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label class="label" for="applications_count">Total Applications Applied
                                    (Overall)</label>
                                <input class="form-control" type="text" name="applications_count" disabled
                                    value="{{ $employee_report_array['applications_count'] }}">
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label class="label" for="applications_this_year_count">Total Applications
                                    Applied (This Year)</label>
                                <input class="form-control" type="text" name="applications_this_year_count" disabled
                                    value="{{ $employee_report_array['applications_this_year_count'] }}">
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row px-2">
                        <div class="col-xl-6 col-md-6">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label class="label" for="pending_count">Total Pending
                                            Applications</label>
                                        <input class="form-control" type="text" name="pending_count" disabled
                                            value="{{ $employee_report_array['pending_count'] }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label class="label" for="approved_count">Total Approved
                                            Applications</label>
                                        <input class="form-control" type="text" name="approved_count" disabled
                                            value="{{ $employee_report_array['approved_count'] }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label class="label" for="rejected_count">Total Rejected
                                            Applications</label>
                                        <input class="form-control" type="text" name="rejected_count" disabled
                                            value="{{ $employee_report_array['rejected_count'] }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 col-md-6">
                            <div class="chart-pie">
                                <canvas id="individualappstatuschart"></canvas>
                                <div class="no-data" id="individualappstatuschartnone">No data available!
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row px-2">
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label class="label" for="applications_days_taken_sum">Application Days
                                    Taken (This Year)</label>
                                <input class="form-control" type="text" name="applications_days_taken_sum" disabled
                                    value="{{ $employee_report_array['applications_days_taken_sum'] }}">
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label class="label" for="applications_days_taken_avg">Average Application
                                    Days Taken (Per Application)</label>
                                <input class="form-control" type="text" name="applications_days_taken_avg" disabled
                                    value="{{ $employee_report_array['applications_days_taken_avg'] }}">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @else
    <div class="card my-3">
        <div class="card-header">{{ __('Leave Details') }}</div>
        <div class="card-body text-center">
            <span>Leave Record Not Found!</span>
        </div>
    </div>

    <div class="card my-3">
        <div class="card-header">{{ __('Application Details') }}</div>
        <div class="card-body text-center">
            <span>Application Record Not Found!</span>
        </div>
    </div>
    @endif
</div>

@endsection

@push('scripts')
{{-- <script src="{{asset('assets/js/graph/individualpie.js')}}"></script> --}}
@endpush
