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
}
