<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Application Show - Generate Application PDF</title>
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
            margin-bottom: 30px;
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
            <h2>Application (ID: {{ $application->id }})</h2>
            <p class="m-0">{{ date("l, d/m/Y h:i:sa") }}</p>
            <table>
                <thead>
                    <tr>
                        <th style="width: 40%;">Attribute</th>
                        <th style="width: 60%;">Value</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Employee Name</td>
                        <td>{{ $application->user->name }}</td>
                    </tr>
                    <tr>
                        <td>Approver Name</td>
                        <td>{{ ($application->user->userdetail->approver_id==null) ? 'None' : $application->user->userdetail->approver->name }}
                        </td>
                    </tr>
                </tbody>
            </table>

            <table>
                <tbody>
                    <tr>
                        <td style="width: 40%;">Leave Type</td>
                        <td style="width: 60%;">{{$application->refLeaveType->leave_type_name}}</td>
                    </tr>
                    <tr>
                        <td style="width: 40%;">From</td>
                        <td style="width: 60%;">{{$application->from}}</td>
                    </tr>
                    <tr>
                        <td style="width: 40%;">To</td>
                        <td style="width: 60%;">{{$application->to}}</td>
                    </tr>
                    <tr>
                        <td style="width: 40%;">Days Taken</td>
                        <td style="width: 60%;">{{$application->days_taken}}</td>
                    </tr>
                    <tr>
                        <td style="width: 40%;">Half Day</td>
                        <td style="width: 60%;">{{ ($application->half_day==1) ? 'Morning' : (($application->half_day==2) ? 'Evening' : 'None') }}
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 40%;">Reason</td>
                        <td style="width: 60%;">{{ ($application->reason == '')? 'None' : $application->reason}}</td>
                    </tr>
                    <tr>
                        <td style="width: 40%;">Attachment</td>
                        <td style="width: 60%;">
                            @isset($file)
                            {{$file->filename}}
                            @endisset
                            @empty($file)
                            No attachment available.
                            @endempty
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 40%;">Applied At</td>
                        <td style="width: 60%;">{{date('Y-m-d (h:i:s)', strtotime($application->created_at))}}</td>
                    </tr>
                    <tr>
                        <td style="width: 40%;">Approval Date</td>
                        <td style="width: 60%;">{{($application->approval_date == null)?'None':$application->approval_date}}</td>
                    </tr>
                    <tr>
                        <td style="width: 40%;">Application Status</td>
                        <td style="width: 60%;">{{$application->refAppStatus->application_status_name}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    @include('partials._script')
</body>

</html>
