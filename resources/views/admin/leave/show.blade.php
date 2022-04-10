@extends('layouts.app')
@section('content')

<style>
input:invalid{
    border: 3px solid rgba(255, 0, 0, 0.4);
}
</style>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Leave Management ({{ $leave_detail->user->name }})</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('leave_management.index') }}">Leave Management</a></li>
                    <li class="breadcrumb-item active">({{$leave_detail->user->name}})</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

@include('partials._validation')
@include('partials._notifications')

<div class="container-fluid">
    <div class="card mt-2">
        <div class="card-body">
            <form method="post" action="{{ route('leave_management.update', $leave_detail) }}">
                @csrf

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label class="label" for="name">Employee Name</label>
                            <input disabled class="form-control" type="text" value="{{ $leave_detail->user->name }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label class="label" for="email">Annual Entitlement</label>
                            <input class="form-control" type="text" name="annual_e" pattern="[0-9.]+" value="{{ $leave_detail->annual_e }}">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label class="label" for="email">Carry Over</label>
                            <input class="form-control" type="text" name="carry_over" value="{{ $leave_detail->carry_over }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label class="label" for="email">Total Leaves</label>
                            <input class="form-control" type="text" name="total_leaves" value="{{ $leave_detail->total_leaves }}">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label class="label" for="email">Taken So Far</label>
                            <input class="form-control" type="text" name="taken_so_far" value="{{ $leave_detail->taken_so_far }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label class="label" for="email">Balance Leaves</label>
                            <input class="form-control" type="text" name="balance_leaves" value="{{ $leave_detail->balance_leaves }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label class="label" for="email">Replacement Leaves</label>
                            <input class="form-control" type="text" name="replacement_leaves" value="{{ $leave_detail->replacement_leaves }}">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label class="label" for="email">Special Leaves</label>
                            <input class="form-control" type="text" name="special_leaves" value="{{ $leave_detail->special_leaves }}">
                        </div>
                    </div>
                </div>

                <div class="p-t-15">
                    <button type="submit" class="btn btn-success">Update</button>
                    <a class="btn btn-danger" href="{{ route('leave_management.index')}}">Cancel</a>
                </div>

            </form>
        </div>
    </div>
</div>




@endsection
