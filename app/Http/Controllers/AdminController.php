<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AdminEditRequest;
use App\Http\Requests\AdminPostRequest;
use App\Models\ActivityLog;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\File;
use App\Models\LeaveApplication;
use App\Models\OfficeLog;
use App\Models\RefRole;
use App\Models\RefEmpStatus;
use App\Models\RefGender;
use App\Models\RefLeaveType;
use App\Models\UserLog;
use App\Traits\AdminTrait;
use App\Traits\IndexTrait;
use App\Traits\LeaveTrait;
use App\Traits\UserTrait;

use Carbon\Carbon;


class AdminController extends Controller
{
    use LeaveTrait;
    use UserTrait;
    use AdminTrait;
    use IndexTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dashboard_admins_array   = $this->dashboard_admins();
        $offdutyArray           = $this->off_duty_index();

        // dd($offdutyArray);

        return view('admin.dashboard', compact('dashboard_admins_array', 'offdutyArray'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $approvers  = User::where('role_id', 3)->where('emp_status_id', 1)->get();
        $roles      = RefRole::where('id', '!=', 1)->get();
        $genders    = RefGender::all();

        return view('admin.employee.employee_add', compact('approvers', 'roles', 'genders'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Requests\AdminPostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminPostRequest $request)
    {
        $user                    = new User();
        $user->name              = $request->get('name');
        $user->email             = $request->get('email');
        $user->role_id           = $request->get('role_id');
        $user->password          = Hash::make("igsprotech2020");
        $user->save();

        $userdetail                = new UserDetail();
        $userdetail->user_id       = $user->id;
        $userdetail->phoneNum      = $request->get('phoneNum');
        $userdetail->ic            = $request->get('ic');
        $userdetail->gender_id     = $request->get('gender_id');
        $userdetail->date_joined   = $request->get('date_joined');
        $userdetail->approver_id   = $request->get('approver_id');
        $userdetail->last_carry_over = Carbon::now()->year;
        $userdetail->save();

        $this->create_leave($userdetail);

        return redirect()->route('admin.create')->with('success', 'Employee added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $this->check_approver($id);
        $user   = User::find($id);

        return view('admin.employee.employee_show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $user                   = User::find($id);
        $approvers              = User::where('role_id', 3)->where('emp_status_id', 1)->get();
        $refEmpStatus           = RefEmpStatus::get();

        return view('admin.employee.employee_edit', compact('user', 'approvers', 'refEmpStatus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Requests\AdminEditRequest  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminEditRequest $request, int $id)
    {
        $user       = User::find($id);
        $userdetail   = $user->userdetail;

        if ((User::where('email', $request->get('email'))->exists()) && ($user->email != $request->get('email'))) {
            return back()->withInput()->with('error', 'Email exists! Please enter another email address!');
        }

        $user->name            = $request->get('name');
        $user->email           = $request->get('email');
        $user->emp_status_id   = $request->get('emp_status_id');
        $user->save();

        $userdetail->phoneNum    = $request->get('phoneNum');
        $userdetail->approver_id = $request->get('approver_id');
        $userdetail->save();

        return redirect()->route('admin.employee_list')->with('success', 'Employee Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $user = User::find($id);
        $user->emp_status_id = 2;

        if ($user->role_id == 3) {
            $this->resign_approver($user->id);
        }

        $user->save();

        return redirect()->route('admin.employee_list')->with('error', 'Employee Resigned.');
    }

    /**
     * Search employee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $query = $request->search;
        $users = User::where('id', '!=', 1)->where('name', 'like', "%{$query}%")->paginate(10);

        return view('admin.employee.employee_list', compact('users', 'query'));
    }

    /**
     * Search Resigned Employees.
     *
     * @return \Illuminate\Http\Response
     */
    public function search_resigned()
    {
        $users = User::where('id', '!=', 1)->where('emp_status_id', 2)->paginate(10);

        return view('admin.employee.employee_list', compact('users'));
    }
    /**
     * Search Resigned Employees.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search_report(Request $request)
    {
        $query = $request->search;
        $users = User::where('id', '!=', 1)->where('name', 'like', "%{$query}%")->paginate(10);

        return view('report.individual.individual_list', compact('users'));
    }

    /**
     * Display a listing of employees.
     *
     * @return \Illuminate\Http\Response
     */
    public function employee_list()
    {
        $users = User::where('id', '!=', 1)->paginate(10);
        return view('admin.employee.employee_list', compact('users'));
    }

    /**
     * Display a listing of applications (admin).
     *
     * @return \Illuminate\Http\Response
     */
    public function application_list()
    {
        $title      = '(Overall)';
        $alls       = LeaveApplication::orderBy('created_at', 'desc')->paginate(10, ['*'], 'alls');
        $pendings   = LeaveApplication::where('application_status_id', 1)->orderBy('created_at', 'desc')->paginate(10, ['*'], 'pendings');
        $approveds  = LeaveApplication::where('application_status_id', 2)->orderBy('created_at', 'desc')->paginate(10, ['*'], 'approveds');
        $rejecteds  = LeaveApplication::where('application_status_id', 3)->orderBy('created_at', 'desc')->paginate(10, ['*'], 'rejecteds');

        return view('admin.application.application_list', compact('title', 'alls', 'pendings', 'approveds', 'rejecteds'));
    }

    /**
     * Display a listing of applications (This Year)(admin).
     *
     * @param  int $year
     * @return \Illuminate\Http\Response
     */
    public function application_list_ty(int $year)
    {
        $title      = '(This Year)';
        $alls       = LeaveApplication::whereYear('created_at', $year)->orderBy('created_at', 'desc')->paginate(10, ['*'], 'alls');
        $pendings   = LeaveApplication::whereYear('created_at', $year)->where('application_status_id', 1)->orderBy('created_at', 'desc')->paginate(10, ['*'], 'pendings');
        $approveds  = LeaveApplication::whereYear('created_at', $year)->where('application_status_id', 2)->orderBy('created_at', 'desc')->paginate(10, ['*'], 'approveds');
        $rejecteds  = LeaveApplication::whereYear('created_at', $year)->where('application_status_id', 3)->orderBy('created_at', 'desc')->paginate(10, ['*'], 'rejecteds');

        return view('admin.application.application_list', compact('title', 'alls', 'pendings', 'approveds', 'rejecteds'));
    }
    /**
     * Display a listing of applications (From an Employee)(admin).
     *
     * @param  int $user_id
     * @return \Illuminate\Http\Response
     */
    public function application_list_employee(int $user_id)
    {
        $user       = User::find($user_id);
        $title      = "($user->name)";
        $alls       = LeaveApplication::where('user_id', $user->id)->orderBy('created_at', 'desc')->paginate(10, ['*'], 'alls');
        $pendings   = LeaveApplication::where('user_id', $user->id)->where('application_status_id', 1)->orderBy('created_at', 'desc')->paginate(10, ['*'], 'pendings');
        $approveds  = LeaveApplication::where('user_id', $user->id)->where('application_status_id', 2)->orderBy('created_at', 'desc')->paginate(10, ['*'], 'approveds');
        $rejecteds  = LeaveApplication::where('user_id', $user->id)->where('application_status_id', 3)->orderBy('created_at', 'desc')->paginate(10, ['*'], 'rejecteds');

        return view('admin.application.application_list', compact('title', 'alls', 'pendings', 'approveds', 'rejecteds'));
    }

    /**
     * Show application (admin).
     *
     * @param  \App\Models\LeaveApplication $application
     * @return \Illuminate\Http\Response
     */
    public function application_show(LeaveApplication $application)
    {
        $file = File::where('application_id', $application->id)->first();

        return view('admin.application.application_show', compact('application', 'file'));
    }

    /**
     * Display the listing of resource and search resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search_application()
    {
        $applications  = LeaveApplication::orderBy('created_at', 'desc')->paginate(10);
        $refLeaveTypes = RefLeaveType::all();

        return view('admin.application.search_application', compact('applications', 'refLeaveTypes'));
    }

    /**
     * Search for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search_application_search(Request $request)
    {
        $refLeaveTypes = RefLeaveType::all();

        if ($request->leave_type_id && $request->from && $request->to) {
            $applications = LeaveApplication::where('leave_type_id', $request->leave_type_id)->whereDate('from', $request->from)->whereDate('to', $request->to)->orderBy('created_at', 'desc')->paginate(10);
        } elseif ($request->from && $request->to) {
            $applications = LeaveApplication::whereDate('from', '>=', $request->from)->whereDate('to', '<=', $request->to)->orderBy('created_at', 'desc')->paginate(10);
        } elseif ($request->leave_type_id && $request->from) {
            $applications = LeaveApplication::where('leave_type_id', $request->leave_type_id)->whereDate('from', $request->from)->orderBy('created_at', 'desc')->paginate(10);
        } elseif ($request->leave_type_id && $request->to) {
            $applications = LeaveApplication::where('leave_type_id', $request->leave_type_id)->whereDate('to', $request->to)->orderBy('created_at', 'desc')->paginate(10);
        } elseif ($request->from) {
            $applications = LeaveApplication::whereDate('from', $request->from)->orderBy('created_at', 'desc')->paginate(10);
        } elseif ($request->to) {
            $applications = LeaveApplication::whereDate('to', $request->to)->orderBy('created_at', 'desc')->paginate(10);
        } elseif ($request->leave_type_id) {
            $applications = LeaveApplication::where('leave_type_id', $request->leave_type_id)->orderBy('created_at', 'desc')->paginate(10);
        } else {
            $applications = LeaveApplication::orderBy('created_at', 'desc')->paginate(10);
        }

        return view('admin.application.search_application', compact('applications', 'refLeaveTypes'));
    }

    /**
    * Display the listing of resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function activity_log()
    {
        $activities = ActivityLog::orderBy('created_at', 'desc')->paginate(20);

        return view('admin.activity_log.activity_log_index', compact('activities'));
    }

}
