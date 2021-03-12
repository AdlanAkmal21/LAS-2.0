@extends('layouts.app')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Holiday List</h1>
                <span>Total Holidays : {{$holidays->count()}}</span>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Holiday List</li>
                    <li class="breadcrumb-item"><a href="{{ route('holiday.create') }}">Add Holiday</a></li>
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

        @if($holidays->isEmpty())
        <div class="card shadow-sm border-left-dark mt-4 mb-4">
            <div class="card-body text-center">
                <span class="text-muted">No Holiday Available</span>
            </div>
        </div>
        @else
        <div class="table-responsive-lg mt-1">
            <table class="table table-sm table-bordered table-striped text-center">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Holiday Name</th>
                        <th>Holiday Date</th>
                        <th colspan="2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($holidays as $key => $holiday)
                    <tr>
                        <td>{{ $holidays->firstItem() + $key }}.</td>
                        <td>{{ $holiday->holiday_name }}</td>
                        <td>{{ $holiday->holiday_date }}</td>
                        <td>
                            <a class="btn btn-success btn-block btn-sm"
                                href="{{ route('holiday.edit', $holiday)}}">Edit</a>
                        </td>
                        <td>
                            <form action="{{ route('holiday.destroy', $holiday)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input class="btn btn-danger btn-block btn-sm" role="button" type="submit"
                                    value="Delete" onclick="return confirm('Delete Holiday?');">
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
        {{ $holidays->links() }}
        @endif
    </div>
</div>

@endsection
