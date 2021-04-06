<?php

namespace App\Http\Controllers;

use App\Models\LeaveApplication;
use App\Models\User;
use App\Traits\AdminTrait;
use App\Traits\UserTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laracasts\Utilities\JavaScript\JavaScriptFacade;
use Jimmyjs\ReportGenerator\Facades\PdfReportFacade as PdfReport;

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
     * Display a listing of the individuals.
     *
     * @return \Illuminate\Http\Response
     */
    public function individual()
    {
        $users = User::where('users.id', '!=', 1)->paginate(10);

        return view('report.individual.individual_list', compact('users'));
    }

    /**
     * Search for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search_employee(Request $request)
    {
        $query = $request->search;
        $users = User::where('id', '!=', 1)->where('name', 'like', "%{$query}%")->paginate(10);

        return view('report.individual.individual_list', compact('users', 'query'));
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

        return view('report.individual.individual_report', compact('user', 'employee_report_array'));
    }

    /**
     * Display a listing of the application report.
     *
     * @return \Illuminate\Http\Response
     */
    public function application()
    {
        $users  = User::where('id', '!=', 1)->paginate(10, ['*'], 'users');
        $most_this_month = User::where('id', '!=', 1)->withCount('application')->orderBy('application_count', 'desc')->paginate(5, ['*'], 'most_this_month');
        $application_report_array = $this->application_report();
        $monthly_array = $this->application_report2();

        JavaScriptFacade::put([
            'application_report_array' =>  $application_report_array,
            'monthly_array' =>  $monthly_array,
        ]);

        return view(
            'report.application.application_index',
            compact('users', 'application_report_array', 'most_this_month')
        );
    }

    /**
     * Search for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search_application_employee(Request $request)
    {
        $query = $request->search;
        $users = User::where('id', '!=', 1)->where('name', 'like', "%{$query}%")->paginate(10, ['*'], 'users');
        $most_this_month = User::where('id', '!=', 1)->withCount('application')->orderBy('application_count', 'desc')->paginate(5, ['*'], 'most_this_month');
        $application_report_array = $this->application_report();
        $monthly_array = $this->application_report2();


        JavaScriptFacade::put([
            'application_report_array' =>  $application_report_array,
            'monthly_array' =>  $monthly_array,
        ]);

        return view(
            'report.application.application_index',
            compact('users', 'query', 'application_report_array', 'most_this_month')
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $period
     * @return \Illuminate\Http\Response
     */
    public function application_period_overview(int $period)
    {
        $application_period_array = $this->application_period($period);

        return view(
            'report.application.application_period_overview',
            compact('period', 'application_period_array')
        );
    }

}
