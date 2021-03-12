<?php

namespace App\Http\Controllers;

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
    public function attendance_view()
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

        return view('user.user_log', compact('today','all_logs'));
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
            return redirect()->route('attendance.view')->with('success', 'You have clocked in.');
        }
        else {
            return redirect()->route('attendance.view')->with('error', 'You have already clocked in today!');
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

            return redirect()->route('attendance.view')->with('success', 'You have clocked out!');
        }
        else {
            return redirect()->route('attendance.view')->with('error', 'You have not clocked in today.');
        }
    }



    //Resources

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserLog  $userLog
     * @return \Illuminate\Http\Response
     */
    public function show(UserLog $userLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserLog  $userLog
     * @return \Illuminate\Http\Response
     */
    public function edit(UserLog $userLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserLog  $userLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserLog $userLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserLog  $userLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserLog $userLog)
    {
        //
    }

}
