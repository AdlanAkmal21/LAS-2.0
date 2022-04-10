<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use App\Models\LeaveApplication;
use App\Models\User;
use App\Traits\ApproverTrait;
use App\Traits\LeaveTrait;
use Illuminate\Support\Facades\Auth;

class ApproverController extends Controller
{
    use ApproverTrait;
    use LeaveTrait;

    /**
     * Display a listing of the pending applications (approver).
     *
     * @return \Illuminate\Http\Response
     */
    public function approver_list()
    {
        $approver_list_array = $this->approver_list_trait();

        return view('user.approver.application_list', compact('approver_list_array'));
    }

    /**
     * Display application (approver).
     *
     * @param \App\Models\LeaveApplication $application
     * @return \Illuminate\Http\Response
     */
    public function approver_list_show(LeaveApplication $application)
    {
        $file = File::where('application_id', $application->id)->first();

        return view('user.approver.application_show', compact('application', 'file'));
    }

    /**
     * Display a listing of the applicants list (approver).
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function applicant_list()
    {
        $users = $this->applicant_list_trait();

        return view('user.approver.applicant_list', compact('users'));
    }

    /**
     * Display a listing of the applicants list (approver).
     *
     * @param int $applicant_id
     * @return \Illuminate\Http\Response
     */
    public function applicant_show(int $applicant_id)
    {
        $user = User::find($applicant_id);
        return view('user.approver.applicant_show', compact('user'));
    }

    /**
     * Approve applications (approver).
     *
     * @param  App\Models\LeaveApplication $application
     * @return \Illuminate\Http\Response
     */
    public function approve(LeaveApplication $application)
    {
        $application->application_status_id    = 2;
        $application->approval_date            = Carbon::now();
        $application->save();

        //Re-calculate Applicant's Leave Detail.
        $this->recalculate_leave_detail($application->leavedetail);

        Mail::to($application->user->email)->send(new ApproverMail($application->id));
        $application->user->notify(new ApproverAlert($application));

        return redirect()->route('approver.approver_list')->with('success', 'Application approved.');
    }

    /**
     * Reject applications (approver).
     *
     * @param  App\Models\LeaveApplication $application
     * @return \Illuminate\Http\Response
     */
    public function reject(LeaveApplication $application)
    {
        $application->application_status_id = 3;
        $application->approval_date         = Carbon::now();
        $application->save();

        //Re-calculate Applicant's Leave Detail.
        $this->recalculate_leave_detail($application->leavedetail);

        Mail::to($application->user->email)->send(new ApproverMail($application->id));
        $application->user->notify(new ApproverAlert($application));

        return redirect()->route('approver.approver_list')->with('error', 'Application rejected.');
    }


}
