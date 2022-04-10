<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplicationEditRequest;
use App\Http\Requests\ApplicationPostRequest;
use App\Models\File;
use App\Models\Holiday;
use App\Models\LeaveApplication;
use App\Models\RefLeaveType;
use App\Traits\LeaveTrait;
use Carbon\Carbon;
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
        $alls       = LeaveApplication::where('user_id', Auth::id())->orderBy('created_at', 'desc')->paginate(10, ['*'], 'alls');
        $pendings   = LeaveApplication::where('user_id', Auth::id())->where('application_status_id', 1)->orderBy('created_at', 'desc')->paginate(10, ['*'], 'pendings');
        $approveds  = LeaveApplication::where('user_id', Auth::id())->where('application_status_id', 2)->orderBy('created_at', 'desc')->paginate(10, ['*'], 'approveds');
        $rejecteds  = LeaveApplication::where('user_id', Auth::id())->where('application_status_id', 3)->orderBy('created_at', 'desc')->paginate(10, ['*'], 'rejecteds');

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
        $alls       = LeaveApplication::where('user_id', Auth::id())->whereYear('created_at', $year)->orderBy('created_at', 'desc')->paginate(10, ['*'], 'alls');
        $pendings   = LeaveApplication::where('user_id', Auth::id())->whereYear('created_at', $year)->where('application_status_id', 1)->orderBy('created_at', 'desc')->paginate(10, ['*'], 'pendings');
        $approveds  = LeaveApplication::where('user_id', Auth::id())->whereYear('created_at', $year)->where('application_status_id', 2)->orderBy('created_at', 'desc')->paginate(10, ['*'], 'approveds');
        $rejecteds  = LeaveApplication::where('user_id', Auth::id())->whereYear('created_at', $year)->where('application_status_id', 3)->orderBy('created_at', 'desc')->paginate(10, ['*'], 'rejecteds');

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

            //Annual or Replacement or Special
        if ($all['leave_type_id'] == 1 || $all['leave_type_id'] == 5 || $all['leave_type_id'] == 6) {
            $this->annual_replacement_special_trait($all);
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

        $this->annual_replacement_special_edit_trait($all, $application);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LeaveApplication  $application
     * @return \Illuminate\Http\Response
     */
    public function destroy(LeaveApplication $application)
    {
        if ($file = File::where('application_id', $application->id)->first()) {
            Storage::delete("public/$file->filecategory/$file->filename");
            $file->delete();
        }

        //Re-calculate Applicant's Leave Detail.
        $this->recalculate_leave_detail($application->leavedetail);

        $application->delete();

        return redirect()->route('application.index')->with('error', 'Application removed.');
    }
}
