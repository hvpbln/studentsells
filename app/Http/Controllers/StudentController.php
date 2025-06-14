<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function dashboard()
    {
        return view('student.dashboard');
    }

    public function profile()
    {
        $user = User::with(['items.images', 'wishlists.images'])->find(Auth::id());

        if (!$user->profile_photo || !Storage::disk('public')->exists($user->profile_photo)) {
            $user->profile_photo = 'profile_photos/placeholder_pfp.jpg';
        }

        return view('student.profile', compact('user'));
    }
}
