<?php

namespace App\Http\Controllers;

use App\Exports\PeriodExport;
use App\Models\LeaveApplication;
use App\Models\User;
use App\Models\UserLog;
use App\Traits\AdminTrait;
use App\Traits\UserTrait;
use Carbon\Carbon;
use Dompdf\Dompdf as Dompdf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrintController extends Controller
{
    use UserTrait;
    use AdminTrait;


    public function generate_overview()
    {
        $users  = User::where('id', '!=', 1)->paginate(10, ['*'], 'users');
        $most_this_month = User::where('id', '!=', 1)->withCount('application')->orderBy('application_count', 'desc')->take(10)->get();

        $application_report_array = $this->application_report();
        $monthly_array = $this->application_report2();

        $dompdf = new Dompdf();
        $dompdf->loadHtml(view('report.application.application_index_pdf', compact('users', 'application_report_array', 'most_this_month')));

        $dompdf->setPaper('A4', 'potrait');

        $dompdf->render();

        $dompdf->stream("Application Report - Overview.pdf");
    }

    public function generate_period(int $period)
    {
        $application_period_array = $this->application_period($period);

        $dompdf = new Dompdf();
        $dompdf->loadHtml(view('report.application.application_period_pdf', compact('application_period_array')));

        $dompdf->setPaper('A4', 'landscape');

        $dompdf->render();

        $dompdf->stream("Application Report - Period.pdf");
    }

    public function generate_period_xlsx(int $period)
    {
        $now = Carbon::now();
        return Excel::download(new PeriodExport($period), "$now.xlsx");
    }

    public function generate_application_pdf(LeaveApplication $application)
    {
        $dompdf = new Dompdf();
        $dompdf->loadHtml(view('admin.application.application_show_pdf', compact('application')));

        $dompdf->setPaper('A4', 'potrait');

        $dompdf->render();

        $dompdf->stream("Application $application->id.pdf");
    }

    public function generate_user_log(Request $request)
    {
        $user_name = Auth::user()->name;

        if($request->get('month') == '' && $request->get('year') == ''){
            $user_logs = UserLog::where('user_id', Auth::id())->get();
        } else{
            $month = $request->get('month');
            $year = $request->get('year');
            $user_logs = UserLog::where('user_id', Auth::id())->whereYear('date', $year)->whereMonth('date', $month)->get();
        }

        $dompdf = new Dompdf();
        $dompdf->loadHtml(view('report.user_log.user_logs_pdf', compact('user_logs')));
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $timestamp = Carbon::now();
        $dompdf->stream("Work From Home-$user_name-$timestamp.pdf");
    }

    public function generate_user_log_admin(Request $request)
    {
        $user_name = Auth::user()->name;

        if($request->get('month') == '' && $request->get('year') == ''){
            $user_logs = UserLog::all();
        } else{
            $month = $request->get('month');
            $year = $request->get('year');
            $user_logs = UserLog::whereYear('date', $year)->whereMonth('date', $month)->get();
        }

        $dompdf = new Dompdf();
        $dompdf->loadHtml(view('report.user_log.user_logs_pdf_admin', compact('user_logs')));
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $timestamp = Carbon::now();
        $dompdf->stream("Work From Home-$user_name-$timestamp.pdf");
    }

}
