@extends('layouts.app')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header pb-0">
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-sm-6">
                <div class="row">
                    <div class="col">
                        <h1 class=" text-dark">{{ $application_period_array["period_title"] }}</h1>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col">
                        <p>List of Application(s) Applied {{ $application_period_array["period_title"] }}.</p>
                    </div>
                </div>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <div class="row">
                    <div class="col">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('report.application') }}">Application
                                    Report</a></li>
                            <li class="breadcrumb-item active">{{ $application_period_array["period_title"] }}</li>
                        </ol>
                    </div>
                </div>

                @if (!$application_period_array["applications"]->isEmpty())
                <div class="row mt-2">
                    <div class="col text-right">
                        <a class="btn btn-warning btn-sm" href="{{ route('print.period_pdf', $period) }}">Generate PDF</a>
                        <a class="btn btn-success btn-sm" href="{{ route('print.period_xlsx', $period) }}">Generate Spreadsheet</a>
                    </div>
                </div>
                @endif
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="container-fluid" id="Period_PDF">

    @if (!$application_period_array["applications"]->isEmpty())
    <div class="container-fluid">
        <div class="container-fluid small p-0 my-3">
            <div class="row">
                <div class="col-3">
                    <div class="btn-group btn-block" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-danger">Annual Leave</button>
                        <button type="button" class="btn btn-dark">
                            {{ $application_period_array["applications_all"]->where('leave_type_id',1)->count()}}
                        </button>
                      </div>
                </div>
                <div class="col-3">
                    <div class="btn-group btn-block" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-warning">Medical Leave</button>
                        <button type="button" class="btn btn-dark">
                            {{ $application_period_array["applications_all"]->where('leave_type_id',2)->count()}}
                        </button>
                      </div>
                </div>
                <div class="col-3">
                    <div class="btn-group btn-block" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-success">Emergency Leave</button>
                        <button type="button" class="btn btn-dark">
                            {{ $application_period_array["applications_all"]->where('leave_type_id',3)->count()}}
                        </button>
                      </div>
                </div>
                <div class="col-3">
                    <div class="btn-group btn-block" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-info">Unrecorded Leave</button>
                        <button type="button" class="btn btn-dark">
                            {{ $application_period_array["applications_all"]->where('leave_type_id',4)->count()}}
                        </button>
                      </div>
                </div>
            </div>
        </div>


        <div class="table-responsive-lg">
            <table class="table table-sm table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Applicant Name</th>
                        <th>Leave Type</th>
                        <th>From</th>
                        <th>To</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($application_period_array["applications"] as $key => $application)
                    <tr>
                        <td>{{ $application_period_array["applications"]->firstItem() + $key }}.</td>
                        <td>{{ $application->user->name }}</td>
                        <td>{{ $application->refLeaveType->leave_type_name }}</td>
                        <td>{{ $application->from }}</td>
                        <td>{{ $application->to }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{ $application_period_array["applications"]->links() }}
    @else
    <div class="container-fluid">
        <div class="card">
            <div class="card-body text-center">
                <span>No application(s) found.</span>
            </div>
        </div>
    </div>
    @endif

</div>

@endsection
