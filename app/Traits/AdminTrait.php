<?php

namespace App\Traits;

use App\Models\UserDetail;
use App\Models\Holiday;
use App\Models\LeaveApplication;
use App\Models\LeaveDetail;
use App\Models\User;
use Carbon\Carbon;

trait AdminTrait
{
    /**
     * Queries Admin's Dashboard Details.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard_admins()
    {
        //Employees
        $employees                      = User::where('id','!=', 1)->get();
        $resigned                       = User::where('id','!=', 1)
                                            ->where('emp_status_id', 2)
                                            ->get();


        $employees_count                = $employees->count();
        $male_count                     = UserDetail::where('gender_id',1)->count();
        $female_count                   = UserDetail::where('gender_id',2)->count();
        $admin_count                    = User::where('role_id',1)->count();
        $employee_count                 = User::where('role_id',2)->count();
        $approver_count                 = User::where('role_id',3)->count();

        $working_count                  = User::where('id','!=', 1)->where('emp_status_id',1)->count();
        $resigned_count                 = $resigned->count();


        //Leave
        $taken_so_far_sum                   = LeaveDetail::sum('taken_so_far');
        $carry_over_sum                     = LeaveDetail::sum('carry_over');
        $balance_leaves_sum                 = LeaveDetail::sum('carry_over');

        $taken_so_far_sum_average           = LeaveDetail::avg('taken_so_far');
        $annual_e_average                   = LeaveDetail::avg('annual_e');

        //Applications
        $applications                   = LeaveApplication::all();
        $applications_count             = $applications->count();
        $applications_this_year         = LeaveApplication::whereYear('created_at', date('Y'))->get();
        $applications_this_year_count   = $applications_this_year->count();
        $applications_other_year_count  = $applications_count - $applications_this_year_count;

        $pending_count                  = LeaveApplication::where('application_status_id',1)->count();
        $approve_count                  = LeaveApplication::where('application_status_id',2)->count();
        $reject_count                   = LeaveApplication::where('application_status_id',3)->count();

        $pending_this_year_count        = LeaveApplication::whereYear('created_at', date('Y'))->where('application_status_id',1)->count();
        $approve_this_year_count        = LeaveApplication::whereYear('created_at', date('Y'))->where('application_status_id',2)->count();
        $reject_this_year_count         = LeaveApplication::whereYear('created_at', date('Y'))->where('application_status_id',3)->count();

        //Holidays
        $holidays                       = Holiday::all();

        $monday_count = $tuesday_count = $wednesday_count =
        $thursday_count = $friday_count = $saturday_count = $sunday_count =  0 ;

        $january_count = $february_count = $march_count = $april_count=
        $may_count = $june_count = $july_count = $august_count = $september_count =
        $october_count = $november_count = $december_count = 0;


        foreach($holidays as $holiday)
        {
           $day = Carbon::parse($holiday->holiday_date)->englishDayOfWeek;
           $month = Carbon::parse($holiday->holiday_date)->englishMonth;

           switch ($day)
           {
               case 'Monday':
                   $monday_count++;
                   break;
               case 'Tuesday':
                   $tuesday_count++;
                   break;
               case 'Wednesday':
                   $wednesday_count++;
                   break;
               case 'Thursday':
                   $thursday_count++;
                   break;
               case 'Friday':
                   $friday_count++;
                   break;
               case 'Saturday':
                   $saturday_count++;
                   break;
               case 'Sunday':
                   $sunday_count++;
                   break;
               default:
                   break;
           }

           switch ($month)
           {
               case 'January':
                   $january_count++;
                   break;
               case 'February':
                   $february_count++;
                   break;
               case 'March':
                   $march_count++;
                   break;
               case 'April':
                   $april_count++;
                   break;
               case 'May':
                   $may_count++;
                   break;
               case 'June':
                   $june_count++;
                   break;
               case 'July':
                   $july_count++;
                   break;
               case 'August':
                   $august_count++;
                   break;
               case 'September':
                   $september_count++;
                   break;
               case 'October':
                   $october_count++;
                   break;
               case 'November':
                   $november_count++;
                   break;
               case 'December':
                   $december_count++;
                   break;
               default:
                   break;
           }
        }

        $dayarray = array
            (
                'monday_count' => $monday_count,
                'tuesday_count' => $tuesday_count,
                'wednesday_count' => $wednesday_count,
                'thursday_count' => $thursday_count,
                'friday_count' => $friday_count,
                'saturday_count' => $saturday_count,
                'sunday_count' => $sunday_count,
            );


        $montharray = array
            (
                'january_count' => $january_count,
                'february_count' => $february_count,
                'march_count' => $march_count,
                'april_count' => $april_count,
                'may_count' => $may_count,
                'june_count' => $june_count,
                'july_count' => $july_count,
                'august_count' => $august_count,
                'september_count' => $september_count,
                'october_count' => $october_count,
                'november_count' => $november_count,
                'december_count' => $december_count,
            );

        $highest_day_value = max($dayarray);
        $highest_month_value = max($montharray);

        $holidays_count = $holidays->count();


        return compact(
            'employees',
            'employees_count',
            'male_count',
            'female_count',
            'admin_count',
            'employee_count',
            'approver_count',
            'working_count',
            'resigned_count',
            'taken_so_far_sum',
            'carry_over_sum',
            'balance_leaves_sum',
            'taken_so_far_sum_average',
            'annual_e_average',
            'applications_count',
            'applications_this_year_count',
            'applications_other_year_count',
            'pending_count',
            'approve_count',
            'reject_count',
            'pending_this_year_count',
            'approve_this_year_count',
            'reject_this_year_count',
            'holidays_count',
            'monday_count',
            'tuesday_count',
            'wednesday_count',
            'thursday_count',
            'friday_count',
            'saturday_count',
            'sunday_count',
            'january_count',
            'february_count',
            'march_count',
            'april_count',
            'may_count',
            'june_count',
            'july_count',
            'august_count',
            'september_count',
            'october_count',
            'november_count',
            'december_count',
            'highest_day_value',
            'highest_month_value',
        );

    }

    /**
     * Check For Users with Resigned Approvers.
     *
     * @param int $id
     */
    public function resign_approver(int $id)
    {
        //Queries for users (user_details) with resigned approvers.
        $userdetails   = UserDetail::where('approver_id',$id)->get();
        foreach ($userdetails as $userdetail)
        {
            //Assign null value to approver_id.
            $userdetail->approver_id = null;
            $userdetail->save();
        }
    }

