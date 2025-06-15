<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\ListingResponse;
use App\Models\WishlistResponse;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead(Request $request)
    {
        Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return redirect()->back()->with('success', 'All notifications marked as read.');
    }

    public function showAndMarkAsRead($id)
    {
        $notification = Notification::findOrFail($id);

        if (!$notification->is_read) {
            $notification->is_read = true;
            $notification->save();
        }

        if ($notification->type === 'message') {
            return redirect()->route('messages.show', $notification->reference_id);
        }

        if ($notification->type === 'item_response') {
            $response = ListingResponse::find($notification->reference_id);
            if ($response) {
                $url = route('items.show', $response->item_id) . '#response-' . $response->id;
                return redirect()->to($url);
            }
        }

        if ($notification->type === 'wishlist_response') {
            $response = WishlistResponse::find($notification->reference_id);
            if ($response) {
                $url = route('wishlists.show', $response->wishlist_id) . '#response-' . $response->id;
                return redirect()->to($url);
            }
        }

        return redirect()->back()->with('error', 'Notification target not found.');
    }
}