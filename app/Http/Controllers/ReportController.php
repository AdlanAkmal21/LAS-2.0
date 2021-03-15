<?php

namespace App\Http\Controllers;

use App\Models\LeaveApplication;
use App\Models\User;
use App\Traits\AdminTrait;
use App\Traits\UserTrait;

use Illuminate\Http\Request;
use Laracasts\Utilities\JavaScript\JavaScriptFacade;

class ReportController extends Controller
{
    use UserTrait;
    use AdminTrait;

    /**
     * Display overview of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function overview()
    {
        $dashboard_admins_array = $this->dashboard_admins();
        JavaScriptFacade::put(['dashboard_admins_array' => $dashboard_admins_array]);

        return view('report.overview_report', compact('dashboard_admins_array'));
    }

    /**
     * Search for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $query = $request->search;
        $users = User::where('id', '!=', 1)->where('name', 'like', "%{$query}%")->paginate(10);

        return view('report.individual_list', compact('users', 'query'));
    }

    /**
     * Display a listing of the individuals.
     *
     * @return \Illuminate\Http\Response
     */
    public function individual()
    {
        $users = User::where('users.id', '!=', 1)->paginate(10);

        return view('report.individual_list', compact('users'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view_individual(int $id)
    {
        $user = User::find($id);
        $employee_report_array = $this->employee_report($id);

        JavaScriptFacade::put(['employee_report_array' =>  $employee_report_array]);

        return view('report.individual_report', compact('user','employee_report_array'));
    }

    /**
     * Display a listing of the application report.
     *
     * @return \Illuminate\Http\Response
     */
    public function application()
    {
        $alls = LeaveApplication::paginate(10, ['*'], 'alls');

        return view('report.application_list', compact('alls'));
    }
}
