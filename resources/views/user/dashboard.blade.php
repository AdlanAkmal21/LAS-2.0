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
                    <li class="breadcrumb-item active">{{ Auth::user()->refRole->role_name }}</li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="container-fluid">
    <div class="container-fluid">

        @include('partials._notifications')

        <div class="row pt-3">
            <div class="col-md-8 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col">
                        <div class="card flex-fill">
                            <div class="card-header">
                                <h3 class="card-title">Work Board</h3>
                            </div>
                            <div class="card-body">
                                <h6 id="date"></h6>
                                <h1 id="clock" class="display-4"></h1>
                                <p>First time user? Consider changing your password.</p>
                                <a class="btn btn-warning btn-sm btn-block" href="{{ route('reset.view')}}">Change
                                    Password</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col pb-4">
                        <div id="calendar_month"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col">
                        <div class="small-box bg-warning small">
                            <div class="inner">
                                <h3 class="m-0">{{ Auth::user()->leavedetail->taken_so_far }}</h3>
                                <p class="m-0">Leave Days Taken</p>
                                <p class="m-0">(This Year)</p>
                            </div>
                            <div class="icon">
                                <i class="far fa-sticky-note"></i>
                            </div>
                            <a href="{{ route('user.show', Auth::id()) }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="small-box bg-primary small">
                            <div class="inner">
                                <h3 class="m-0">{{ Auth::user()->leavedetail->balance_leaves }}</h3>
                                <p class="m-0">Available Leave</p>
                                <p class="m-0">(This Year)</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-question"></i>
                            </div>
                            <a href="{{ route('user.show', Auth::id()) }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="small-box bg-purple small">
                            <div class="inner">
                                <h3 class="m-0">{{$dashboard_user_array['applications_count']}}</h3>
                                <p class="m-0">Total Applications</p>
                                <p class="m-0">(Overall)</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-book"></i>
                            </div>
                            <a href="{{ route('application.index')}}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="small-box bg-success small">
                            <div class="inner">
                                <h3 class="m-0">{{$dashboard_user_array['applications_count_this_year']}}</h3>
                                <p class="m-0">Total Applications</p>
                                <p class="m-0">(This Year)</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-book"></i>
                            </div>
                            <a href="{{ route('application.index_ty', now()->year) }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                @if (Auth::user()->role_id == 3)
                    <div class="row">
                        <div class="col">
                            <div class="small-box bg-danger small flex-fill d-flex flex-column">
                                <div class="inner">
                                    <h3 class="m-0">{{$dashboard_pendings}}</h3>
                                    <p class="m-0">Applicants Pending</p>
                                    <p class="m-0">Requests</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-exclamation-circle"></i>
                                </div>
                                <a href="{{ route('approver.approver_list')}}" class="mt-auto small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="row pb-3">
            <div class="col">
                <div id="calendar_list"></div>
            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>

    document.addEventListener('DOMContentLoaded', function() {
        var calendar_month = document.getElementById('calendar_month');
        var calendar_list = document.getElementById('calendar_list');
        var objects = <?php echo $dashboard_user_array['applications_this_year'] ?>;

        var calendarMonth = new FullCalendar.Calendar(calendar_month, {
            timeZone: 'Asia/Kuala_Lumpur',
            themeSystem: 'bootstrap',
            initialView: 'dayGridMonth',
            height: 450,
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
