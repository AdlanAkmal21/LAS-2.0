@extends('layouts.app')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mt-3 mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Notifications</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Notifications</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="container-fluid">
    <div class="card">
        @if ($notifications->isEmpty())
        <div class="card-body text-center">
            <span class="text-muted">No Notifications Available</span>
        </div>
        @else
        <div class="card-body">
            <ul class="list-group">
                <form action="{{ route('user.clear_notifications')}}" method="post">
                    @csrf
                    <input role="button" class="btn btn-primary mb-3" type="submit" value="Clear Notifications">
                </form>

                @foreach ($notifications as $notification)
                <li class="list-group-item">
                    @if ($notification->type == 'App\Notifications\NewApplicationAlert')
                    <div class="row">
                        @if ($notification->data['leave_type'] == 2)
                        <div class="col-xl-9 col-lg-9">
                            <p>You have a new <strong>Medical Leave</strong> application from
                                <strong>{{ $notification->data['applicant_name']}}</strong>
                            </p>
                            <p><small>Applied at: <u>{{$notification->data['created_at']}}</u></small></p>
                        </div>
                        <div class="col-xl-3 col-lg-3">
                            <a href="{{ route('approver.approver_list', Auth::id()) }}" class="btn btn-warning btn-block">Go
                                to
                                approver's list</a><br>
                        </div>
                        @else
                        <div class="col-xl-9 col-lg-9">
                            <p>You have a new leave application from
                                <strong>{{ $notification->data['applicant_name']}}</strong>
                            </p>
                            <p>Applied at: <u>{{$notification->data['created_at']}}</u></p>
                        </div>
                        <div class="col-xl-3 col-lg-3">
                            <a href="{{ route('approver.approver_list', Auth::id()) }}" class="btn btn-info btn-block">Go to
                                approver's
                                list</a><br>
                        </div>
                        @endif
                    </div>
                    @elseif($notification->type == 'App\Notifications\ApproverAlert')
                    <div class="row">
                        <div class="col-xl-9 col-lg-9">
                            <p>
                                Your leave application from {{$notification->data['from']}} to
                                {{ $notification->data['to'] }} has been
                                <strong class="{{ ($notification->data['status'] == 'Approved') ? 'text-success' : 'text-danger' }}">{{ $notification->data['status'] }}</strong>
                            </p>
                            <p>
                                Approval at: <u>{{$notification->data['approval_date']}}</u>
                            </p>
                        </div>
                        <div class="col-xl-3 col-lg-3">
                            <a href="{{ route('application.index')}}" class="btn btn-success btn-block">Go
                                to
                                application list</a><br>
                        </div>
                    </div>
                    @endif
                </li>
                @endforeach
            </ul>
        </div>
        @endif
        @if ($notifications->isNotEmpty())
        <div class="card-footer">
            {{$notifications->links()}}
        </div>
        @endif
    </div>
</div>



@endsection
