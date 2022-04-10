@extends('layouts.app')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Leave Management</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Leave Management</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

@include('partials._validation')
@include('partials._notifications')

<div class="container-fluid">
    <div class="container-fluid">
        <p class="mb-0">Management of leave balances.</p>
        <p class="text-danger">* Note: Amount larger than current leaves balance will not be subtracted.</p>

    @if ($leave_details->isEmpty())
    <div class="card">
        <div class="card-body text-center">
            <span>No record found.</span>
        </div>
    </div>
    @else

    <form action="{{ route('leave_management.store') }}" method="post">
        @csrf
        <div class="card">
            <div class="card-body text-center">
                    <div class="form-row">
                      <div class="form-group col-md-4">
                        <label>Leave Type</label>
                        <select required name="leave_type" class="form-control form-control-sm">
                            <option value="" selected>Please Choose Leave Type ...</option>
                            <option value="annual_e">Annual Leave</option>
                            <option value="replacement_leaves">Replacement Leave</option>
                            <option value="special_leaves">Special Leave</option>
                        </select>
                      </div>
                      <div class="form-group col-md-4">
                        <label>Option</label>
                        <select required name="option" class="form-control form-control-sm">
                          <option value="" selected>Please Choose Option ...</option>
                          <option value="add">Add (+)</option>
                          <option value="minus">Subtract (-)</option>
                        </select>
                      </div>
                      <div class="form-group col-md-4">
                        <label>Amount</label>
                        <input required name="amount" type="number" placeholder="Please Enter Number of Leaves ..." class="form-control form-control-sm">
                      </div>
                    </div>

                    <button type="submit" class="btn btn-success btn-sm mx-1 float-left" name="submitBtn" value="submit_all">Apply To All</button>
                    <button type="submit" class="btn btn-primary btn-sm mx-1 float-right" name="submitBtn" value="submit">Submit</button>
                    <button type="reset" class="btn btn-danger btn-sm mx-1 float-right">Clear</button>
            </div>
        </div>

        <div class="table-responsive-lg">
            <table class="table table-sm table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th colspan="2">#</th>
                        <th style="width: 20%;">Employee Name</th>
                        <th>Annual Entitlement</th>
                        <th>Carry Over</th>
                        <th>Total Leaves</th>
                        <th>Days Taken</th>
                        <th>Balance Leaves</th>
                        <th>Replacement Leaves</th>
                        <th>Special Leaves</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($leave_details as $key => $leave_detail)
                    <tr>
                        <td>{{ $key+1 }}.</td>
                        <td><input type="checkbox" name="leave_ids[]" value="{{ $leave_detail->id }}"></td>
                        <td style="width: 20%;">{{ $leave_detail->user->name }}</td>
                        <td>{{ $leave_detail->annual_e }}</td>
                        <td>{{ $leave_detail->carry_over }}</td>
                        <td>{{ $leave_detail->total_leaves }}</td>
                        <td>{{ $leave_detail->taken_so_far }}</td>
                        <td>{{ $leave_detail->balance_leaves }}</td>
                        <td>{{ $leave_detail->replacement_leaves }}</td>
                        <td>{{ $leave_detail->special_leaves }}</td>
                        <td>
                            <a href="{{ route('leave_management.edit', $leave_detail) }}" class="btn btn-info btn-sm">Show</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </form>

    @endif

    </div>
</div>




@endsection