    /**
     * Queries Employee Report Details.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function employee_report(int $id)
    {
        $applications       = LeaveApplication::where('user_id', $id)->get();
        $applications_this_year = LeaveApplication::whereYear('created_at', date('Y'))->where('user_id', $id)->get();
        $applications_count = $applications->count();

        $pending_count      = $applications->where('application_status_id',1)->count();
        $approved_count     = $applications->where('application_status_id',2)->count();
        $rejected_count     = $applications->where('application_status_id',3)->count();

        $applications_this_year_count = $applications_this_year->count();
        $applications_days_taken_sum = $applications->where('application_status_id',2)->sum('days_taken');
        $applications_days_taken_avg = $applications->where('application_status_id',2)->avg('days_taken');

        return compact(
            'pending_count',
            'approved_count',
            'rejected_count',
            'applications_count',
            'applications_this_year_count',
            'applications_days_taken_sum',
            'applications_days_taken_avg',
        );
    }

    /**
     * Queries Application Report.
     *
     * @return \Illuminate\Http\Response
     */
    public function application_report()
    {
        $today  = Carbon::today();
        $start  = $today->startOfWeek(Carbon::SUNDAY)->format('Y-m-d');
        $end    = $today->endOfWeek(Carbon::SATURDAY)->format('Y-m-d');
        $start_dmy  = $today->startOfWeek(Carbon::SUNDAY)->format('d/m/Y');
        $end_dmy    = $today->endOfWeek(Carbon::SATURDAY)->format('d/m/Y');

        $this_week  = LeaveApplication::whereBetween('created_at', [$start, $end])->count();
        $this_month = LeaveApplication::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->count();
        $this_year  = LeaveApplication::whereYear('created_at', date('Y'))->count();
        $until_today= LeaveApplication::all()->count();

        $annuals       = LeaveApplication::where('leave_type_id',1)->paginate(10, ['*'], 'annuals');
        $medicals      = LeaveApplication::where('leave_type_id',2)->paginate(10, ['*'], 'medicals');
        $emergencies   = LeaveApplication::where('leave_type_id',3)->paginate(10, ['*'], 'emergencies');
        $unrecordeds   = LeaveApplication::where('leave_type_id',4)->paginate(10, ['*'], 'unrecordeds');

        $annual_count       = $annuals->count();
        $medical_count      = $medicals->count();
        $emergency_count    = $emergencies->count();
        $unrecorded_count   = $unrecordeds->count();


        return compact(
            'start',
            'end',
            'start_dmy',
            'end_dmy',
            'this_week',
            'this_month',
            'this_year',
            'until_today',
            'annual_count',
            'medical_count',
            'emergency_count',
            'unrecorded_count',
            'annuals',
            'medicals',
            'emergencies',
            'unrecordeds',
        );
    }

