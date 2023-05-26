<?php

namespace App\Http\Controllers;

use App\Models\announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        // $announcements = Announcement::all();
        // return view ('announcements.viewAnnouncement')->with('announcements', $announcements);
        $announcements = Announcement::all();
        return view('announcements.viewAnnouncement')->with('announcements', $announcements);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('announcements.addAnnouncement');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $announcement = new Announcement();
        // Announcement::orderby('id')->get();
        // $announcement->product_id = $request->product_id;
        // $announcement->product_name = $request->name;
        // $announcement->save();
        // return redirect()->route('announcement')->with('success', 'Announcement added successfully');
        $request->validate([
            'title' => 'required',
            'desc' => 'required',
        ]);

        $announcement = new Announcement();
        $announcement->title = $request->title;
        $announcement->description = $request->desc;
        $announcement->user_id = auth()->id(); // Set the 'user id' to the currently authenticated user's id
        $announcement->save();

        return redirect()->route('announcement')->with('success', 'Announcement added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(announcement $announcement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $announcement = Announcement::find($id);
        return view('announcements.updateAnnouncement', compact('announcement'));
    }

    /**
     * Update the specified resource in storage.
     */

    // public function update(Request $request, announcement $announcement)
    // {
    //     $announcement = Announcement::find($request->id);
    //     $announcement->id = $request->id;
    //     $announcement->title = $request->title;
    //     $announcement->description = $request->description;
    //     $announcement->save();
    //     return redirect()->route('announcement')->with('success', 'Announcement updated successfully');
    // }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'desc' => 'required',
        ]);

        $announcement = Announcement::find($id);
        $announcement->title = $request->title;
        $announcement->description = $request->desc;
        $announcement->save();

        return redirect()->route('announcement')->with('success', 'Announcement updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $announcement = Announcement::find($id);
        $announcement->delete();
        return redirect()->route('announcement')->with('success', 'Announcement deleted successfully');
    }
}
