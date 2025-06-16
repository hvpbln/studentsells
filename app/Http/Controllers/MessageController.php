<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Models\Item;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $authId = auth()->id();

        $conversations = Message::where(function ($query) use ($authId) {
                $query->where('sender_id', $authId)
                      ->orWhere('receiver_id', $authId);
            })
            ->with(['sender', 'receiver'])
            ->orderBy('created_at')
            ->get()
            ->groupBy(function ($message) use ($authId) {
                return $message->sender_id === $authId ? $message->receiver_id : $message->sender_id;
            });

        if ($request->has('search')) {
            $search = strtolower($request->input('search'));
            $filteredUsers = User::where('id', '!=', $authId)
                ->where('role', 'student')
                ->where('status', '!=', 'pending')
                ->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"])
                ->paginate(3);
        } else {
            $filteredUsers = User::where('id', '!=', $authId)
                ->where('role', 'student')
                ->where('status', '!=', 'pending')
                ->paginate(3);
        }

        return view('messages.index', compact('conversations', 'filteredUsers'));
    }

    public function show(Request $request, $userId)
    {
        $authId = Auth::id();
        $receiver = User::findOrFail($userId);

        $messages = Message::where(function ($q) use ($authId, $userId) {
            $q->where('sender_id', $authId)->where('receiver_id', $userId);
        })->orWhere(function ($q) use ($authId, $userId) {
            $q->where('sender_id', $userId)->where('receiver_id', $authId);
        })
        ->with(['sender', 'receiver'])
        ->orderBy('created_at')
        ->get();

        Message::where('sender_id', $userId)
            ->where('receiver_id', $authId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $item = null;
        $wishlist = null;
        $showPreview = false;

        if ($request->has('item_id')) {
            $item = Item::find($request->item_id);
            if ($item) {
                $showPreview = true;
            }
        }

        if ($request->has('wishlist_id')) {
            $wishlist = Wishlist::find($request->wishlist_id);
            if ($wishlist) {
                $showPreview = true;
            }
        }

        return view('messages.show', compact('messages', 'receiver', 'item', 'wishlist', 'showPreview'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message_text' => 'nullable|string',
            'item_id' => 'nullable|exists:items,id',
            'wishlist_id' => 'nullable|exists:wishlists,id',
        ]);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message_text' => $request->message_text,
            'item_id' => $request->item_id,
            'wishlist_id' => $request->wishlist_id,
        ]);

        return back()->with('success', 'Message sent.');
    }
}