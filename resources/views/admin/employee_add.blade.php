@extends('layouts.app')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Add Employee</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.employee_list') }}">Employee List</a></li>
                    <li class="breadcrumb-item active">Add Employee</li>
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
            <form action="{{ route('admin.store') }}" method="POST">
                @csrf
                <div class="form-row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name">Employee Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Enter Employee Name.." value="{{ old('name') }}">
                        </div>
                        <div class="form-group">
                            <label for="email">E-Mail Address</label>
                            <input id="email" type="email" class="form-control" name="email" placeholder="Enter Email.."
                                value="{{ old('email') }}">
                        </div>
                        <div class="form-group">
                            <label for="ic">IC Number</label>
                            <input id="ic" data-inputmask="'mask': '999999-99-9999'" type="text" class="form-control"
                                name="ic" placeholder="Enter IC Number.." value="{{ old('ic') }}">
                        </div>
                        <div class="form-group">
                            <label for="phoneNum">Phone Number</label>
                            <input id="phoneNum" data-inputmask="'mask': '+(60)99 999-9999[9]'" type=" tel"
                                class="form-control" name="phoneNum" placeholder="Enter Phone Number.."
                                value="{{ old('phoneNum') }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="">Date Joined</label>
                            <input id="date_joined" type="text" class="form-control" name="date_joined"
                                value="{{ old('date_joined') }}" placeholder="Select Date Joined..">
                        </div>
                        <div class="form-group">
                            <label for="gender_id">Gender</label>
                            <select class="form-control" name="gender_id" id="gender_id">
                                <option selected disabled>Select Gender</option>
                                @foreach ($genders as $gender)
                                <option @if(old('gender_id')==$gender->id ) selected @endif
                                    value="{{$gender->id}}">{{$gender->gender_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="role_id">Role</label>
                            <select class="form-control" name="role_id" id="role_id">
                                <option selected disabled>Select Role</option>
                                @foreach ($roles as $role)
                                <option @if(old('role_id')==$role->id ) selected @endif
                                    value="{{$role->id}}">{{$role->role_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="approver_id">Approved By</label>
                            <select class="form-control" name="approver_id" id="approver_id">
                                <option selected disabled>Select Approver</option>
                                <option value="">None</option>
                                @foreach ($approvers as $approver)
                                <option @if(old('approver_id')==$approver->id ) selected @endif
                                    value="{{$approver->id}}">{{$approver->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary float-right">Add Employee</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



@endsection
