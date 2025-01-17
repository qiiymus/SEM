<?php

namespace App\Http\Controllers;

use App\Models\announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::all();
        return view('announcements.viewAnnouncement')->with('announcements', $announcements);
    }

    public function announcementList()
    {
        $announcements = Announcement::all();
        return view('announcements.announcementList')->with('announcements', $announcements);
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
    $request->validate([
        'title' => 'required',
        'desc' => 'required',
        'announcement_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $announcement = new Announcement();
    $announcement->title = $request->title;
    $announcement->description = $request->desc;
    $announcement->user_id = auth()->id(); // Set the 'user id' to the currently authenticated user's id

    // Handle the image upload
    if ($request->hasFile('announcement_image')) {
        $imagePath = $request->file('announcement_image')->store('images/announcements', 'public');
        $announcement->announcement_image = $imagePath; // Save the image path to the database
    }

    $announcement->save();

    return redirect()->route('announcement')->with('success', 'Announcement added successfully');
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

     public function update(Request $request, $id)
     {
         $request->validate([
             'title' => 'required',
             'desc' => 'required',
             'announcement_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Add validation for the image field
         ]);
     
         $announcement = Announcement::find($id);
         $announcement->title = $request->title;
         $announcement->description = $request->desc;
     
         // Check if there's a new image and store it
         if ($request->hasFile('announcement_image')) {
             // Delete the old image if it exists
             if ($announcement->announcement_image) {
                 Storage::delete('public/' . $announcement->announcement_image);
             }
     
             // Store the new image
             $imagePath = $request->file('announcement_image')->store('announcements', 'public');
             $announcement->announcement_image = $imagePath;
         }
     
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

    public function show($id)
    {
    $announcement = Announcement::findOrFail($id);
    return view('announcements.showAnnouncement', compact('announcement'));
    }

}
