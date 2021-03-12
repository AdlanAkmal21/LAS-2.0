<?php

namespace App\Traits;

use App\Models\LeaveApplication;
use App\Models\User;
use App\Models\UserLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait IndexTrait
{
    /**
     *  Runs All Index Functions
     *
     * @return \Illuminate\Http\Response
     */
    public function indexes()
    {
        //Query Off-Duty
        $today  = Carbon::today();
        $start  = $today->startOfWeek(Carbon::SUNDAY)->format('Y-m-d');
        $end    = $today->endOfWeek(Carbon::SATURDAY)->format('Y-m-d');

        $offduty     = LeaveApplication::where(function ($query) use ($start, $end) {
            $query->where('application_status_id', 2)
                ->where('from', '>=', $start)
                ->where('from', '<=', $end);
        })
            ->orWhere(function ($query) use ($start, $end) {
                $query->where('application_status_id', 2)
                    ->where('from', '<', $start)
                    ->where('to', '>', $end);
            })
            ->orWhere(function ($query) use ($start, $today) {
                $query->where('application_status_id', 2)
                    ->where('to', '>=', $start)
                    ->where('to', '<', $today);
            })
            ->paginate(5);

        //Change Status of Off-Duty Staffs (Leave or Long Leave)
        if (isset($offduty)) {
            foreach ($offduty as $ofd) {
                ($ofd->days_taken < 3)
                    ? $ofd->user->emp_status_id = 3 //Short Leave
                    : $ofd->user->emp_status_id = 4; //Long Leave
                $ofd->user->save();
            }
        }

        //Checks for Off-Duty Staffs
        if (isset($offduty)) {
            //Compares and Finds On-Duty Staffs.
            $users  = User::pluck('id');
            $ofd_id = $offduty->pluck('user_id');
            $ond_id = $users->diff($ofd_id);

            //If On-Duty Staff's Status is Leave/Long Leave, System Change Back to Working.
            foreach ($ond_id as $id) {
                $check = User::find($id);
                if ($check->emp_status_id == 3 || $check->emp_status_id == 4) {
                    $check->emp_status_id = 1;
                    $check->save();
                }
            }
        } //Else, All Staffs' statuses are Working.
        else {
            User::query()->update(['emp_status_id' => 1]);
        }

        //Counts All Distinct Off-Duty Staffs.
        $offduty_count = LeaveApplication::where(function ($query) use ($start, $end) {
            $query->where('application_status_id', 2)
                ->where('from', '>=', $start)
                ->where('from', '<=', $end);
            })
            ->orWhere(function ($query) use ($start, $end) {
                $query->where('application_status_id', 2)
                    ->where('from', '<', $start)
                    ->where('to', '>', $end);
            })
            ->orWhere(function ($query) use ($start, $today) {
                $query->where('application_status_id', 2)
                    ->where('to', '>=', $start)
                    ->where('to', '<', $today);
            })
            ->distinct('user_id')
            ->count();

        //Check Pendings. If Past Today, Auto-Reject Applications.
        if (LeaveApplication::where('to', '<=', Carbon::today())->exists()) {
            $applications = LeaveApplication::where('to', '<', Carbon::today())->get();
            foreach ($applications as $application) {
                if ($application->application_status_id == 1 && $application->leave_type_id == 1) {
                    $application->application_status_id = 3;
                    $application->approval_date = Carbon::now();
                    $application->save();
                }
            }
        }

        //Yearly Carry-Over
        if (Auth::user()->role_id != 1 && Auth::user()->leavedetail) {
            if (Carbon::now()->year > Auth::user()->userdetail->last_carry_over) {
                Auth::user()->leavedetail->annual_e         = 14;
                Auth::user()->leavedetail->taken_so_far     = 0;
                Auth::user()->leavedetail->carry_over       =  Auth::user()->leavedetail->balance_leaves;
                Auth::user()->leavedetail->total_leaves     = (Auth::user()->leavedetail->annual_e) + (Auth::user()->leavedetail->carry_over);
                Auth::user()->leavedetail->balance_leaves   = (Auth::user()->leavedetail->total_leaves) - (Auth::user()->leavedetail->taken_so_far);
                Auth::user()->leavedetail->save();

                Auth::user()->userdetail->last_carry_over = Carbon::now()->year;
                Auth::user()->userdetail->save();
            }
        }

        return compact('offduty', 'offduty_count');
    }

}
