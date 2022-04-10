<?php

namespace App\Http\Controllers;

use App\Models\OfficeLog;
use App\Models\UserLog;
use App\Traits\UserTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserLogController extends Controller
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
        DB::table('user_logs')
            ->whereDate('created_at', '<', Carbon::now())
            ->whereNull('clock_out')
            ->update(array('period' => 'Did not clock out.'));

        $today      = UserLog::where('user_id', Auth::id())
                    ->whereDate('created_at', Carbon::today()->toDateString())
                    ->first();

        $all_logs  = UserLog::where('user_id', Auth::id())
                    ->orderBy('date','DESC')
                    ->paginate(5);

        return view('user.user_log.user_log_index', compact('today','all_logs'));
    }

    /**
     * Clock In.
     *
     * @return \Illuminate\Http\Response
     */
    public function clock_in()
    {
        if(UserLog::where('user_id', Auth::id())->whereDate('created_at', Carbon::today()->toDateString())->doesntExist()){

            $this->clock_in_trait();

            return redirect()->route('user_log.index')->with('success', 'You have clocked in.');
        }
        else {
            return redirect()->route('user_log.index')->with('error', 'You have already clocked in today!');
        }
    }

    /**
     * Clock Out.
     *
     * @return \Illuminate\Http\Response
     */
    public function clock_out()
    {
        if ($today = UserLog::where('user_id', Auth::id())->whereDate('created_at', Carbon::today()->toDateString())->first()) {

            $this->clock_out_trait($today);

            return redirect()->route('user_log.index')->with('success', 'You have clocked out!');
        }
        else {
            return redirect()->route('user_log.index')->with('error', 'You have not clocked in today.');
        }
    }

    /**
     * Display listings of user logs.
     *
     * @return \Illuminate\Http\Response
     */
    public function user_log_index()
    {
        $date = '';
        $month = '';
        $year = '';
        $user_logs = UserLog::where('user_id', Auth::id())->get();

        return view('user.user_log.user_log_search', compact('user_logs', 'month', 'year', 'date'));
    }

        /**
     * Display listings of user logs.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function user_log_search(Request $request)
    {
        $date = $request->get('date');

        if($date == ''){
            $month = '';
            $year = '';
            $user_logs = UserLog::where('user_id', Auth::id())->get();
        } else{
            $month = date('m', strtotime($request->get('date')));
            $year = date('Y', strtotime($request->get('date')));
            $user_logs = UserLog::where('user_id', Auth::id())->whereYear('date', $year)->whereMonth('date', $month)->get();
        }

        return view('user.user_log.user_log_search', compact('user_logs', 'month', 'year', 'date'));
    }



    /**
     * Display listings of user logs (Admin).
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_user_log_index()
    {
        $month = '';
        $year = '';
        $user_logs = UserLog::all();

        return view('admin.user_log.user_log_index', compact('user_logs', 'month', 'year'));
    }

    /**
     * Search listings of user logs (Admin).
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function admin_user_log_search(Request $request)
    {
        if($request->get('date') == ''){
            $month = '';
            $year = '';
            $user_logs = UserLog::all();
        } else{
            $month = date('m', strtotime($request->get('date')));
            $year = date('Y', strtotime($request->get('date')));
            $user_logs = UserLog::whereYear('date', $year)->whereMonth('date', $month)->get();
        }

        return view('admin.user_log.user_log_index', compact('user_logs', 'month', 'year'));
    }
}
