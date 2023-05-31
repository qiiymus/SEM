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
        return view('dutyRoster.addDuty');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $dutyRoster = new DutyRoster();
        DutyRoster::orderby('id')->get();
        $dutyRoster->user_id = $request->user_id;
        $dutyRoster->user_name = $request->user_name;
        $dutyRoster->week = $request->week;
        $dutyRoster->date = $request->date;
        $dutyRoster->status = $request->status;
        $dutyRoster->start_time = $request->start_time;
        $dutyRoster->end_time = $request->end_time ;
        // $dutyRoster->created_at = $request->created_at;
        // $dutyRoster->updated_at = $request->updated_at;


        $dutyRoster->save();
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
    public function edit($id)
    {
        //
        $duty_rosters = DutyRoster::find($id);
        return view('DutyRoster.updateDuty', compact('duty_rosters'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DutyRoster $dutyRoster)
    {
        //

        $dutyRoster = DutyRoster::find($request->id);

        $dutyRoster->user_id = $request->user_id;
        $dutyRoster->user_name = $request->user_name;
        $dutyRoster->week = $request->week;
        $dutyRoster->date = $request->date;
        $dutyRoster->status = $request->status;
        $dutyRoster->start_time = $request->start_time;
        $dutyRoster->end_time = $request->end_time ;
        // $dutyRoster->created_at = $request->created_at;
        // $dutyRoster->updated_at = $request->updated_at ;


        $dutyRoster->save();
        return redirect()->route('DutyRoster')->with('success', 'Duty updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $duty_rosters = DutyRoster::find($id);
        $duty_rosters->delete();
        return redirect()->route('DutyRoster')->with('success', 'Duty deleted successfully');
    }
}
