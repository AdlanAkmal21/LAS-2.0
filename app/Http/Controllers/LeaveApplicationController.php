<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplicationEditRequest;
use App\Http\Requests\ApplicationPostRequest;
use App\Models\File;
use App\Models\Holiday;
use App\Models\LeaveApplication;
use App\Models\RefLeaveType;
use App\Traits\LeaveTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Laracasts\Utilities\JavaScript\JavaScriptFacade;

class LeaveApplicationController extends Controller
{

    use LeaveTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title      = '(Overall)';
        $alls       = LeaveApplication::where('user_id', Auth::id())->paginate(5, ['*'], 'alls');
        $pendings   = LeaveApplication::where('user_id', Auth::id())->where('application_status_id', 1)->paginate(5, ['*'], 'pendings');
        $approveds  = LeaveApplication::where('user_id', Auth::id())->where('application_status_id', 2)->paginate(5, ['*'], 'approveds');
        $rejecteds  = LeaveApplication::where('user_id', Auth::id())->where('application_status_id', 3)->paginate(5, ['*'], 'rejecteds');

        return view('application.application_list', compact('title', 'alls', 'pendings', 'approveds', 'rejecteds'));
    }

        /**
     * Display a listing of the resource (This Year).
     *
     * @param  int $year
     * @return \Illuminate\Http\Response
     */
    public function index_ty(int $year)
    {
        $title      = '(This Year)';
        $alls       = LeaveApplication::where('user_id', Auth::id())->whereYear('created_at', $year)->paginate(5, ['*'], 'alls');
        $pendings   = LeaveApplication::where('user_id', Auth::id())->whereYear('created_at', $year)->where('application_status_id', 1)->paginate(5, ['*'], 'pendings');
        $approveds  = LeaveApplication::where('user_id', Auth::id())->whereYear('created_at', $year)->where('application_status_id', 2)->paginate(5, ['*'], 'approveds');
        $rejecteds  = LeaveApplication::where('user_id', Auth::id())->whereYear('created_at', $year)->where('application_status_id', 3)->paginate(5, ['*'], 'rejecteds');

        return view('application.application_list', compact('title', 'alls', 'pendings', 'approveds', 'rejecteds'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $refLeaveTypes   = RefLeaveType::get();
        $holidays        = Holiday::pluck('holiday_date');

        JavaScriptFacade::put(['holidays' => $holidays]);

        return view('application.apply', compact('refLeaveTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\ApplicationPostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ApplicationPostRequest $request)
    {
        $all = $request->all();

        //Annual
        if ($all['leave_type_id'] == 1) {
            $this->annual_trait($all);
        } else {
        //Medical or Emergency or Unrecorded
            $this->medical_emergency_unrecorded_trait($all);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LeaveApplication  $application
     * @return \Illuminate\Http\Response
     */
    public function show(LeaveApplication $application)
    {
        $file = File::where('application_id', $application->id)->first();

        return view('application.application_show', compact('application', 'file'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LeaveApplication  $application
     * @return \Illuminate\Http\Response
     */
    public function edit(LeaveApplication $application)
    {
        $holidays    = Holiday::pluck('holiday_date');
        JavaScriptFacade::put(['holidays' => $holidays]);

        return view('application.application_edit', compact('application'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\ApplicationEditRequest  $request
     * @param  \App\Models\LeaveApplication  $leaveApplication
     */
    public function update(ApplicationEditRequest $request, LeaveApplication $application)
    {
        $all = $request->all();

        //Annual Validation/ Update
        if ($all['leave_type_id'] == 1) {
            $this->annual_edit_trait($all, $application);
        } else {
        //Medical or Emergency or Unrecorded Validation/ Update
            $this->medical_emergency_unrecorded_edit_trait($all, $application);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LeaveApplication  $application
     * @return \Illuminate\Http\Response
     */
    public function destroy(LeaveApplication $application)
    {
        if (File::where('application_id', $application->id)->exists()) {
            $file        = File::where('application_id', $application->id)->first();
            Storage::delete("public/$file->filecategory/$file->filename");
            $file->delete();
        }

        //If approved annual leave or emergency, reimburse days taken.
        if (($application->leave_type_id == 1 || $application->leave_type_id == 3) && $application->application_status_id == 2) {
            $application->leavedetail->balance_leaves = ($application->leavedetail->balance_leaves)+($application->days_taken);
            $application->leavedetail->taken_so_far  -= $application->days_taken;
            $application->leavedetail->save();
        }

        $application->delete();

        return redirect()->route('application.index')->with('error', 'Application removed.');
    }
}
