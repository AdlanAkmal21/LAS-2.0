<?php

namespace App\Traits;

use App\Models\LeaveApplication;
use App\Models\LeaveDetail;
use App\Models\User;
use App\Models\UserLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

trait UserTrait
{

    /**
     * Queries Dashboard Details (employees).
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function dashboard_user(int $id)
    {
        $applications_count =  LeaveApplication::where('user_id', $id)->count();
        $applications_count_this_year =  LeaveApplication::whereYear('created_at', date('Y'))->where('user_id', $id)->count();

        return compact('applications_count', 'applications_count_this_year');
    }

    /**
     * Find and show users (employees).
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function check_approver(int $id)
    {
        $user = User::find($id);

        //Validation For Approver's Name
        if (User::where('id', $user->userdetail->approver_id)->doesntExist()) {
            $user->userdetail->approver_id = null;
            $user->save();
        }
    }

    /**
     * Clock In.
     */
    public function clock_in_trait()
    {
        $new_log            = new UserLog();
        $new_log->user_id   = Auth::id();
        $new_log->date      = Carbon::now()->toDateString();
        $new_log->clock_in  = Carbon::now()->format('H:i:s');
        $new_log->save();
    }

    /**
     * Clock Out.
     *
     * @param \App\Models\UserLog $today
     */
    public function clock_out_trait(UserLog $today)
    {
        $now    = Carbon::now()->format('H:i:s');
        $init   = Carbon::parse($today->clock_in)->diffInSeconds(Carbon::parse($now));

        if($init < 60){
            $today->period = $init.'s';
        }
        else {
            $hours = floor($init / 3600);
            $minutes = floor(($init / 60) % 60);

            $today->period = $hours.'h '.$minutes.'m';
        }
        $today->clock_out = $now;
        $today->save();
    }

}
