@extends('layouts.app')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Application Report List</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Application Report List</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="container-fluid">
    @if (!$alls->isEmpty())
    {{-- <form class="d-flex align-items-center flex-nowrap mb-2" method="GET" action="{{route('admin.search_report')}}">
        <input type="text" class="form-control mr-sm-2" name="search" placeholder="Search" aria-label="Search"
            value="@if(!empty($query)) {{$query}} @endif">
        <button type="submit" class="btn btn-outline-success">Search</button>
    </form> --}}

    <div class="table-responsive-lg">
        <table class="table table-sm table-bordered table-striped">
            <thead class="table-dark">
                <tr class="text-center">
                    <th>#</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($alls as $key => $all)
                <tr>
                    <td>{{ $alls->firstItem() + $key }}.</td>
                    <td>
                        <a href="#" class="btn btn-primary btn-sm btn-block">
                            Show
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>
    {{ $alls->links() }}
    @else
    <div class="card">
        <div class="card-body text-center">
            <span>No record found.</span>
        </div>
    </div>
    @endif

</div>

@endsection
