@extends('layouts.app')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Activity Log</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Activity Log</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="container-fluid">
    @if ($activities->isEmpty())
        <div class="card">
            <div class="card-body text-center">
                <span>No record found.</span>
            </div>
        </div>
    @else
        @foreach ($activities as $activity)
        <div class="card">
            <div class="card-body text-center">
                <span>{{ $activity->description }}</span>
            </div>
        </div>
        @endforeach
        {{ $activities->links() }}
    @endif
</div>

@endsection
