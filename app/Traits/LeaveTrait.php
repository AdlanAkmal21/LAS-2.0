<?php

namespace App\Traits;

use App\Http\Requests\ApplicationPostRequest;
use App\Mail\NewApplicationMail;
use App\Models\File;
use App\Models\LeaveApplication;
use Carbon\Carbon;

use App\Models\UserDetail;
use App\Models\LeaveDetail;
use App\Notifications\NewApplicationAlert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

trait LeaveTrait
{
    /**
     * Create Leave Details.
     *
     * @param  \App\Models\UserDetail $userdetail
     */
    public function create_leave($userdetail)
    {
        //Calculate Annual Entitlement for New Employees
        $DaysperAnnualLeave     = 365 / 14;
        $date_joined            = Carbon::parse($userdetail->date_joined);
        $year_end               = Carbon::parse(Carbon::now()->endOfYear());
        $servicedays            = ($year_end->diffInDays($date_joined)) + 1;
        $annual_e               = $servicedays / $DaysperAnnualLeave;

        $rounded                = round($annual_e, 1);    //Round off to nearest 0.0
        $entitlement            = round($rounded); //Round off to whole number

        // //For Pushing Input Into DB (Leaves Table)
        $leave                  = new LeaveDetail();
        $leave->user_id         = $userdetail->user_id;
        $leave->annual_e        = $entitlement;
        $leave->carry_over      = 0;
        $leave->taken_so_far    = 0;
        //Calculate Total and Balance Leaves
        $leave->total_leaves    = ($leave->annual_e     + $leave->carry_over);
        $leave->balance_leaves  = ($leave->total_leaves - $leave->taken_so_far);
        //For Pushing Input(Leaves Table)
        $leave->save();
    }

    /**
     * Store a newly created resource in storage (Annual Leave).
     *
     * @param array $all
     * @return \Illuminate\Http\Response
     */
    public function annual_trait(array $all)
    {
        $days_taken = $all['days_taken'];

        (isset($all['half_day'])) ? ($half_day = $all['half_day']) : ($half_day = null);
        (isset($all['reason'])) ? ($reason = $all['reason']) : ($reason = null);

        if ($half_day != null && $days_taken != 0.5) $days_taken -= (0.5);

        if ($days_taken <= Auth::user()->leavedetail->balance_leaves) {
            $applications_temp     = LeaveApplication::where('user_id', Auth::id())->where('application_status_id', 1)->where('leave_type_id', 1)->sum('days_taken');
            $applications_temp_sum = $applications_temp + $days_taken;

            if ($applications_temp_sum <= Auth::user()->leavedetail->balance_leaves) {
                $from     = Carbon::parse($all['from']);
                $from_today = ($from->diffInDays(Carbon::today()));

                if ($days_taken <= 2 && $from_today < 2) {
                    return redirect()->route('application.create')->with('error', 'Cannot Apply: Application Must Be Applied 2 Days Before!')->send();
                } elseif ($days_taken > 2 && $from_today < 7) {
                    return redirect()->route('application.create')->with('error', 'Cannot Apply: Application More Than 2 Days Must Be Applied 7 Days Before!')->send();
                } else {

                    $application                = new LeaveApplication();
                    $application->user_id       = Auth::id();
                    $application->leave_id      = Auth::user()->leavedetail->id;
                    $application->leave_type_id = $all['leave_type_id'];
                    $application->from          = Carbon::parse($all['from']);
                    $application->to            = Carbon::parse($all['to']);
                    $application->half_day      = $half_day;
                    $application->days_taken    = $days_taken;
                    $application->reason        = $reason;
                    $application->save();

                    Mail::to($application->user->userdetail->approver->email)->send(new NewApplicationMail($application->id));
                    $application->user->userdetail->approver->notify(new NewApplicationAlert($application));
                    if (isset($all['file'])) $this->file_upload($application, $all);

                    return redirect()->route('application.index')->with('success', 'Application submitted.')->send();
                }
            } else {
                return redirect()->route('application.create')->with('error', 'Cannot Apply: Pending Applications Exceeds Leave Balance!')->send();
            }
        } else {
            return redirect()->route('application.create')->with('error', 'Cannot Apply: Insufficient Leave Balance!')->send();
        }
    }
    /**
     * Update resource in storage (Annual Leave).
     *
     * @param array $all
     * @param  \App\Models\LeaveApplication  $leaveApplication
     * @return \Illuminate\Http\Response
     */
    public function annual_edit_trait(array $all, LeaveApplication $application)
    {
        $from          = Carbon::parse($all['from']);
        $days_taken    = $all['days_taken'];
        $from_today    = ($from->diffInDays(Carbon::today()));

        (isset($all['half_day'])) ? ($half_day = $all['half_day']) : ($half_day = null);
        (isset($all['reason'])) ? ($reason = $all['reason']) : ($reason = null);

        if ($half_day != null && $days_taken != 0.5){$days_taken = $days_taken - (0.5);}

        if ($days_taken <= 2 && $from_today < 2) {
            return back()->withInput()->with('error', 'Cannot Apply: Application Must Be Applied 2 Days Before!')->send();
        } elseif ($days_taken > 2 && $from_today < 7) {
            return back()->withInput()->with('error', 'Cannot Apply: Application More Than 2 Days Must Be Applied 7 Days Before!')->send();
        } else {
            $application->from          = $from;
            $application->to            = Carbon::parse($all['to']);
            $application->half_day      = $half_day;
            $application->days_taken    = $days_taken;
            $application->reason        = $reason;
            $application->save();

            return redirect()->route('application.index')->with('success', 'Application updated.')->send();
        }
    }

