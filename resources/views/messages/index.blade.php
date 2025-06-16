@extends('layouts.layout')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Shrikhand&family=Great+Vibes&display=swap');
    
    body {
        font-family: 'Montserrat', sans-serif;
        color: #1f2937;
    }

    .inbox-container {
        max-width: 800px;
        margin: 4rem auto;
        padding: 1rem;
    }

    .inbox-header-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .inbox-header {
        font-size: 2.5rem;
        font-weight: 500;
    }

    .inbox-search-form {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .inbox-search-form input {
        width: 220px;
        padding: 0.5rem 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 8px;
    }

    .inbox-search-form button {
        background-color: #dbf4a7;
        color: #838ab6;
        border: none;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-weight: 600;
        cursor: pointer;
    }

    .inbox-search-form button:hover {
        background-color: #95c235;
        color: #e5e5e9;
    }

    .search-results {
        position: relative;
        background-color: #f3f4f6;
        border: 1px solid #d1d5db;
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 2rem;
    }

    .search-results button {
        position: absolute;
        top: 0.75rem;
        right: 1rem;
        font-size: 1.25rem;
        font-weight: bold;
        color: #ef4444;
        background: none;
        border: none;
        cursor: pointer;
    }

    .inbox-thread a {
        display: block;
        text-decoration: none;
        color: inherit;
    }

    .inbox-item {
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        padding: 1rem;
        background-color: white;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        transition: background-color 0.2s ease;
        margin-top: 1rem;
    }

    .inbox-item:hover {
        background-color: #f3f4f6;
    }

    .inbox-item.unread-message {
        background-color: #fefce8;
        font-weight: bold;
    }

    .profile-photo {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        object-fit: cover;
    }

    .message-info {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .message-info .name-row {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 600;
    }

    .message-info .preview-text {
        margin-top: 0.25rem;
        font-size: 0.95rem;
        color: #4b5563;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    .timestamp {
        font-size: 0.85rem;
        color: #9ca3af;
        white-space: nowrap;
    }
</style>

<div class="inbox-container">
    <div class="inbox-header-bar">
        <h3 class="inbox-header">Inbox</h3>

        <form method="GET" action="{{ route('messages.index') }}" class="inbox-search-form">
            <input type="text" name="search" placeholder="Search users..." value="{{ request('search') }}">
            <button type="submit">Search</button>
        </form>
    </div>

    @if(request('search'))
        <div id="searchResults" class="search-results">
            <button onclick="window.location.href='{{ route('messages.index') }}'">&times;</button>
            <h3 class="text-md font-semibold mb-3">Search Results</h3>
            @if($filteredUsers->isEmpty())
                <p>No users found.</p>
            @else
                <div class="space-y-3 inbox-thread">
                    @foreach($filteredUsers as $user)
                        <a href="{{ route('messages.show', $user->id) }}" class="inbox-item">
                            <img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : asset('storage/profile_photos/placeholder_pfp.jpg') }}" class="profile-photo" alt="PFP">
                            <div class="message-info">
                                <div class="name-row">
                                    {{ $user->name }}
                                    @if ($user->status === 'banned')
                                        <span class="text-sm text-red-600">(Banned)</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    @endif

    <div class="space-y-3 inbox-thread">
        @forelse(collect($conversations)->sortByDesc(fn($messages) => $messages->last()->created_at) as $userId => $messages)
            @php
                $lastMessage = $messages->last();
                $receiver = $lastMessage->sender_id == auth()->id() ? $lastMessage->receiver : $lastMessage->sender;
                $isBanned = $receiver->status === 'banned';
                $isOwnMessage = $lastMessage->sender_id === auth()->id();
                $hasUnread = $messages->where('sender_id', $receiver->id)->where('is_read', false)->count() > 0;
                $profilePhoto = $receiver->profile_photo ? asset('storage/' . $receiver->profile_photo) : asset('storage/profile_photos/placeholder_pfp.jpg');
            @endphp

            <a href="{{ route('messages.show', $receiver->id) }}">
                <div class="inbox-item {{ $hasUnread ? 'unread-message' : '' }}">
                    <img src="{{ $profilePhoto }}" class="profile-photo" alt="PFP">
                    <div class="message-info">
                        <div class="name-row">
                            {{ $receiver->name }}
                            @if ($isBanned)
                                <span class="text-sm text-red-600">(Banned)</span>
                            @endif
                            @if ($hasUnread)
                                <span class="text-sm text-red-600" style="line-height: 1;">
                                    <span style="display:inline-block; transform: scale(0.75); transform-origin: center;">🔴</span>
                                </span>
                            @endif
                        </div>
                        <div class="preview-text">
                            @if ($isOwnMessage)
                                <strong>You:</strong> {{ Str::limit($lastMessage->message_text, 60) }}
                            @else
                                {{ Str::limit($lastMessage->message_text, 60) }}
                            @endif
                        </div>
                    </div>
                        <div class="timestamp text-end">
                            @if ($lastMessage->created_at->gt(\Carbon\Carbon::now()->subDay()))
                                {{ $lastMessage->created_at->diffForHumans() }}
                            @else
                                {{ $lastMessage->created_at->format('F j') }}
                            @endif
                        </div>
                </div>
            </a>
        @empty
            <p class="text-center text-gray-500">No messages found.</p>
        @endforelse
    </div>
</div>
@endsection
