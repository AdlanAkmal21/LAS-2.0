<table>
    <thead>
        <tr>
            <th>#.</th>
            <th>Applicant Name</th>
            <th>Leave Type</th>
            <th>From</th>
            <th>To</th>
            <th>Half Day</th>
            <th>Days Taken</th>
            <th>Application Status</th>
            <th>Applied At</th>
            <th>Approval Date</th>
            <th>Balance Leave</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($applications as $key => $application)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $application->user->name }}</td>
            <td>{{ $application->refLeaveType->leave_type_name }}</td>
            <td>{{ $application->from }}</td>
            <td>{{ $application->to }}</td>
            <td>{{ ($application->half_day == 1) ? 'Morning' : (($application->half_day == 2) ? 'Evening' : 'None') }}</td>
            <td>{{ $application->days_taken }}</td>
            <td>{{ $application->refAppStatus->application_status_name }}</td>
            <td>{{ $application->created_at }}</td>
            <td>{{ ($application->approval_date == null) ? 'None' : $application->approval_date }}</td>
            <td>{{ $application->user->leavedetail->balance_leaves }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