    /**
     * Queries Application Report.
     *
     * @return \Illuminate\Http\Response
     */
    public function application_report2()
    {
        $annual_monthly = collect([
            'jan' => $jan = LeaveApplication::where('leave_type_id',1)->whereMonth('created_at', 1)->whereYear('created_at', date('Y'))->count(),
            'feb' => $feb = LeaveApplication::where('leave_type_id',1)->whereMonth('created_at', 2)->whereYear('created_at', date('Y'))->count(),
            'mar' => $mar = LeaveApplication::where('leave_type_id',1)->whereMonth('created_at', 3)->whereYear('created_at', date('Y'))->count(),
            'apr' => $apr = LeaveApplication::where('leave_type_id',1)->whereMonth('created_at', 4)->whereYear('created_at', date('Y'))->count(),
            'may' => $may = LeaveApplication::where('leave_type_id',1)->whereMonth('created_at', 5)->whereYear('created_at', date('Y'))->count(),
            'jun' => $jun = LeaveApplication::where('leave_type_id',1)->whereMonth('created_at', 6)->whereYear('created_at', date('Y'))->count(),
            'jul' => $jul = LeaveApplication::where('leave_type_id',1)->whereMonth('created_at', 7)->whereYear('created_at', date('Y'))->count(),
            'aug' => $aug = LeaveApplication::where('leave_type_id',1)->whereMonth('created_at', 8)->whereYear('created_at', date('Y'))->count(),
            'sep' => $sep = LeaveApplication::where('leave_type_id',1)->whereMonth('created_at', 9)->whereYear('created_at', date('Y'))->count(),
            'oct' => $oct = LeaveApplication::where('leave_type_id',1)->whereMonth('created_at', 10)->whereYear('created_at', date('Y'))->count(),
            'nov' => $nov = LeaveApplication::where('leave_type_id',1)->whereMonth('created_at', 11)->whereYear('created_at', date('Y'))->count(),
            'dec' => $dec = LeaveApplication::where('leave_type_id',1)->whereMonth('created_at', 12)->whereYear('created_at', date('Y'))->count(),
        ]);
        $annual_monthly->toArray();

        $medical_monthly = collect([
            'jan' => $jan = LeaveApplication::where('leave_type_id',2)->whereMonth('created_at', 1)->whereYear('created_at', date('Y'))->count(),
            'feb' => $feb = LeaveApplication::where('leave_type_id',2)->whereMonth('created_at', 2)->whereYear('created_at', date('Y'))->count(),
            'mar' => $mar = LeaveApplication::where('leave_type_id',2)->whereMonth('created_at', 3)->whereYear('created_at', date('Y'))->count(),
            'apr' => $apr = LeaveApplication::where('leave_type_id',2)->whereMonth('created_at', 4)->whereYear('created_at', date('Y'))->count(),
            'may' => $may = LeaveApplication::where('leave_type_id',2)->whereMonth('created_at', 5)->whereYear('created_at', date('Y'))->count(),
            'jun' => $jun = LeaveApplication::where('leave_type_id',2)->whereMonth('created_at', 6)->whereYear('created_at', date('Y'))->count(),
            'jul' => $jul = LeaveApplication::where('leave_type_id',2)->whereMonth('created_at', 7)->whereYear('created_at', date('Y'))->count(),
            'aug' => $aug = LeaveApplication::where('leave_type_id',2)->whereMonth('created_at', 8)->whereYear('created_at', date('Y'))->count(),
            'sep' => $sep = LeaveApplication::where('leave_type_id',2)->whereMonth('created_at', 9)->whereYear('created_at', date('Y'))->count(),
            'oct' => $oct = LeaveApplication::where('leave_type_id',2)->whereMonth('created_at', 10)->whereYear('created_at', date('Y'))->count(),
            'nov' => $nov = LeaveApplication::where('leave_type_id',2)->whereMonth('created_at', 11)->whereYear('created_at', date('Y'))->count(),
            'dec' => $dec = LeaveApplication::where('leave_type_id',2)->whereMonth('created_at', 12)->whereYear('created_at', date('Y'))->count(),
        ]);
        $medical_monthly->toArray();

        $emergency_monthly = collect([
            'jan' => $jan = LeaveApplication::where('leave_type_id',3)->whereMonth('created_at', 1)->whereYear('created_at', date('Y'))->count(),
            'feb' => $feb = LeaveApplication::where('leave_type_id',3)->whereMonth('created_at', 2)->whereYear('created_at', date('Y'))->count(),
            'mar' => $mar = LeaveApplication::where('leave_type_id',3)->whereMonth('created_at', 3)->whereYear('created_at', date('Y'))->count(),
            'apr' => $apr = LeaveApplication::where('leave_type_id',3)->whereMonth('created_at', 4)->whereYear('created_at', date('Y'))->count(),
            'may' => $may = LeaveApplication::where('leave_type_id',3)->whereMonth('created_at', 5)->whereYear('created_at', date('Y'))->count(),
            'jun' => $jun = LeaveApplication::where('leave_type_id',3)->whereMonth('created_at', 6)->whereYear('created_at', date('Y'))->count(),
            'jul' => $jul = LeaveApplication::where('leave_type_id',3)->whereMonth('created_at', 7)->whereYear('created_at', date('Y'))->count(),
            'aug' => $aug = LeaveApplication::where('leave_type_id',3)->whereMonth('created_at', 8)->whereYear('created_at', date('Y'))->count(),
            'sep' => $sep = LeaveApplication::where('leave_type_id',3)->whereMonth('created_at', 9)->whereYear('created_at', date('Y'))->count(),
            'oct' => $oct = LeaveApplication::where('leave_type_id',3)->whereMonth('created_at', 10)->whereYear('created_at', date('Y'))->count(),
            'nov' => $nov = LeaveApplication::where('leave_type_id',3)->whereMonth('created_at', 11)->whereYear('created_at', date('Y'))->count(),
            'dec' => $dec = LeaveApplication::where('leave_type_id',3)->whereMonth('created_at', 12)->whereYear('created_at', date('Y'))->count(),
        ]);
        $emergency_monthly->toArray();

        $unrecorded_monthly = collect([
            'jan' => $jan = LeaveApplication::where('leave_type_id',4)->whereMonth('created_at', 1)->whereYear('created_at', date('Y'))->count(),
            'feb' => $feb = LeaveApplication::where('leave_type_id',4)->whereMonth('created_at', 2)->whereYear('created_at', date('Y'))->count(),
            'mar' => $mar = LeaveApplication::where('leave_type_id',4)->whereMonth('created_at', 3)->whereYear('created_at', date('Y'))->count(),
            'apr' => $apr = LeaveApplication::where('leave_type_id',4)->whereMonth('created_at', 4)->whereYear('created_at', date('Y'))->count(),
            'may' => $may = LeaveApplication::where('leave_type_id',4)->whereMonth('created_at', 5)->whereYear('created_at', date('Y'))->count(),
            'jun' => $jun = LeaveApplication::where('leave_type_id',4)->whereMonth('created_at', 6)->whereYear('created_at', date('Y'))->count(),
            'jul' => $jul = LeaveApplication::where('leave_type_id',4)->whereMonth('created_at', 7)->whereYear('created_at', date('Y'))->count(),
            'aug' => $aug = LeaveApplication::where('leave_type_id',4)->whereMonth('created_at', 8)->whereYear('created_at', date('Y'))->count(),
            'sep' => $sep = LeaveApplication::where('leave_type_id',4)->whereMonth('created_at', 9)->whereYear('created_at', date('Y'))->count(),
            'oct' => $oct = LeaveApplication::where('leave_type_id',4)->whereMonth('created_at', 10)->whereYear('created_at', date('Y'))->count(),
            'nov' => $nov = LeaveApplication::where('leave_type_id',4)->whereMonth('created_at', 11)->whereYear('created_at', date('Y'))->count(),
            'dec' => $dec = LeaveApplication::where('leave_type_id',4)->whereMonth('created_at', 12)->whereYear('created_at', date('Y'))->count(),
        ]);
        $unrecorded_monthly->toArray();

        return compact('annual_monthly','medical_monthly','emergency_monthly','unrecorded_monthly');
    }

