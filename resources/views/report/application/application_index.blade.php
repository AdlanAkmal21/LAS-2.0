@extends('layouts.app')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Application Report</h1>
                <p class="m-0 text-muted">Comprehensive report of application by type, period and more.</p>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <div class="row">
                    <div class="col">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Application Report</li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <a class="btn btn-warning btn-sm btn-sm-block float-sm-right mt-sm-1"
                            href="{{ route('print.overview_pdf') }}">
                            Generate PDF
                        </a>
                    </div>
                </div>


            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-8">
            <!-- Analystics Overview -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"><i class="fas fa-chart-area mr-1"></i> Analytics Overview</h5>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <p class="text-center">
                                <strong>Monthly Leave Type Statistic</strong>
                            </p>

                            <div class="chart">
                                <canvas id="applicationsummarychart2"></canvas>
                                <div class="no-data align-self-center" id="applicationsummarychart2none">No data
                                    available!</div>
                            </div>
                            <!-- /.chart-responsive -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-4">
                            <p class="text-center">
                                <strong>Leave Type Statistics</strong>
                            </p>

                            <div class="progress-group">
                                <span class="progress-text">Annual Leave</span>
                                <span
                                    class="float-right"><b>{{ $application_report_array['annual_count'] }}</b>/{{ $application_report_array['until_today'] }}</span>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-danger"
                                        style="width: {{ ($application_report_array['annual_count']/$application_report_array['until_today'])*100 }}%">
                                    </div>
                                </div>
                            </div>
                            <!-- /.progress-group -->

                            <div class="progress-group">
                                <span class="progress-text">Medical Leave</span>
                                <span
                                    class="float-right"><b>{{ $application_report_array['medical_count'] }}</b>/{{ $application_report_array['until_today'] }}</span>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-warning"
                                        style="width: {{ ($application_report_array['medical_count']/$application_report_array['until_today'])*100 }}%">
                                    </div>
                                </div>
                            </div>

                            <!-- /.progress-group -->
                            <div class="progress-group">
                                <span class="progress-text">Emergency Leave</span>
                                <span
                                    class="float-right"><b>{{ $application_report_array['emergency_count'] }}</b>/{{ $application_report_array['until_today'] }}</span>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-success"
                                        style="width: {{ ($application_report_array['emergency_count']/$application_report_array['until_today'])*100 }}%">
                                    </div>
                                </div>
                            </div>

                            <!-- /.progress-group -->
                            <div class="progress-group">
                                <span class="progress-text">Unrecorded Leave</span>
                                <span
                                    class="float-right"><b>{{ $application_report_array['unrecorded_count'] }}</b>/{{ $application_report_array['until_today'] }}</span>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-info"
                                        style="width: {{ ($application_report_array['unrecorded_count']/$application_report_array['until_today'])*100 }}%">
                                    </div>
                                </div>
                            </div>
                            <!-- /.progress-group -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- ./card-body -->
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-3 col-6">
                            <div class="description-block border-right">
                                <h5 class="description-header text-olive">
                                    {{ $application_report_array['this_week'] }}
                                </h5>
                                <span style="font-size: 0.7rem;"
                                    class="p-0 text-olive text-uppercase">Application(s)</span><br>
                                <span class="description-text"><a
                                        href="{{ route('report.application_period_overview',1) }}"
                                        class="stretched-link text-decoration-none text-reset">This Week</a></span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-3 col-6">
                            <div class="description-block border-right">
                                <h5 class="description-header text-orange">
                                    {{ $application_report_array['this_month'] }}
                                </h5>
                                <span style="font-size: 0.7rem;"
                                    class="p-0 text-orange text-uppercase">Application(s)</span><br>
                                <span class="description-text"><a
                                        href="{{ route('report.application_period_overview',2) }}"
                                        class="stretched-link text-decoration-none text-reset">This Month</a></span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-3 col-6">
                            <div class="description-block border-right">
                                <h5 class="description-header text-purple">
                                    {{ $application_report_array['this_year'] }}
                                </h5>
                                <span style="font-size: 0.7rem;"
                                    class="p-0 text-purple text-uppercase">Application(s)</span><br>
                                <span class="description-text"><a
                                        href="{{ route('report.application_period_overview',3) }}"
                                        class="stretched-link text-decoration-none text-reset">This Year</a></span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-3 col-6">
                            <div class="description-block">
                                <h5 class="description-header text-pink">
                                    {{ $application_report_array['until_today'] }}
                                </h5>
                                <span style="font-size: 0.7rem;"
                                    class="p-0 text-pink text-uppercase">Application(s)</span><br>

                                <span class="description-text"><a
                                        href="{{ route('report.application_period_overview',4) }}"
                                        class="stretched-link text-decoration-none text-reset">Until
                                        Today</a></span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.card-footer -->
            </div>

            <!-- Search Application -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"><i class="fas fa-search mr-1"></i>Search Application</h5>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <p>Click below to search for application(s).</p>
                    <a href="{{ route('admin.search_application') }}" class="btn btn-info btn-block">Search Application</a>
                </div>
                <!-- ./card-body -->
            </div>

            <!-- Employee List -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-users mr-1"></i>
                        Employee List
                    </h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form class="d-flex align-items-center flex-nowrap mb-2" method="GET"
                        action="{{route('report.search_application_employee')}}">
                        <input type="text" class="form-control mr-sm-2" name="search" placeholder="Search"
                            aria-label="Search" value="@if(!empty($query)) {{$query}} @endif">
                        <button type="submit" class="btn btn-outline-success">Search</button>
                    </form>

                    @if (!$users->isEmpty())
                    <div class="table-responsive-lg">
                        <table class="table table-sm table-bordered table-striped container">
                            <thead class="table-dark">
                                <tr class="d-flex text-center">
                                    <th class="col-1">#</th>
                                    <th class="col-6">Employee Name</th>
                                    <th class="col-2 text-center">Balance Leaves</th>
                                    <th class="col-3 text-center">Total Applications</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $key => $user)
                                <tr class="d-flex">
                                    <td class="col-1">{{ $users->firstItem() + $key }}.</td>
                                    <td class="col-6">
                                        <a href="{{ route('admin.show', $user->id) }}">{{ $user->name }}</a>
                                    </td>
                                    <td class="col-2 text-center">
                                        {{ ($user->leavedetail)?($user->leavedetail->balance_leaves):'N/A' }}
                                    </td>
                                    <td class="col-3 text-center"><a
                                            href="{{ route('admin.application_list_employee', $user->id) }}">{{ $user->application->count() }}
                                            application(s)</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $users->links() }}
                    @else
                    <div class="card">
                        <div class="card-body text-center">
                            <span>No record found.</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"><i class="fas fa-chart-pie mr-1"></i>Pie Chart</h5>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->

                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <canvas id="applicationsummarychart"></canvas>
                            <div class="no-data align-self-center" id="applicationsummarychartnone">No data
                                available!</div>
                        </div>
                        <div class="col-6 d-flex align-items-center">
                            <ul class="chart-legend">
                                <li><i class="fas fa-circle text-danger mr-2"></i>Annual Leave</li>
                                <li><i class="fas fa-circle text-warning mr-2"></i>Medical Leave</li>
                                <li><i class="fas fa-circle text-success mr-2"></i>Emergency Leave</li>
                                <li><i class="fas fa-circle text-info mr-2"></i>Unrecorded Leave</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-chart-line mr-1"></i> Most Applications This Month</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <ul class="products-list product-list-in-card pl-2 pr-2">
                        @foreach ($most_this_month as $most)
                        <li class="pt-2 px-2">
                            <a href="{{ route('admin.application_list_employee', $most->id) }}"
                                class="text-weight-bold">{{ $most->name }}
                                <span class="badge badge-warning float-right">{{ $most->application_count }}
                                    application(s)</span>
                            </a>
                            <p><span>{{ $most->refRole->role_name }}</span></p>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="card-footer">
                    {{ $most_this_month->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
