@component('mail::message')
Hello <b>{{$approver_name}}</b>,

<u>{{$applicant_name}}</u> had applied a new leave application that needs your attention.<br>

@component('mail::table')
| Leave Type | From | To | Days Taken |
| ------------------|:---------:|:---------:|-------------:|
| {{$leave_type}} | {{$from}} | {{$to}} | {{$days_taken}} |
@endcomponent


<br>Please kindly click here to proceed:

@component('mail::button', ['url' => $url])
Go to Leave Application System (LAS)
@endcomponent

Thank You,<br>
IGS Protech Sdn. Bhd.
@endcomponent
