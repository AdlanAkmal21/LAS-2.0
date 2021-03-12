@extends('layouts.app')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit Employee</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.employee_list') }}">Employee List</a></li>
                    <li class="breadcrumb-item active">Edit Employee</li>
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
            <form method="post" action="{{ route('admin.update', $user->id) }}">
                @method('PATCH')
                @csrf

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label class="label" for="name">Employee Name</label>
                            <input class="form-control" type="text" name="name" value="{{ old('name', $user->name)}}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label class="label" for="email">Email</label>
                            <input class="form-control" type="email" name="email" value="{{ old('email', $user->email)}}">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label class="label" for="phoneNum">Phone Number</label>
                            <input class="form-control" type="text" name="phoneNum" id="phoneNum"
                                data-inputmask="'mask': '+(60)99 999-9999[9]'"
                                value="{{ old('phoneNum', $user->userdetail->phoneNum)}}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label class="label" for="approver_id">Approved By</label>
                            <select class="form-control" name="approver_id">
                                <option {{ (old('approver_id', $user->userdetail->approver_id) == null) ? 'selected' : '' }} value="">None
                                </option>
                                @foreach ($approvers as $approver)
                                <option {{ (old('approver_id', $user->userdetail->approver_id) == $approver->id) ? 'selected' : '' }} value="{{$approver->id}}">{{$approver->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label class="label" for="emp_status_id">Employee Status</label>
                            <select class="form-control" name="emp_status_id">
                                @foreach ($refEmpStatus as $res)
                                <option @if(old('emp_status_id', $user->emp_status_id) == $res->id )
                                    selected
                                    @endif
                                    value="{{$res->id}}">{{$res->emp_status_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="p-t-15">
                    <button type="submit" class="btn btn-success">Update</button>
                    <a class="btn btn-danger" href="{{ route('admin.employee_list')}}">Cancel</a>
                </div>

            </form>
        </div>
    </div>
</div>




@endsection