    /**
     * Store a newly created resource in storage (Medical, Emergency, Unrecorded Leave).
     *
     * @param array $all
     * @return \Illuminate\Http\Response
     */
    public function medical_emergency_unrecorded_trait(array $all)
    {
        //Medical Leave Auto-Approved && Emergency Leave must have reason
        if ($all['leave_type_id'] == 2 && !isset($all['file'])) {
            return redirect()->route('application.create')->with('error', 'Medical Leave: Please attach your MC.')->send();
        } elseif ($all['leave_type_id'] == 3 && !isset($all['reason'])) {
            return redirect()->route('application.create')->with('error', 'Emergency Leave: Please State Your Reason.')->send();
        } else {

            (isset($all['half_day'])) ? ($half_day = $all['half_day']) : ($half_day = null);
            $days_taken = $all['days_taken'];
            if ($half_day != null && $days_taken != 0.5){$days_taken = $days_taken - (0.5);}

            $application                = new LeaveApplication();
            $application->user_id       = Auth::id();
            $application->leave_id      = Auth::user()->leavedetail->id;
            $application->leave_type_id = $all['leave_type_id'];
            $application->from          = Carbon::parse($all['from']);
            $application->to            = Carbon::parse($all['to']);
            $application->half_day      = $half_day;
            $application->days_taken    = $days_taken;
            $application->reason        = $all['reason'];

            ($all['leave_type_id'] == 2)
                ? $application->application_status_id = 2
                : $application->application_status_id = 1;

            $application->save();

            Mail::to($application->user->userdetail->approver->email)->send(new NewApplicationMail($application->id));
            $application->user->userdetail->approver->notify(new NewApplicationAlert($application));
            if (isset($all['file'])) $this->file_upload($application, $all);

            return redirect()->route('application.index')->with('success', 'Application submitted.')->send();
        }
    }

    /**
     * Upload File in storage.
     *
     * @param \App\Models\LeaveApplication $application
     * @param array $all
     */
    public function file_upload(LeaveApplication $application, array $all)
    {
        if (isset($all['file'])) {

            $file               = $all['file'];
            $user_name          = Auth::user()->name;
            $current_timestamp  = Carbon::now()->format('Y-m-d');
            $extension          = $file->extension();
            $filename           = "($user_name)($application->id)($current_timestamp).$extension";

            $new_file                    = new File();
            $new_file->application_id    = $application->id;
            $new_file->user_id           = $application->user_id;
            $new_file->filename          = $filename;

            ($application->leave_type_id == 1)
                ? $filecategory = 'Annual_Leave_Files'
                : (($application->leave_type_id == 2)
                    ? $filecategory = 'Medical_Leave_Files'
                    : (($application->leave_type_id == 3)
                        ? $filecategory = 'Emergency_Leave_Files'
                        : $filecategory = 'Unrecorded_Leave_Files'));

            $new_file->filecategory = $filecategory;
            $new_file->save();

            Storage::putFileAs("public/$filecategory", $file, $filename);
        }
    }
}
