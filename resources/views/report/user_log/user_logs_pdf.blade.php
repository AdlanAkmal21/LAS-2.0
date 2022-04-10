<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Work From Home - Generate User Logs PDF</title>
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
            <h3>Work From Home - User Log List</h3>
            <p class="m-0">{{ Auth::user()->name }} ({{ Auth::user()->refRole->role_name }})</p>
            <p class="m-0">{{ date("l, d/m/Y h:i:sa") }}</p>

            <table class="mb-2 small text-center" style="width:80vw;">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Date</th>
                        <th>Period</th>
                        <th>Clock In</th>
                        <th>Clock Out</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user_logs as $key => $user_log)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $user_log->date ?? '--' }}</td>
                        <td>{{ $user_log->period ?? '--' }}</td>
                        <td>{{ $user_log->clock_in ?? '--' }}</td>
                        <td>{{ $user_log->clock_out ?? '--' }}</td>
                    </tr>
                    @endforeach

                    @if ($user_logs->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center">No data available.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    @include('partials._script')
</body>

</html>
