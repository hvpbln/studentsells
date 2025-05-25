<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\WishlistResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $wishlist->responses()->create([
            'user_id' => Auth::id(),
            'message' => $validated['message'],
            'offer_price' => $validated['offer_price'] ?? null,
        ]);

        return redirect()->route('wishlists.show', $wishlist->id)->with('success', 'Response sent successfully.');
    }
}