    /**
     * Queries Application Report.
     *
     * @param int $period
     * @return \Illuminate\Http\Response
     */
    public function application_period(int $period)
    {
        $today  = Carbon::today();
        $start  = $today->startOfWeek(Carbon::SUNDAY)->format('Y-m-d');
        $end    = $today->endOfWeek(Carbon::SATURDAY)->format('Y-m-d');

        if ($period == 1) {
            $period_title = 'This Week';
            $period_title2 = 'Weekly';
            $period_title3 = "$start - $end";
            $applications  = LeaveApplication::whereBetween('created_at', [$start, $end])->paginate(10, ['*'], 'applications');
            $applications_all  = LeaveApplication::whereBetween('created_at', [$start, $end])->get();
        }
        elseif ($period == 2) {
            $period_title = 'This Month';
            $period_title2 = 'Monthly';
            $period_title3 = date("F");
            $applications = LeaveApplication::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->paginate(10, ['*'], 'applications');
            $applications_all = LeaveApplication::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->paginate(10, ['*'], 'applications');
        }
        elseif ($period == 3) {
            $period_title = 'This Year';
            $period_title2 = 'Yearly';
            $period_title3 = date("Y");
            $applications  = LeaveApplication::whereYear('created_at', date('Y'))->paginate(10, ['*'], 'applications');
            $applications_all  = LeaveApplication::whereYear('created_at', date('Y'))->get();
        }
        else {
            $period_title = 'Until Today';
            $period_title2 = 'Overall';
            $period_title3 = 'Dec 2020 - Present';
            $applications = LeaveApplication::paginate(10, ['*'], 'applications');
            $applications_all = LeaveApplication::all();
        }

        return compact('period_title','period_title2','period_title3','applications','applications_all');
    }


}
