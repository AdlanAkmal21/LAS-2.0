@extends('layouts.app')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">File List</h1>
                <span>Total Files : {{$files->count()}}</span>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">File List</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

@include('partials._validation')
@include('partials._notifications')

<div class="container-fluid">
    @if ($files->isEmpty())
    <div class="card shadow-sm border-left-dark mt-2 mb-4">
        <div class="card-body text-center">
            <span class="text-muted">No Files Available</span>
        </div>
    </div>
    @else
    <div class="table-responsive-lg">
        <table class="table table-sm table-bordered table-striped container">
            <thead class="table-dark text-center">
                <tr class="d-flex">
                    <th class="col-1">#</th>
                    <th class="col-4">Applicant</th>
                    <th class="col-3">Application</th>
                    <th class="col-4">Attachment</th>
                </tr>
            </thead>
            <tbody>
                @foreach($files as $key => $file)
                <tr class="d-flex">
                    <td class="col-1">{{ $files->firstItem() + $key }}.</td>
                    <td class="col-4">
                        <a
                            href="{{ route('admin.show', $file->application->user->id)}}">{{ $file->application->user->name}}</a>
                    </td>
                    <td class="col-3 text-center">
                        <a
                            href="{{ route('application.show', $file->application)}}">{{ 'Application ID: '. $file->application->id . ' ('.$file->application->refLeaveType->leave_type_name.')' }}</a>
                    </td>
                    <td class="col-4 text-center">
                        <a href="{{asset("storage/$file->filecategory/$file->filename")}}" name="file" id="file"><i
                                class="fa fa-file fa-lg mr-2"></i> {{$file->filename}}</a> </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>
    {{ $files->links() }}
    @endif

</div>

@endsection
