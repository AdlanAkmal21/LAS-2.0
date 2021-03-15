@extends('layouts.app')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Overview Report</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Overview Report</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="container-fluid">
    <div class="container-fluid">
        <!-- Employee Report Graph -->
        <div class="row mb-3">
            <div class="col-xl-4 col-md-12 mb-3 mb-xl-0">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="chart-pie pt-2 pb-3">
                            <canvas id="genderchart"></canvas>
                            <div class="no-data" id="genderchartnone">No data available!</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-12 mb-3 mb-xl-0">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="chart-pie pt-2 pb-3">
                            <canvas id="roleschart"></canvas>
                            <div class="no-data" id="roleschartnone">No data available!</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-12 mb-3 mb-xl-0">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="chart-pie pt-2 pb-3">
                            <canvas id="empstatuschart"></canvas>
                            <div class="no-data" id="empstatuschartnone">No data available!</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Employee Report -->
        <div class="row mb-3">
            <div class="col">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Employee Report</h6>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="label" for="employees_count">Total Employees:</label>
                                    <input class="form-control" type="text" name="employees_count" disabled
                                        value="{{$dashboard_admins_array['employees_count']}}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="label" for="working_count">Total Working Employees:</label>
                                    <input class="form-control" type="text" name="working_count" disabled
                                        value="{{$dashboard_admins_array['working_count']}}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="label" for="resigned_count">Total Resign Employees:</label>
                                    <input class="form-control" type="text" name="resigned_count" disabled
                                        value="{{$dashboard_admins_array['resigned_count']}}">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="label" for="admin_count">Total Employees (Admin):</label>
                                    <input class="form-control" type="text" name="admin_count" disabled
                                        value="{{$dashboard_admins_array['admin_count']}}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="label" for="employee_count">Total Employees
                                        (Employee):</label>
                                    <input class="form-control" type="text" name="employee_count" disabled
                                        value="{{$dashboard_admins_array['employee_count']}}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="label" for="approver_count">Total Employees
                                        (Approver):</label>
                                    <input class="form-control" type="text" name="approver_count" disabled
                                        value="{{$dashboard_admins_array['approver_count']}}">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="label" for="male_count">Total Male:</label>
                                    <input class="form-control" type="text" name="male_count" disabled
                                        value="{{$dashboard_admins_array['male_count']}}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="label" for="female_count">Total Female:</label>
                                    <input class="form-control" type="text" name="female_count" disabled
                                        value="{{$dashboard_admins_array['female_count']}}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Leave Report-->
        <div class="row mb-3">
            <div class="col">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Leave Report</h6>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="label" for="annual_e_average">Annual Entitlement Average (Per
                                        Employee):</label>
                                    <input class="form-control" type="text" name="annual_e_average" disabled
                                        value="{{$dashboard_admins_array['annual_e_average']}}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="label" for="carry_over_sum">Total Carry Over (This
                                        Year):</label>
                                    <input class="form-control" type="text" name="carry_over_sum" disabled
                                        value="{{$dashboard_admins_array['carry_over_sum']}}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="label" for="balance_leaves_sum">Total Available Leaves (This
                                        Year):</label>
                                    <input class="form-control" type="text" name="balance_leaves_sum" disabled
                                        value="{{$dashboard_admins_array['balance_leaves_sum']}}">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="label" for="taken_so_far_sum">Total Leave Days Takens (This
                                        Year):</label>
                                    <input class="form-control" type="text" name="taken_so_far_sum" disabled
                                        value="{{$dashboard_admins_array['taken_so_far_sum']}}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="label" for="taken_so_far_sum_average">Average Leave Days
                                        Takens (Per Employee):</label>
                                    <input class="form-control" type="text" name="taken_so_far_sum_average" disabled
                                        value="{{$dashboard_admins_array['taken_so_far_sum_average']}}">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Application Report Graph -->
        <div class="row mb-3">
            <div class="col-xl-6 col-md-12 mb-3 mb-xl-0">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="chart-pie pt-2 pb-3">
                            <canvas id="thisyearapplicationchart"></canvas>
                            <div class="no-data" id="thisyearapplicationchartnone">No data available!</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-12 mb-3 mb-xl-0">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="chart-pie pt-2 pb-3">
                            <canvas id="applicationstatuschart"></canvas>
                            <div class="no-data" id="applicationstatuschartnone">No data available!</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Application Report -->
        <div class="row mb-3">
            <div class="col">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Application Report</h6>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="label" for="applications_count">Total Applications:</label>
                                    <input class="form-control" type="text" name="applications_count" disabled
                                        value="{{$dashboard_admins_array['applications_count']}}">
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="label" for="applications_this_year_count">Total Applications
                                        (This Year):</label>
                                    <input class="form-control" type="text" name="applications_this_year_count" disabled
                                        value="{{$dashboard_admins_array['applications_this_year_count']}}">
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="label" for="applications_this_year_count">Total Applications
                                        (Other Year):</label>
                                    <input class="form-control" type="text" name="applications_this_year_count" disabled
                                        value="{{$dashboard_admins_array['applications_other_year_count']}}">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="label" for="pending_count">Total Pending Application:</label>
                                    <input class="form-control" type="text" name="pending_count" disabled
                                        value="{{$dashboard_admins_array['pending_count']}}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="label" for="approve_count">Total Approved
                                        Applications:</label>
                                    <input class="form-control" type="text" name="approve_count" disabled
                                        value="{{$dashboard_admins_array['approve_count']}}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="label" for="reject_count">Total Rejected Applications:</label>
                                    <input class="form-control" type="text" name="reject_count" disabled
                                        value="{{$dashboard_admins_array['reject_count']}}">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="label" for="pending_this_year_count">Total Pending Application
                                        (This Year):</label>
                                    <input class="form-control" type="text" name="pending_this_year_count" disabled
                                        value="{{$dashboard_admins_array['pending_this_year_count']}}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="label" for="approve_this_year_count">Total Approved
                                        Applications (This Year):</label>
                                    <input class="form-control" type="text" name="approve_this_year_count" disabled
                                        value="{{$dashboard_admins_array['approve_this_year_count']}}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="label" for="reject_this_year_count">Total Rejected
                                        Applications (This Year):</label>
                                    <input class="form-control" type="text" name="reject_this_year_count" disabled
                                        value="{{$dashboard_admins_array['reject_this_year_count']}}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Holiday Report Graph -->
        <div class="row mb-3">
            <div class="col-12 mb-3 mb-xl-0">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="chart-pie pt-2 pb-3">
                            <canvas id="daytotalchart"></canvas>
                            <div class="no-data" id="daytotalchartnone">No data available!</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12 mb-3 mb-xl-0">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="chart-pie pt-2 pb-3">
                            <canvas id="monthtotalchart"></canvas>
                            <div class="no-data" id="monthtotalchartnone">No data available!</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Holiday Report -->
        <div class="row mb-3">
            <div class="col">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Holiday Report</h6>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="label" for="holidays_count">Total Public Holidays (This
                                        Year):</label>
                                    <input class="form-control" type="text" name="holidays_count" disabled
                                        value="{{$dashboard_admins_array['holidays_count']}}">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="label" for="monday_count">Total Mondays:</label>
                                    <input class="form-control" type="text" name="monday_count" disabled
                                        value="{{$dashboard_admins_array['monday_count']}}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="label" for="tuesday_count">Total Tuesdays:</label>
                                    <input class="form-control" type="text" name="tuesday_count" disabled
                                        value="{{$dashboard_admins_array['tuesday_count']}}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="label" for="wednesday_count">Total Wednesdays:</label>
                                    <input class="form-control" type="text" name="wednesday_count" disabled
                                        value="{{$dashboard_admins_array['wednesday_count']}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="label" for="thursday_count">Total Thursday:</label>
                                    <input class="form-control" type="text" name="thursday_count" disabled
                                        value="{{$dashboard_admins_array['thursday_count']}}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="label" for="friday_count">Total Friday:</label>
                                    <input class="form-control" type="text" name="friday_count" disabled
                                        value="{{$dashboard_admins_array['friday_count']}}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="label" for="saturday_count">Total Saturday:</label>
                                    <input class="form-control" type="text" name="saturday_count" disabled
                                        value="{{$dashboard_admins_array['saturday_count']}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="label" for="sunday_count">Total Sunday:</label>
                                    <input class="form-control" type="text" name="sunday_count" disabled
                                        value="{{$dashboard_admins_array['sunday_count']}}">
                                </div>
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="label" for="january_count">Total January:</label>
                                    <input class="form-control" type="text" name="january_count" disabled
                                        value="{{$dashboard_admins_array['january_count']}}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="label" for="february_count">Total February:</label>
                                    <input class="form-control" type="text" name="february_count" disabled
                                        value="{{$dashboard_admins_array['february_count']}}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="label" for="march_count">Total March:</label>
                                    <input class="form-control" type="text" name="march_count" disabled
                                        value="{{$dashboard_admins_array['march_count']}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="label" for="april_count">Total April:</label>
                                    <input class="form-control" type="text" name="april_count" disabled
                                        value="{{$dashboard_admins_array['april_count']}}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="label" for="may_count">Total May:</label>
                                    <input class="form-control" type="text" name="may_count" disabled
                                        value="{{$dashboard_admins_array['may_count']}}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="label" for="june_count">Total June:</label>
                                    <input class="form-control" type="text" name="june_count" disabled
                                        value="{{$dashboard_admins_array['june_count']}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="label" for="july_count">Total July:</label>
                                    <input class="form-control" type="text" name="july_count" disabled
                                        value="{{$dashboard_admins_array['july_count']}}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="label" for="august_count">Total August:</label>
                                    <input class="form-control" type="text" name="august_count" disabled
                                        value="{{$dashboard_admins_array['august_count']}}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="label" for="september_count">Total September:</label>
                                    <input class="form-control" type="text" name="september_count" disabled
                                        value="{{$dashboard_admins_array['september_count']}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="label" for="october_count">Total October:</label>
                                    <input class="form-control" type="text" name="october_count" disabled
                                        value="{{$dashboard_admins_array['october_count']}}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="label" for="november_count">Total November:</label>
                                    <input class="form-control" type="text" name="november_count" disabled
                                        value="{{$dashboard_admins_array['november_count']}}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="label" for="december_count">Total December:</label>
                                    <input class="form-control" type="text" name="december_count" disabled
                                        value="{{$dashboard_admins_array['december_count']}}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
