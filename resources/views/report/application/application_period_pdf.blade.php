<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Application Report - Generate Period PDF</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <style>
        table,
        td,
        th {
            border: 1px solid black;
            text-align: center;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            padding: 3px 0px 3px;
        }
    </style>
</head>

<body>

    <div class="d-flex justify-content-center p-3">
        <div id="Period_PDF">
            <h3>Application Report - {{ $application_period_array['period_title2'] }}
                ({{ $application_period_array['period_title3'] }})</h3>
            <p class="m-0">{{ date("l, d/m/Y h:i:sa") }}</p>

            <table class="mb-2 small text-center" style="width:80vw;">
                <thead>
                    <tr>
                        <th style="width:60%;">Leave Type</th>
                        <th style="width:40%;">Application(s)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Annual Leave</td>
                        <td>
                            {{ $application_period_array['applications_all']->where('leave_type_id',1)->count() }}</td>
                    </tr>
                    <tr>
                        <td>Medical Leave</td>
                        <td>
                            {{ $application_period_array['applications_all']->where('leave_type_id',2)->count() }}</td>
                    </tr>
                    <tr>
                        <td>Emergency Leave</td>
                        <td>
                            {{ $application_period_array['applications_all']->where('leave_type_id',3)->count() }}</td>
                    </tr>
                    <tr>
                        <td>Unrecorded Leave</td>
                        <td>
                            {{ $application_period_array['applications_all']->where('leave_type_id',4)->count() }}</td>
                    </tr>
                </tbody>
            </table>

            <h4 style="margin: 15px 0px 5px;">Application(s) List:</h4>
            <table class="mb-2 small text-center" style="width:80vw;">
                <thead>
                    <tr>
                        <th style="width:5%;">#.</th>
                        <th style="width:30%;">Applicant Name</th>
                        <th style="width:15%;">Leave Type</th>
                        <th style="width:15%;">From</th>
                        <th style="width:15%;">To</th>
                        <th style="width:10%;">Days Taken</th>
                        <th style="width:10%;">Balance Leave</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($application_period_array['applications_all'] as $key => $application)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td style="text-align: left;padding-left: 10px;">{{ $application->user->name }}</td>
                        <td>{{ $application->refLeaveType->leave_type_name }}</td>
                        <td>{{ $application->from }}</td>
                        <td>{{ $application->to }}</td>
                        <td>{{ $application->days_taken }}</td>
                        <td>{{ $application->user->leavedetail->balance_leaves }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @include('partials._script')
</body>

</html>
