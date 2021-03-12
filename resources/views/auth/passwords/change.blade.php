@extends('layouts.app')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mt-3 mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Change Password</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Change Password</li>
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
            <form method="POST" action="{{ route('reset.change') }}">
                @csrf
                <div class="form-group row">
                    <label for="current_password"
                        class="col-md-4 col-form-label text-md-right">{{ __('Current Password') }}</label>

                    <div class="col-md-6">
                        <input id="current_password" type="password" class="form-control" name="current_password"
                            value="{{old('current_password')}}">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="new_password"
                        class="col-md-4 col-form-label text-md-right">{{ __('New Password') }}</label>

                    <div class="col-md-6">
                        <input id="new_password" type="password" class="form-control" name="new_password"
                            value="{{old('new_password')}}">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="new_confirm_password"
                        class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                    <div class="col-md-6">
                        <input id="new_confirm_password" type="password" class="form-control"
                            name="new_confirm_password" value="{{old('new_confirm_password')}}">
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-warning">
                            {{ __('Change Password') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
