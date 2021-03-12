<?php

namespace App\Traits;

use App\Mail\ApproverMail;
use App\Models\LeaveApplication;
use App\Models\User;
use App\Notifications\ApproverAlert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

trait ApproverTrait
{
    /**
     * Queries approver's pending list count.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function dashboard_pendings(int $id)
    {
        $pending_count = LeaveApplication::join('user_details', 'leave_applications.user_id', '=', 'user_details.user_id')
        ->select('user_details.approver_id', 'leave_applications.*', 'leave_applications.id as applicationID')
        ->where('application_status_id', 1)
        ->where('user_details.approver_id', $id)
        ->count();

        return $pending_count;
    }

    /**
     * Queries listing of the pending applications (approver).
     *
     * @return \Illuminate\Http\Response
     */
    public function approver_list_trait()
    {
        $pendings   = LeaveApplication::join('users', 'leave_applications.user_id', '=', 'users.id')
            ->join('user_details', 'users.id', '=', 'user_details.user_id')
            ->select('user_details.*', 'users.*', 'leave_applications.*', 'leave_applications.id as pending_id')
            ->where('user_details.approver_id', Auth::id())
            ->where('application_status_id', 1)
            ->paginate(5, ['*'], 'pendings');
        $approveds   = LeaveApplication::join('users', 'leave_applications.user_id', '=', 'users.id')
            ->join('user_details', 'users.id', '=', 'user_details.user_id')
            ->select('user_details.*', 'users.*', 'leave_applications.*', 'leave_applications.id as approved_id')
            ->where('user_details.approver_id', Auth::id())
            ->where('application_status_id', 2)
            ->paginate(5, ['*'], 'approved');
        $rejecteds   = LeaveApplication::join('users', 'leave_applications.user_id', '=', 'users.id')
            ->join('user_details', 'users.id', '=', 'user_details.user_id')
            ->select('user_details.*', 'users.*', 'leave_applications.*', 'leave_applications.id as rejected_id')
            ->where('user_details.approver_id', Auth::id())
            ->where('application_status_id', 3)
            ->paginate(5, ['*'], 'rejected');

        return compact('pendings','approveds','rejecteds');
    }

    /**
     * Queries listing of the applicant of the approver.
     *
     * @return \Illuminate\Http\Response
     */
    public function applicant_list_trait()
    {
        $users = User::join('user_details','user_details.user_id','=','users.id')
                        ->select('*', 'users.id as userid')
                        ->where('user_details.approver_id' , Auth::id() )
                        ->paginate(10);
        return $users;

    }

    /**
     * Approve applications trait (approver).
     *
     * @param  App\Models\LeaveApplication $application
     * @return \Illuminate\Http\Response
     */
    public function approve_trait(LeaveApplication $application)
    {
        $application->application_status_id    = 2;
        $application->approval_date            = Carbon::now();
        $application->save();

        //Annual & Emergency Leave
        if ($application->leave_type_id == 1 || $application->leave_type_id == 3)
        {
            $application->leavedetail->balance_leaves = ($application->leavedetail->balance_leaves)-($application->days_taken);
            $application->leavedetail->taken_so_far  += $application->days_taken;
            $application->leavedetail->save();
        }

        Mail::to($application->user->email)->send(new ApproverMail($application->id));
        $application->user->notify(new ApproverAlert($application));
    }

    /**
     * Reject applications trait (approver).
     *
     * @param  App\Models\LeaveApplication $application
     * @return \Illuminate\Http\Response
     */
    public function reject_trait(LeaveApplication $application)
    {
        $application->application_status_id = 3;
        $application->approval_date         = Carbon::now();
        $application->save();

        Mail::to($application->user->email)->send(new ApproverMail($application->id));
        $application->user->notify(new ApproverAlert($application));
    }

}
