<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $pendingUsers = User::all();
        
        return view('admin.dashboard', compact('pendingUsers'));
    }

    public function manageUsers()
    {
        $users = User::all();
        return view('admin.manageUsers', compact('users'));
    }

    public function showPendingUsers()
    {
        $pendingUsers = User::where('status', 'pending')->get();
        return view('admin.users', compact('pendingUsers'));
    }

    public function updateUserStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,active,banned',
        ]);

        $user = User::findOrFail($id);
        $user->status = $request->status;
        $user->save();

        return redirect()->route('admin.manageUsers')->with('success', 'User status updated successfully.');
    }
}