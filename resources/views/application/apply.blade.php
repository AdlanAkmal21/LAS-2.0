@extends('layouts.app')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Leave Application Form</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('application.index') }}">Application List</a></li>
                    <li class="breadcrumb-item active">Apply Leave</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

@include('partials._validation')
@include('partials._notifications')

<div class="container-fluid">
    @if (Auth::user()->leavedetail)
    <div class="container-fluid">
        <p>If you're experiencing any problems, try refreshing the page or re-select the dates.</p>

        <div class="form-row">
            <div class="col-xl-8 d-flex align-content-stretch">
                <div class="card shadow-sm mb-4 w-100">
                    <div class="card-body">
                        <form method="post" action="{{ route('application.store')}}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row mt-2">
                                <label for="name" class="col-xl-3 col-lg-3 col-md-3 col-form-label">Employee
                                    Name</label>
                                <div class="col-xl-9 col-lg-9 col-md-9">
                                    <input type="text" readonly class="form-control" readonly="readonly" id="name"
                                        value="{{Auth::user()->name}}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="leave_type_id" class="col-xl-3 col-lg-3 col-md-3 col-form-label">Leave
                                    Type</label>
                                <div class="col-xl-9 col-lg-9 col-md-9">
                                    <select class="form-control" id="leave_type_id" name="leave_type_id">
                                        <option selected disabled value="0">Select Leave Type</option>
                                        @foreach ($refLeaveTypes as $refLeaveType)
                                        <option @if(old('leave_type_id')==$refLeaveType->id
                                            )
                                            selected
                                            @endif
                                            value="{{$refLeaveType->id}}">{{$refLeaveType->leave_type_name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="from" class="col-xl-3 col-lg-3 col-md-3 col-form-label">Date <small
                                        class="text-black-50">(yyyy-mm-dd)</small></label>
                                <div class="col-xl-9 col-lg-9 col-md-9 form-inline">
                                    <div class="form-group mr-2 mb-2 mb-xl-0 mb-lg-0 flex-fill">
                                        <input type="text" class="form-control flex-fill" name="from" id="from"
                                            placeholder="Select From Date .." value="{{ old('from') }}">
                                    </div>
                                    <div class="form-group mr-2 mb-2 mb-xl-0 mb-lg-0 flex-fill">
                                        <input type="text" class="form-control flex-fill" name="to" id="to"
                                            placeholder="Select To Date .." value="{{ old('to') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="days_taken" class="col-xl-3 col-lg-3 col-md-3 col-form-label">Days
                                    Taken</label>
                                <div class="col-xl-9 col-lg-9 col-md-9">
                                    <input class="form-control" type="text" id="days_taken" name="days_taken"
                                        placeholder="Please select dates." readonly="readonly"
                                        value="{{ old('days_taken') }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="check" class="col-xl-3 col-lg-3 col-md-3 col-form-label">Half Day</label>
                                <div class="col-xl-9 col-lg-9 col-md-9">
                                    <div id="check" class="form-control border-0">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="half_day" id="morning"
                                                value="1" disabled>
                                            <label class="form-check-label" for="morning">Morning</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="half_day" id="evening"
                                                value="2" disabled>
                                            <label class="form-check-label" for="evening">Evening</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="reason" class="col-xl-3 col-lg-3 col-md-3 col-form-label">Reason <small
                                        class="text-black-50">(optional)</small></label>
                                <div class="col-xl-9 col-lg-9 col-md-9">
                                    <textarea class="form-control mb-2" name="reason" style="resize:none"
                                        placeholder="State your reason..">{{ old('reason')}}</textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="file" class="col-xl-3 col-lg-3 col-md-3 col-form-label">Attachment
                                    <small class="text-black-50">(optional)</small></label>
                                <div class="col-xl-9 col-lg-9 col-md-9">
                                    <input type="file" class="form-control-file" name="file" id="file">
                                </div>
                            </div>

                            <div class="form-group float-right pt-2">
                                <button type="submit" class="btn btn-primary">Apply</button>
                                <button type="reset" id="clear" class="btn btn-danger">Clear</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 d-flex align-content-stretch">
                <div class="card shadow-sm mb-4 w-100">
                    <div class="card-body">

                        <div class="form-group">
                            <label for="annual_e">Annual Entitlement</label>
                            <input type="text" class="form-control form-control-sm" id="annual_e" disabled
                                value="{{ Auth::user()->leavedetail->annual_e }}">
                        </div>

                        <div class="form-group">
                            <label for="carry_over">Carry Over</label>
                            <input type="text" class="form-control form-control-sm" id="carry_over" disabled
                                value="{{ Auth::user()->leavedetail->carry_over }}">
                        </div>

                        <div class="form-group">
                            <label for="replacement_leaves">Replacement Leaves</label>
                            <input type="text" class="form-control form-control-sm" id="replacement_leaves" disabled
                                value="{{ Auth::user()->leavedetail->replacement_leaves }}">
                        </div>

                        <div class="form-group">
                            <label for="special_leaves">Special Leaves</label>
                            <input type="text" class="form-control form-control-sm" id="special_leaves" disabled
                                value="{{ Auth::user()->leavedetail->special_leaves }}">
                        </div>

                        <div class="form-group">
                            <label for="total_leaves">Total Leaves</label>
                            <input type="text" class="form-control form-control-sm" id="total_leaves" disabled
                                value="{{ Auth::user()->leavedetail->total_leaves }}">
                        </div>

                        <div class="form-group">
                            <label for="taken_so_far">Leave Taken (This Year)</label>
                            <input type="text" class="form-control form-control-sm" id="taken_so_far" disabled
                                value="{{ Auth::user()->leavedetail->taken_so_far }}">
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="balance_leaves"><b>Balance Leaves</b></label>
                            <input type="text" class="form-control form-control-sm" id="balance_leaves" disabled
                                value="{{ Auth::user()->leavedetail->balance_leaves }}">
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="container-fluid">
        <div class="card shadow mt-3">
            <div class="card-body text-center">
                <span class="text-muted">No Leave Record Found.</span>
            </div>
        </div>
    </div>
    @endif
</div>

@endsection
