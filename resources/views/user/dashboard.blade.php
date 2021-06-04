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

        <!-- Small boxes (Stat box) -->
        @isset(Auth::user()->leavedetail)
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
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
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
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
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
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
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
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
            <!-- ./col -->
        </div>
        @endisset
        <!-- /.row -->
        <div class="row">
            <div class="{{ (Auth::user()->role_id == 3) ? 'col-lg-9' : 'col-lg-12' }} col-12 order-12 order-lg-1">
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
            @if (Auth::user()->role_id == 3)
            <div class="col-lg-3 col-12 order-1 order-lg-12 d-flex ">
                <!-- small box -->
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
            @endif
        </div>

    </div>
</div>

@endsection
