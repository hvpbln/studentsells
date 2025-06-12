<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    /**
     * Store or update a rating for a user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
public function store(Request $request, User $user)
    {
        if (Auth::id() === $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot rate yourself.'
            ], 403);
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        Rating::updateOrCreate(
            ['rater_id' => Auth::id(), 'ratee_id' => $user->id],
            ['rating' => $validated['rating']]
        );

        return response()->json([
            'success' => true,
            'message' => 'Your rating has been submitted successfully.'
        ]);
    }
}
