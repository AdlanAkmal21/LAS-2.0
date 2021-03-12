@extends('layouts.app')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Add Holiday</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('holiday.index') }}">Holiday List</a></li>
                    <li class="breadcrumb-item active">Add Holiday</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

@include('partials._validation')
@include('partials._notifications')

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('holiday.store') }}">
                @csrf

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label class="label" for="holiday_name">Holiday Name</label>
                            <input class="form-control" type="text" name="holiday_name" placeholder="Enter Holiday Name..">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label class="label" for="holiday_date">Holiday Date</label>
                            <input id="holiday_date" class="form-control" type="text" name="holiday_date" placeholder="Select Holiday Date..">
                        </div>
                    </div>
                </div>

                <div class="float-right pt-3">
                    <button type="submit" class="btn btn-success">Add</button>
                    <a class="btn btn-danger" href="{{ route('holiday.index')}}">Cancel</a>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection
