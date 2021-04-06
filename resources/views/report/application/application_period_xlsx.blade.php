<table>
    <thead>
        <tr>
            <th>#.</th>
            <th>Applicant Name</th>
            <th>Leave Type</th>
            <th>From</th>
            <th>To</th>
            <th>Days Taken</th>
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
        <td>{{ $application->days_taken }}</td>
        <td>{{ $application->user->leavedetail->balance_leaves }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
