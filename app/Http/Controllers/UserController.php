<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // show all users
        $users = User::all();
        return view('user.viewUser', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // create new user
        return view('user.addUser');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate if user already exists
        $user = User::where('matric_id', $request->matric)->first();
        if ($user) {
            return redirect()->back()->with('error', 'User already exists');
        }
        // validate if password same as confirm password
        if ($request->password != $request->confirmpass) {
            return redirect()->back()->with('error', 'Password does not match');
        }
        // validate if phone number is 9 to 11 digits long
        if (!is_numeric($request->phone)) {
            return redirect()->back()->with('error', 'Phone number must be numeric');
        }
        if (strlen($request->phone) < 9 || strlen($request->phone) > 11) {
            return redirect()->back()->with('error', 'Phone number must be 9 to 11 digits long');
        }

        // store new user
        $user = new User();
        $user->name = $request->name;
        $user->matric_id = $request->matric;
        $user->email = $request->email;
        $user->phone_num = $request->phone;
        $user->role = $request->role;
        $user->password = bcrypt($request->password);
        if ($user->save()) {
            return redirect()->route('user')->with('success', 'User added successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to add user');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $id = $request->id;
        // edit user
        $user = User::find($id);
        return view('user.editUser', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $user = User::find($id);
        // validate if password same as database
        if (!password_verify($request->oldpass, $user->password)) {
            return redirect()->back()->with('error', 'Wrong password. Please re-enter current current password.');
        }
        // validate if password same as confirm password
        if ($request->password != $request->confirmpass) {
            return redirect()->back()->with('error', 'Password does not match');
        }
        // validate if phone number is 9 to 11 digits long
        if (!is_numeric($request->phone)) {
            return redirect()->back()->with('error', 'Phone number must be numeric');
        }
        if (strlen($request->phone) < 9 || strlen($request->phone) > 11) {
            return redirect()->back()->with('error', 'Phone number must be 9 to 11 digits long');
        }
        // update user
        $user->name = $request->name;
        $user->matric_id = $request->matric;
        $user->email = $request->email;
        $user->phone_num = $request->phone;
        $user->role = $request->role;
        $user->password = bcrypt($request->password);
        if ($user->save()) {
            if ($id == auth()->user()->id) {
                Auth::logout();
                session()->flush();
                return redirect('/login');
            }
            return redirect()->route('user')->with('success', 'User updated successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to update user');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        // delete user
        $user = User::find($id);

        // if the current user is deleting his/her own account, logout and delete account
        if ($id == auth()->user()->id) {
            $user->delete();
            Auth::logout();
            session()->flush();
            return redirect('/login')->with('status', 'User deleted successfully');
        }

        if ($user->delete()) {
            return redirect()->route('user')->with('success', 'User deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to delete user');
        }
    }
}
