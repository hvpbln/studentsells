<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class StudentController extends Controller
{
    public function dashboard()
    {
        return view('student.dashboard');
    }

    public function profile()
    {
        $user = User::with(['items.images', 'wishlists.images'])->find(Auth::id());
        return view('student.profile', compact('user'));
    }
}
