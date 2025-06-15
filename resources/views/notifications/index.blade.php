@extends('layouts.layout')

@section('content')
<style>
    .notifications-container {
        max-width: 800px;
        margin: 4rem auto;
        padding: 1rem;
    }

    .notification-header-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .notification-header {
        font-size: 2.5rem;
        font-weight: 500;
    }

    .notification-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background-color: white;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 1rem;
        text-decoration: none;
        color: inherit;
        transition: background-color 0.2s ease;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .notification-item:hover {
        background-color: #f3f4f6;
    }

    .unread-message {
        background-color: #fefce8;
        font-weight: bold;
    }

    .profile-photo {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 1rem;
    }

    .notification-info {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .message-text {
        font-size: 0.95rem;
    }

    .timestamp {
        font-size: 0.85rem;
        color: #9ca3af;
        white-space: nowrap;
        margin-left: 1rem;
    }
</style>

<div class="notifications-container">
    <div class="notification-header-bar">
        <h3 class="notification-header">Notifications</h3>
        <form method="POST" action="{{ route('notifications.markAsRead') }}">
            @csrf
            <button type="submit" class="btn btn-primary">Mark All as Read</button>
        </form>
    </div>

    @if ($notifications->isEmpty())
        <p class="text-center text-muted">No notifications yet.</p>
    @else
        @foreach ($notifications as $notification)
            @php
                $link = '#';
                $photo = asset('storage/profile_photos/placeholder_pfp.jpg');
                $username = '';
                $userMessage = '';
                $title = '';
                $description = '';
                $isUnread = !$notification->is_read;

                if ($notification->type === 'item_response') {
                    $response = \App\Models\ListingResponse::find($notification->reference_id);
                    if ($response && $response->item && $response->user) {
                        $link = route('items.show', $response->item_id) . '#response-' . $response->id;
                        $username = $response->user->name;
                        $userMessage = $response->message;
                        $title = $response->item->title . ' | ₱' . number_format($response->item->price, 2);
                        $description = $response->item->description;
                        $photo = $response->user->profile_photo ? asset('storage/' . $response->user->profile_photo) : $photo;
                    }
                } elseif ($notification->type === 'wishlist_response') {
                    $response = \App\Models\WishlistResponse::find($notification->reference_id);
                    if ($response && $response->wishlist && $response->user) {
                        $link = route('wishlists.show', $response->wishlist_id) . '#response-' . $response->id;
                        $username = $response->user->name;
                        $userMessage = $response->message;
                        $priceRange = '₱' . number_format($response->wishlist->price_range_min, 2) . ' - ₱' . number_format($response->wishlist->price_range_max, 2);
                        $title = $response->wishlist->title . ' | ' . $priceRange;
                        $description = $response->wishlist->description;
                        $photo = $response->user->profile_photo ? asset('storage/' . $response->user->profile_photo) : $photo;
                    }
                } elseif ($notification->type === 'message') {
                    $link = route('messages.show', $notification->reference_id);
                    $userMessage = $notification->message;
                }
            @endphp

            <a href="{{ route('notifications.redirect', $notification->id) }}" class="notification-item {{ $isUnread ? 'unread-message' : '' }}" style="position: relative;">
                <img src="{{ $photo }}" class="profile-photo" alt="PFP">
                
                <div class="notification-info">
                    <div class="message-text">
                        @if ($notification->type === 'message')
                            {!! $userMessage !!}
                        @elseif ($notification->type === 'item_response' || $notification->type === 'wishlist_response')
                            <strong>{{ $username }}</strong> replied
                            <em>"{{ Str::limit($userMessage, 80) }}"</em>
                            to your {{ $notification->type === 'item_response' ? 'listing' : 'wishlist' }}.

                            <div style="margin-top: 6px; padding: 10px 12px; background-color: #f9fafb; border-left: 4px solid #cbd5e0; border-radius: 6px;">
                                <div style="font-weight: 600;">{{ $title }}</div>
                                <div style="font-weight: 400; color: #4b5563;">{{ Str::limit($description, 150) }}</div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="timestamp text-end">
                    @if ($notification->created_at->gt(\Carbon\Carbon::now()->subDay()))
                        {{ $notification->created_at->diffForHumans() }}
                    @else
                        {{ $notification->created_at->format('F j') }}
                    @endif
                </div>

                @if ($isUnread)
                    <span style="position: absolute; top: 10px; right: 12px; font-size: 1.25rem; color: red;">🔴</span>
                @endif
            </a>
        @endforeach
    @endif
</div>
@endsection