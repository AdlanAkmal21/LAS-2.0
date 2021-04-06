<?php

namespace App\Http\Controllers;

use App\Exports\PeriodExport;
use App\Models\LeaveApplication;
use App\Models\User;
use App\Traits\AdminTrait;
use App\Traits\UserTrait;
use Carbon\Carbon;
use Dompdf\Dompdf as Dompdf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

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

}
