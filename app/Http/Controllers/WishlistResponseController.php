<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\WishlistResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class WishlistResponseController extends Controller
{
    public function create(Wishlist $wishlist)
    {
        return view('wishlists.responses.create', compact('wishlist'));
    }

    public function store(Request $request, Wishlist $wishlist)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
            'offer_price' => 'nullable|numeric|min:0',
        ]);

        $response = $wishlist->responses()->create([
            'user_id' => Auth::id(),
            'message' => $validated['message'],
            'offer_price' => $validated['offer_price'] ?? null,
        ]);

        if (Auth::id() !== $wishlist->user_id) {
            Notification::create([
                'user_id' => $wishlist->user_id,
                'type' => 'wishlist_response',
                'reference_id' => $response->id,
                'message' => Auth::user()->name . ' replied to your wishlist: "' . $wishlist->title . '"',
            ]);
        }

        return redirect()->route('wishlists.show', $wishlist->id)->with('success', 'Response sent!');
    }
}