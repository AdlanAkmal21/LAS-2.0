@component('mail::message')
Hello <b>{{$applicant_name}}</b>,

The following leave application has been <b>{{$status}}</b> at <u>{{$approval_date}}</u> :

@component('mail::table')
| Leave Type | From | To | Days Taken |
| ------------------|:---------:|:---------:|-------------:|
| {{$leave_type}} | {{$from}} | {{$to}} | {{$days_taken}} |
@endcomponent


<br><br>
Thank You,<br>
IGS Protech Sdn. Bhd.
@endcomponent
