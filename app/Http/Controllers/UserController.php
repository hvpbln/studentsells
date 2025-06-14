<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Rating;

use Illuminate\Http\Request;

class UserController extends Controller
{
        public function show(User $user)
    {
        $user->load(['items.images', 'wishlists.images']);
        return view('users.show', compact('user'));
        
    }

        public function updatePhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = auth()->user();

        if ($request->hasFile('profile_photo')) {
            $filename = $request->file('profile_photo')->store('profile_photos', 'public');
            $user->profile_photo = $filename;
        } else {
            $user->profile_photo = null;
        }

        $user->save();

        return back()->with('success', 'Profile photo updated!');
    }
}
