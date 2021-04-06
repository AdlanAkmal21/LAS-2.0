<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Application Report - Generate Overview PDF</title>
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
        <div id="Overview_PDF">
            <h3>Application Report - Overview</h3>
            <p class="m-0">{{ date("l, d/m/Y h:i:sa") }}</p>
            <p class="m-0">Week {{ date("W") }} of {{ date('Y') }} ({{ $application_report_array['start_dmy'] }} -
                {{ $application_report_array['end_dmy'] }})</p>

            <h4 style="margin: 30px 0px 10px">Periodic Overview:</h4>
            <table>
                <thead>
                    <tr>
                        <th style="width:60%;">Period</th>
                        <th style="width:40%;">Application(s)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>This Week</td>
                        <td>{{ $application_report_array['this_week'] }}</td>
                    </tr>
                    <tr>
                        <td>This Month</td>
                        <td>{{ $application_report_array['this_month'] }}</td>
                    </tr>
                    <tr>
                        <td>This Year</td>
                        <td>{{ $application_report_array['this_year'] }}</td>
                    </tr>
                    <tr>
                        <td>Until Now</td>
                        <td>{{ $application_report_array['until_today'] }}</td>
                    </tr>
                </tbody>
            </table>

            <h4 style="margin: 30px 0px 10px">Leave Type Overview:</h4>
            <table>
                <thead>
                    <tr>
                        <th style="width:60%;">Leave Type</th>
                        <th style="width:40%;">Application(s)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Annual Leave</td>
                        <td>{{ $application_report_array['annual_count'] }}</td>
                    </tr>
                    <tr>
                        <td>Medical Leave</td>
                        <td>{{ $application_report_array['medical_count'] }}</td>
                    </tr>
                    <tr>
                        <td>Emergency Leave</td>
                        <td>{{ $application_report_array['emergency_count'] }}</td>
                    </tr>
                    <tr>
                        <td>Unrecorded Leave</td>
                        <td>{{ $application_report_array['unrecorded_count'] }}</td>
                    </tr>
                </tbody>
            </table>

            <h4 style="margin: 30px 0px 10px">Most Applications This Month ({{ date('F') }}):</h4>
            <table class="mb-2 small text-center" style="width:80vw;">
                <thead>
                    <tr>
                        <th style="width:60%;">Staff Name</th>
                        <th style="width:40%;">Application(s)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($most_this_month as $most)
                    <tr>
                        <td>{{ $most->name }}</td>
                        <td class="text-center">{{ $most->application_count }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

    @include('partials._script')
</body>

</html>
