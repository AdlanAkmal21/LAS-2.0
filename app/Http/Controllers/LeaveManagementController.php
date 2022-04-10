<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\LeaveDetail;
use App\Models\LeaveManagement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $leave_details = LeaveDetail::all();
        return view('admin.leave.index', compact('leave_details'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $user_id = Auth::id();
        $name = Auth::user()->name;
        $now = Carbon::now();

        $leave_type = $request->get('leave_type');
        $option = $request->get('option');
        $amount = $request->get('amount');

        if (empty($leave_type) || empty($option) || empty($amount)) {
            return redirect()->route('leave_management.index')->with('error', 'Please enter details.');
        } else {
            if ($request->get('submitBtn') == 'submit_all') {
                $leave_details = LeaveDetail::all();

                foreach ($leave_details as $leave_detail) {
                    if ($option == 'add') {
                        if ($leave_type == 'annual_e') {
                            $leave_detail->annual_e += $amount;
                        } elseif ($leave_type == 'replacement_leaves') {
                            $leave_detail->replacement_leaves += $amount;
                        } else {
                            $leave_detail->special_leaves += $amount;
                        }
                    }else{
                        if ($amount < $leave_detail->$leave_type) {
                            if ($leave_type == 'annual_e') {
                                $leave_detail->annual_e -= $amount;
                            } elseif ($leave_type == 'replacement_leaves') {
                                $leave_detail->replacement_leaves -= $amount;
                            } else {
                                $leave_detail->special_leaves -= $amount;
                            }
                        }
                    }

                    $leave_detail->save();
                }

                $option_desc = ($option == 'add') ? 'added' : 'subtracted';

                $activity_log = new ActivityLog();
                $activity_log->user_id = $user_id;
                $activity_log->description = "$name $option_desc $amount from all staff's leave detail at $now.";
                $activity_log->save();

            } else {
                $leave_ids = $request->get('leave_ids');

                if (empty($leave_ids)) {
                    return redirect()->route('leave_management.index')->with('error', 'Please select staff(s).');
                } else {
                    foreach ($leave_ids as $leave_id) {
                        $leave_detail = LeaveDetail::find($leave_id);

                        if ($option == 'add') {
                            if ($leave_type == 'annual_e') {
                                $leave_detail->annual_e += $amount;
                            } elseif ($leave_type == 'replacement_leaves') {
                                $leave_detail->replacement_leaves += $amount;
                            } else {
                                $leave_detail->special_leaves += $amount;
                            }
                        } else{
                            if ($amount < $leave_detail->$leave_type) {
                                if ($leave_type == 'annual_e') {
                                    $leave_detail->annual_e -= $amount;
                                } elseif ($leave_type == 'replacement_leaves') {
                                    $leave_detail->replacement_leaves -= $amount;
                                } else {
                                    $leave_detail->special_leaves -= $amount;
                                }
                            }
                        }

                        $leave_detail->save();
                    }

                    $option_desc = ($option == 'add') ? 'added' : 'subtracted';
                    $count = count($leave_ids);

                    $activity_log = new ActivityLog();
                    $activity_log->user_id = $user_id;
                    $activity_log->description = "$name $option_desc $amount from $count staff(s) leave detail(s) at $now.";
                    $activity_log->save();
                }
            }

            return redirect()->route('leave_management.index')->with('success', 'Leave Detail Updated!');
        }

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LeaveDetail  $leave_detail
     * @return \Illuminate\Http\Response
     */
    public function edit(LeaveDetail $leave_detail)
    {
        return view('admin.leave.show', compact('leave_detail'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LeaveDetail  $leave_detail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LeaveDetail $leave_detail)
    {
        $user_id = Auth::id();
        $username = Auth::user()->name;

        $leave_detail->annual_e = $request->get('annual_e');
        $leave_detail->carry_over = $request->get('carry_over');
        $leave_detail->total_leaves = $request->get('total_leaves');
        $leave_detail->taken_so_far = $request->get('taken_so_far');
        $leave_detail->balance_leaves = $request->get('balance_leaves');
        $leave_detail->replacement_leaves = $request->get('replacement_leaves');
        $leave_detail->special_leaves = $request->get('special_leaves');
        $leave_detail->save();

        $staf_name = $leave_detail->user->name;
        $now = Carbon::now();

        $activity_log = new ActivityLog();
        $activity_log->user_id = $user_id;
        $activity_log->description = "$username updated $staf_name's leave detail at $now.";
        $activity_log->save();

        return redirect()->route('leave_management.edit', compact('leave_detail'))->with('success', 'Leave Detail Updated!');
    }

}
