<?php

namespace App\Traits;

use App\Models\LeaveApplication;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Auth;

trait IndexTrait
{
    /**
     *  Runs All Index Functions
     *
     * @return \Illuminate\Http\Response
     */
    public function off_duty_index()
    {
        //Query Off-Duty
        $today  = CarbonImmutable::today();
        $start  = $today->startOfWeek(Carbon::SUNDAY);
        $end    = $today->endOfWeek(Carbon::SATURDAY);

        $offduty = LeaveApplication::where(function ($query) use ($today) {
                $query->where('application_status_id', 2)
                    ->whereDate('from', $today)
                    ->whereDate('to', $today);
            })
            ->orWhere(function ($query) use ($today) {
                $query->where('application_status_id', 2)
                    ->whereDate('from', '<=', $today)
                    ->whereDate('to', '>=', $today);
            })
            ->paginate(5);

        //Counts All Distinct Off-Duty Staffs.
        $offduty_count = LeaveApplication::where(function ($query) use ($today) {
                $query->where('application_status_id', 2)
                    ->whereDate('from', $today)
                    ->whereDate('to', $today);
            })
            ->orWhere(function ($query) use ($today) {
                $query->where('application_status_id', 2)
                    ->whereDate('from', '<=', $today)
                    ->whereDate('to', '>=', $today);
            })
            ->distinct('user_id')
            ->count();


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

        return compact('offduty', 'offduty_count');
    }

    public function application_index()
    {
        $today  = CarbonImmutable::today();

        //Check Pendings. If Past Today, Auto-Reject Applications.
        if ($applications = LeaveApplication::where('to', '<=', Carbon::today())
            ->where('application_status_id', 1)
            ->where('leave_type_id', 1)
            ->get()
        ) {
            foreach ($applications as $application) {
                $application->application_status_id = 3;
                $application->approval_date = Carbon::now();
                $application->save();
            }
        }

    }

    public function user_index() {
        $today  = CarbonImmutable::today();

        //Leaves Taken So Far.
        if (Auth::user()->role_id != 1 && Auth::user()->leavedetail) {
            //Yearly Carry-Over
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

        //Application Sum = Leaves Taken So Far.
        $application_sum = LeaveApplication::where('user_id', Auth::id())
        ->where('application_status_id', 2)
            ->whereYear('created_at', date('Y'))
            ->where('from', '<=', $today)
            ->where(function ($query) {
                $query->where('leave_type_id', 1)
                    ->orWhere('leave_type_id', 3);
            })
            ->sum('days_taken');

        $leavedetail = Auth::user()->leavedetail;
        $leavedetail->taken_so_far      = $application_sum;
        $leavedetail->balance_leaves    = $leavedetail->total_leaves - $application_sum;
        $leavedetail->save();
    }


}
