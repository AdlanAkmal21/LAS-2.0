@extends('layouts.app')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Office Log</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Office Log</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->


<div class="container-fluid">

    <div class="container-fluid">
        <p>Search for office logs.</p>
            <form action="{{ route('office.office_logs_search') }}" method="post">
                @csrf
            <div class="form-row form-group">
                <div class="col-xl-6 col-lg-6">
                    <div class="form-group">
                        <input type="month" id="date" name="date" class="form-control form-control-sm" value="{{$year . '-' . $month}}">
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6">
                    <div class="form-row">
                        <div class="col">
                            <button type="submit" class="btn btn-primary btn-block">Search</button>
            </form>
                        </div>
                        <div class="col">
                            <form action="{{ route('print.generate_office_log') }}" method="post">
                                @csrf
                                <input type="hidden" name="month" value="{{ $month }}">
                                <input type="hidden" name="year" value="{{ $year }}">
                                <button type="submit" class="btn btn-warning btn-block">Generate PDF</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>No.</th>
                <th>Employee Name</th>
                <th>Date</th>
                <th>Period</th>
                <th>Clock In</th>
                <th>Clock Out</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($office_logs as $key => $office_log)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $office_log->user->name ?? '--' }}</td>
                <td>{{ $office_log->date ?? '--' }}</td>
                <td>{{ $office_log->period ?? '--' }}</td>
                <td>{{ $office_log->clock_in ?? '--' }}</td>
                <td>{{ $office_log->clock_out ?? '--' }}</td>
            </tr>
            @endforeach

            @if ($office_logs->isEmpty())
                <tr>
                    <td colspan="6" class="text-center">No data available.</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

@endsection
