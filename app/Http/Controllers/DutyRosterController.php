<?php

namespace App\Http\Controllers;

use App\Models\DutyRoster;
use Illuminate\Http\Request;

class DutyRosterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dutyRoster = DutyRoster::all();
        return view ('dutyRoster.viewDuty',compact('dutyRoster'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $duty_rosters = new Duty();
        Duty::orderby('id')->get();
        $duty_rosters->user_id = $request->user_id;
        $duty_rosters->week = $request->week;
        $duty_rosters->duty_date = $request->date;
        $duty_rosters->duty_start_time = $request->start_time;
        $duty_rosters->duty_end_time = $request->end_time ;
        $duty_rosters->duty_created_date = $request->created_date;
        $duty_rosters->duty_updated_date = $request->updated_date ;


        $duty_rosters->save();
        return redirect()->route('DutyRoster')->with('success', 'Duty added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(DutyRoster $dutyRoster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DutyRoster $duty_rosters)
    {
        //
        $duty_rosters = DutyRoster::find($id);
        return view('DutyRoster.updateDuty', compact('duty_rosters'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DutyRoster $duty_rosters)
    {
        //

        $duty_rosters = DutyRoster::find($request->id);

        $duty_rosters->user_id = $request->user_id;
        $duty_rosters->week = $request->week;
        $duty_rosters->duty_date = $request->date;
        $duty_rosters->duty_start_time = $request->start_time;
        $duty_rosters->duty_end_time = $request->end_time ;



        $duty_rosters->save();
        return redirect()->route('DutyRoster')->with('success', 'Duty updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DutyRoster $dutyRoster)
    {
        //
        $duty_rosters = DutyRoster::find($id);
        $duty_rosters->delete();
        return redirect()->route('DutyRoster')->with('success', 'Duty deleted successfully');
    }
}
