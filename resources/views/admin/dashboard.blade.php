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
    <!-- Row (Cards) -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
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
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
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
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
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
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
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
        <!-- ./col -->
    </div>
    <!-- /.row -->

    <!-- Row (Off-Duty & Cards) -->
    <div class="row">
        <div class="col-lg-9 col-12 order-12 order-lg-1 d-flex align-items-stretch">
            <div class="card flex-fill">
                <div class="card-header">
                    <h3 class="card-title">Off-Duty</h3>
                </div>
                @if(!$offdutyArray['offduty']->isEmpty())
                <div class="card-body">
                    <div class="mb-3">
                        <p class="m-0">Number of Off-Duty Employees: {{$offdutyArray['offduty_count']}}</p>
                        <p class="m-0">Number of Active Application(s): {{$offdutyArray['offduty']->count()}}</p>
                    </div>
                    <div class="table-responsive-lg">
                        <table class="table table-sm table-bordered table-striped container">
                            <thead>
                                <tr class="d-flex">
                                    <th class="col-1">#</th>
                                    <th class="col-5">Employee Name</th>
                                    <th class="col-3">From</th>
                                    <th class="col-3">To</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($offdutyArray['offduty'] as $key => $off)
                                <tr class="d-flex">
                                    <td class="col-1">{{$offdutyArray['offduty']->firstItem()+$key}}</td>
                                    <td class="col-5">{{$off->user->name}}</td>
                                    <td class="col-3">{{$off->from}}</td>
                                    <td class="col-3">{{$off->to}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $offdutyArray['offduty']->links() }}
                </div>
                @else
                <div class="card-body d-flex align-items-center justify-content-center">
                    <span class="text-uppercase">
                        All Employees Are Working
                    </span>
                </div>
                @endif
            </div>
        </div>

        <div class="col-lg-3 col-12 order-1 order-lg-12">
            <div class="row">
                <div class="col-lg-12 col-6 d-flex align-items-stretch">
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
                <div class="col-lg-12 col-6">
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
    <!-- /.row -->

</div>

@endsection
