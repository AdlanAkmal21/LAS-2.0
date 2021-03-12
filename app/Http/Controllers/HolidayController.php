<?php

namespace App\Http\Controllers;

use App\Http\Requests\HolidayPostRequest;
use App\Models\Holiday;
use Illuminate\Http\Request;

class HolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $holidays       = Holiday::paginate(10);

        return view('holiday.holiday_list', compact('holidays'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('holiday.holiday_add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\HolidayPostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HolidayPostRequest $request)
    {
        $holiday                = new Holiday();
        $holiday->holiday_name  = $request->get('holiday_name');
        $holiday->holiday_date  = $request->get('holiday_date');
        $holiday->save();

        return redirect()->route('holiday.create')->with('success' , 'Holiday added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function show(Holiday $holiday)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function edit(Holiday $holiday)
    {
        return view('holiday.holiday_edit' , compact('holiday'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\HolidayPostRequest  $request
     * @param  \App\Models\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function update(HolidayPostRequest $request, Holiday $holiday)
    {
        $holiday->holiday_name  = $request->get('holiday_name');
        $holiday->holiday_date  = $request->get('holiday_date');
        $holiday->save();

        return redirect()->route('holiday.index')->with('success', 'Holiday Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function destroy(Holiday $holiday)
    {
        $holiday->delete();

        return redirect()->route('holiday.index')->with('error', 'Holiday Deleted.');
    }

}
