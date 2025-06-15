<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Rating;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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

    public function editProfile()
{
    $user = auth()->user();
    return view('student.edit_profile', compact('user'));
}
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:6|confirmed',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'remove_profile_photo' => 'nullable|boolean',
        ]);

        $user->name = $validated['name'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        if ($request->has('remove_profile_photo') && $user->profile_photo && $user->profile_photo !== 'profile_photos/placeholder_pfp.jpg') {
            Storage::disk('public')->delete($user->profile_photo);
            $user->profile_photo = null;
        }

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo && $user->profile_photo !== 'profile_photos/placeholder_pfp.jpg') {
                Storage::disk('public')->delete($user->profile_photo);
            }

            $user->profile_photo = $request->file('profile_photo')->store('profile_photos', 'public');
        }

        $user->save();

        return redirect()->route('student.profile.edit')->with('success', 'Profile updated successfully.');
    }
}
