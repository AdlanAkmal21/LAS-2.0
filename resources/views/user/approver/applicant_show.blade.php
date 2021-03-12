@extends('layouts.app')
@section('content')

<section class="bg-info">
    <div class="d-flex align-items-end flex-column">
        <ol class="breadcrumb bg-transparent">
            <li class="breadcrumb-item"><a href="{{ route('user.index') }}" class="text-light">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('approver.applicant_list') }}" class="text-light">Applicant List</a></li>
            <li class="breadcrumb-item active text-muted">Applicant Detail</li>
        </ol>
    </div>
    <div class="d-flex justify-content-center pb-5">
        <img src="{{ (isset($user->userdetail)) ? (($user->userdetail->gender_id == 1)?asset('assets/svg/profile-male.svg'): asset('assets/svg/profile-female.svg')) : asset('assets/svg/profile-admin.svg') }}"
            class="img-circle border border-light" width="100" alt="User Image">

        <div class="ml-3 align-self-center">
            <h4 class="m-0 font-weight-bold text-monospace">
                {{ $user->name }}
            </h4>
            <p class="m-0">({{ $user->refRole->role_name }})</p>
        </div>
    </div>
</section>

<div class="card-deck">
    <div class="card my-3">
        <div class="card-header"><b>{{ __('Employee Details') }}</b>
        </div>
        <div class="card-body text-sm-right">
            <form>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for="user_id">Employee ID</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control text-sm-center" id="user_id" disabled value="{{$user->id}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for="name">Employee Name</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control text-sm-center" id="name" disabled value="{{$user->name}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for="email">Email</label>
                    <div class="col-sm-8">
                        <input class="form-control text-sm-center" type="text" id="email" disabled value="{{$user->email}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for="phoneNum">Phone Number</label>
                    <div class="col-sm-8">
                        <input class="form-control text-sm-center" type="text" id="phoneNum" disabled
                            value="{{$user->userdetail->phoneNum}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for="date_joined">Date Joined</label>
                    <div class="col-sm-8">
                        <input class="form-control text-sm-center" type="text" id="date_joined" disabled
                            value="{{$user->userdetail->date_joined}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for="approver_id">Approved By</label>
                    <div class="col-sm-8">
                        <input class="form-control text-sm-center" type="text" id="approver_id" disabled
                            value="{{ ($user->userdetail->approver_id == null) ? 'None' : $user->userdetail->approver->name }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for="role_id">Role</label>
                    <div class="col-sm-8">
                        <input class="form-control text-sm-center" type="text" id="role_id" disabled
                            value="{{$user->refRole->role_name}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for="emp_status_id">Employee Status</label>
                    <div class="col-sm-8">
                        <input
                            class="form-control text-sm-center font-weight-bolder {{ ($user->emp_status_id == 2) ? 'text-danger' : (($user->emp_status_id == 3 || $user->emp_status_id == 4) ? 'text-success' : 'text-primary') }}"
                            type="text" id="emp_status_id" disabled value="{{$user->refEmpStatus->emp_status_name}}">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card my-3">
        <div class="card-header"><b>{{ __('Leave Details') }}</b>
        </div>
        @if (isset($user->leavedetail))
        <div class="card-body text-sm-right">
            <form>
                <div class="form-group row">
                    <label class="col-sm-6 col-form-label" for="annual_e">Annual Entitlement</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control  text-center" id="annual_e" disabled
                            value="{{$user->leavedetail->annual_e}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-6 col-form-label" for="carry_over">Carry Over From Previous Year</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control  text-center" id="carry_over" disabled
                            value="{{$user->leavedetail->carry_over}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-6 col-form-label" for="total_leaves">Total Leaves (Current Year)</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control  text-center" id="total_leaves" disabled
                            value="{{$user->leavedetail->total_leaves}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-6 col-form-label" for="taken_so_far">Leaves Taken (Current Year)</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control  text-center" id="taken_so_far" disabled
                            value="{{$user->leavedetail->taken_so_far}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-6 col-form-label" for="balance_leaves">Current Balance Leaves</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control  text-center" id="balance_leaves" disabled
                            value="{{$user->leavedetail->balance_leaves}}">
                    </div>
                </div>
            </form>
        </div>
        @else
        <div class="card-body">
            <h4 class="text-center my-3">Leave Record is Not Found!</h4>
        </div>
        @endif
    </div>
</div>

@endsection
