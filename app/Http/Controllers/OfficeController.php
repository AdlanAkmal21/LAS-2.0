<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OfficeLog;
use App\Traits\UserTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OfficeController extends Controller
{
    use UserTrait;

    /**
     * Show the attendance page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //WFH Auto-Clock-Out
        DB::table('office_logs')
            ->whereDate('created_at', '<', Carbon::now())
            ->whereNull('clock_out')
            ->update(array('period' => 'Did not clock out.'));

        $today      = OfficeLog::where('user_id', Auth::id())
                    ->whereDate('created_at', Carbon::today()->toDateString())
                    ->first();

        $all_logs  = OfficeLog::where('user_id', Auth::id())
                    ->orderBy('date','DESC')
                    ->paginate(5);

        return view('user.office.office_index', compact('today','all_logs'));
    }

    /**
     * Clock In.
     *
     * @return \Illuminate\Http\Response
     */
    public function clock_in()
    {
        if(OfficeLog::where('user_id', Auth::id())->whereDate('created_at', Carbon::today()->toDateString())->doesntExist()){

            $new_log            = new OfficeLog();
            $new_log->user_id   = Auth::id();
            $new_log->date      = Carbon::now()->toDateString();
            $new_log->clock_in  = Carbon::now()->format('H:i:s');
            $new_log->save();

            return redirect()->route('office.index')->with('success', 'You have clocked in.');
        }
        else {
            return redirect()->route('office.index')->with('error', 'You have already clocked in today!');
        }
    }

    /**
     * Clock Out.
     *
     * @return \Illuminate\Http\Response
     */
    public function clock_out()
    {
        if ($today = OfficeLog::where('user_id', Auth::id())->whereDate('created_at', Carbon::today()->toDateString())->first()) {

            $now    = Carbon::now()->format('H:i:s');
            $init   = Carbon::parse($today->clock_in)->diffInSeconds(Carbon::parse($now));

            if($init < 60){
                $today->period = $init.'s';
            }
            else {
                $hours = floor($init / 3600);
                $minutes = floor(($init / 60) % 60);

                if ($hours == 0) {
                    $today->period = $minutes.'m';
                } else {
                    $today->period = $hours.'h '.$minutes.'m';
                }

            }

            $today->clock_out = $now;
            $today->save();

            return redirect()->route('office.index')->with('success', 'You have clocked out!');
        }
        else {
            return redirect()->route('office.index')->with('error', 'You have not clocked in today.');
        }
    }

    /**
     * Display listings of office logs.
     *
     * @return \Illuminate\Http\Response
     */
    public function office_logs()
    {
        $date = '';
        $month = '';
        $year = '';
        $office_logs = OfficeLog::where('user_id', Auth::id())->get();

        return view('user.office.office_search', compact('office_logs', 'month', 'year', 'date'));
    }

    /**
     * Searched listings of office logs.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function office_logs_search(Request $request)
    {
        $date = $request->get('date');

        if($date == ''){
            $month = '';
            $year = '';
            $office_logs = OfficeLog::where('user_id', Auth::id())->get();
        } else{
            $month = date('m', strtotime($request->get('date')));
            $year = date('Y', strtotime($request->get('date')));
            $office_logs = OfficeLog::where('user_id', Auth::id())->whereYear('date', $year)->whereMonth('date', $month)->get();
        }

        return view('user.office.office_search', compact('office_logs', 'month', 'year', 'date'));
    }


    /**
     * Display listings of office logs.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_office_index()
    {
        $month = '';
        $year = '';
        $office_logs = OfficeLog::all();

        return view('admin.office.office_index', compact('office_logs', 'month', 'year'));
    }

    /**
     * Display listings of searched office logs.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function admin_office_search(Request $request)
    {
        if($request->get('date') == ''){
            $month = '';
            $year = '';
            $office_logs = OfficeLog::all();
        } else{
            $month = date('m', strtotime($request->get('date')));
            $year = date('Y', strtotime($request->get('date')));
            $office_logs = OfficeLog::whereYear('date', $year)->whereMonth('date', $month)->get();
        }

        return view('admin.office.office_index', compact('office_logs', 'month', 'year'));
    }
}
