<?php

namespace App\Traits;

use App\Models\LeaveApplication;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait IndexTrait
{
    use LeaveTrait;

    /**
     *  Runs All Index Functions
     *
     * @return \Illuminate\Http\Response
     */
    public function off_duty_index()
    {
        $today  = CarbonImmutable::today();
        $start  = $today->startOfWeek(Carbon::SUNDAY);
        $end    = $today->endOfWeek(Carbon::SATURDAY);

        //Query All Current Off-Duty Staff
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

        //Full-Calendar Events
        $offduty_calendar = LeaveApplication::join('users', 'leave_applications.user_id', '=', 'users.id')
            ->join('ref_leave_types', 'leave_applications.leave_type_id', '=', 'ref_leave_types.id')
            ->where('leave_applications.application_status_id', 2)
            ->whereYear('leave_applications.created_at', $today->year)
            ->select('users.name as title', 'leave_applications.from as start', DB::raw("leave_applications.to + INTERVAL 1 DAY as end"), 'ref_leave_types.leave_type_name as description')
            ->get()
            ->toJson();


        if (isset($offduty)) {

            //Change Status of Off-Duty Staffs (Leave or Long Leave)
            foreach ($offduty as $ofd) {
                ($ofd->days_taken < 3)
                    ? $ofd->user->emp_status_id = 3 //Short Leave
                    : $ofd->user->emp_status_id = 4; //Long Leave
                $ofd->user->save();
            }

            //Finds On-Duty Staffs.
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

        } else {

            //Else, All Staffs' statuses are Working.
            User::query()->update(['emp_status_id' => 1]);
        }

        return compact('offduty', 'offduty_count', 'offduty_calendar');
    }

    public function check_application_index()
    {
        $today  = CarbonImmutable::today();

        //Check Pendings. If Past Today, Auto-Reject Applications.
        if ($applications = LeaveApplication::where('to', '<=', $today)->where('application_status_id', 1)->where('leave_type_id', 1)->get()) {
            foreach ($applications as $application) {
                $application->application_status_id = 3;
                $application->approval_date = Carbon::now();
                $application->save();
            }
        }

    }

    public function user_index()
    {
        //Leaves Taken So Far.
        if (Auth::user()->role_id != 1 && Auth::user()->leavedetail) {

            $leavedetail = Auth::user()->leavedetail;
            $today  = CarbonImmutable::today();

            //Re-calculate Applicant's Leave Detail.
            $this->recalculate_leave_detail($leavedetail);

            //Yearly Carry-Over
            if (Carbon::now()->year > Auth::user()->userdetail->last_carry_over) {
                $year_joined = Carbon::parse(Auth::user()->userdetail->date_joined)->year;
                $this_year = Carbon::now()->year;
                $diff_year = $this_year - $year_joined;

                $annual_entitlement = (($diff_year >= 5) ? 21 : 14 );

                Auth::user()->leavedetail->annual_e         = $annual_entitlement;
                Auth::user()->leavedetail->carry_over       = $leavedetail->balance_leaves;
                Auth::user()->leavedetail->total_leaves     = $leavedetail->annual_e + $leavedetail->carry_over;
                Auth::user()->leavedetail->balance_leaves   = $leavedetail->total_leaves - $leavedetail->taken_so_far;
                Auth::user()->leavedetail->taken_so_far     = 0;
                Auth::user()->leavedetail->replacement_leaves = 0;
                Auth::user()->leavedetail->special_leaves   = 0;
                Auth::user()->leavedetail->save();

                Auth::user()->userdetail->last_carry_over = $this_year;
                Auth::user()->userdetail->save();
            }
        }
    }

}
