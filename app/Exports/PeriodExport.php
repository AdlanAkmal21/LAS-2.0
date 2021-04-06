<?php

namespace App\Exports;

use App\Traits\AdminTrait;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PeriodExport implements FromView
{
    use AdminTrait;
    protected $period;

    public function __construct(int $period)
    {
        $this->period = $period;
    }

    public function view(): View
    {
        $application_period_array = $this->application_period($this->period);
        $applications = $application_period_array["applications_all"];

        return view('report.application.application_period_xlsx', compact('applications'));
    }
}
