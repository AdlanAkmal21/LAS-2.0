@extends('layouts.app')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Admin</li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="container-fluid">
    <div class="row py-3">
        <div class="col-md-8 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col">
                    <div id='calendar_month'></div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div id='calendar_list'></div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col">
                    <div class="small-box bg-info small">
                        <div class="inner">
                            <h3>{{$dashboard_admins_array['employees_count']}}</h3>

                            <p>Total Employees</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <a href="{{ route('admin.employee_list') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="small-box bg-danger small">
                        <div class="inner">
                            <h3 class="m-0">{{$dashboard_admins_array['resigned_count']}}</h3>
                            <p class="m-0">Total Resigned</p>
                            <p class="m-0">Employees</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-times"></i>
                        </div>
                        <a href="{{ route('admin.search_resigned') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="small-box bg-success small">
                        <div class="inner">
                            <h3 class="m-0">{{$dashboard_admins_array['applications_count']}}</h3>
                            <p class="m-0">Total Applications</p>
                            <p class="m-0">(Overall)</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-book"></i>
                        </div>
                        <a href="{{ route('admin.application_list') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="small-box bg-warning small">
                        <div class="inner">
                            <h3 class="m-0">{{$dashboard_admins_array['applications_this_year_count']}}</h3>
                            <p class="m-0">Total Applications</p>
                            <p class="m-0">(This Year)</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-book"></i>
                        </div>
                        <a href="{{ route('admin.application_list_ty', now()->year ) }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="small-box bg-info flex-fill small">
                        <div class="inner">
                            <h3 class="m-0">{{$dashboard_admins_array['taken_so_far_sum']}}</h3>
                            <p class="m-0">Total Leave Days Taken</p>
                            <p class="m-0">(This Year)</p>
                        </div>
                        <div class="icon">
                            <i class="far fa-sticky-note"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="small-box bg-purple small">
                        <div class="inner">
                            <h3 class="m-0">{{$dashboard_admins_array['holidays_count']}}</h3>
                            <p class="m-0">Total Holidays</p>
                            <p class="m-0">(This Year)</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <a href="{{ route('holiday.index') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>

    document.addEventListener('DOMContentLoaded', function() {
        var calendar_month = document.getElementById('calendar_month');
        var calendar_list = document.getElementById('calendar_list');
        var objects = <?php echo $offdutyArray['offduty_calendar'] ?>;

        var calendarMonth = new FullCalendar.Calendar(calendar_month, {
            timeZone: 'Asia/Kuala_Lumpur',
            themeSystem: 'bootstrap',
            initialView: 'dayGridMonth',
            height: 500,
            events: objects
        });

        var calendarList = new FullCalendar.Calendar(calendar_list, {
            timeZone: 'Asia/Kuala_Lumpur',
            themeSystem: 'bootstrap',
            initialView: 'listWeek',
            height: 350,
            events: objects,
        });

        calendarMonth.render();
        calendarList.render();
    });

</script>
@endpush

@endsection
