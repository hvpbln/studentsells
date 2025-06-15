<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\ListingResponse;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class ListingResponseController extends Controller
{
    public function create(Item $item)
    {
        return view('items.respond', compact('item'));
    }

    public function store(Request $request, Item $item)
    {
        $request->validate([
            'message' => 'required|string',
            'offer_price' => 'nullable|numeric|min:0'
        ]);

        $response = ListingResponse::create([
            'item_id' => $item->id,
            'user_id' => auth()->id(),
            'message' => $request->message,
            'offer_price' => $request->offer_price,
        ]);

        if (Auth::id() !== $item->user_id) {
            Notification::create([
                'user_id' => $item->user_id,
                'type' => 'item_response',
                'reference_id' => $response->id,
                'message' => Auth::user()->name . ' replied to your listing: "' . $item->title . '"',
            ]);
        }

        return redirect()->route('items.show', $item->id)->with('success', 'Response sent!');
    }
}
