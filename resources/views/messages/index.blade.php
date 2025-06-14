@extends('layouts.layout')

@section('content')
<style>
    .inbox-profile-photo {
        width: 64px;
        height: 64px;
        object-fit: cover;
        border-radius: 9999px;
        margin-top: 4px;
    }

    .inbox-message-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 1.25rem;
        border: 1px solid #d1d5db;
        border-radius: 0.75rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        background-color: white;
    }

    .inbox-message-info {
        display: flex;
        gap: 1rem;
        align-items: flex-start;
    }

    .text-content {
        margin-top: 0.25rem;
        font-size: 1.125rem;
        color: #4b5563;
    }

    .inbox-message-timestamp {
        font-size: 1rem;
        color: #9ca3af;
        white-space: nowrap;
        margin-top: 0.25rem;
    }

    .inbox-thread a {
        color: inherit;
        text-decoration: none;
    }

    .inbox-thread a:hover {
        background-color: #f3f4f6;
    }

</style>


<div class="container py-4">
    <h2 class="text-xl font-bold mb-4">Inbox</h2>

    <form method="GET" action="{{ route('messages.index') }}" class="mb-6 flex space-x-2">
        <input type="text" name="search" placeholder="Search users..." value="{{ request('search') }}"
            class="border px-4 py-2 rounded w-full">
        <button type="submit" class="bg-blue-600 px-3 py-2 rounded">Search</button>
    </form>

    @if(request('search'))
        <div id="searchResults" class="border border-gray-400 rounded p-4 bg-gray-50 mb-6 relative">
            <button onclick="window.location.href='{{ route('messages.index') }}'"
                class="absolute top-2 right-2 text-red-600 hover:text-red-800 font-bold text-xl">&times;</button>

            <h3 class="text-md font-semibold mb-3">Search Results</h3>

            @if($filteredUsers->count() === 0)
                <p>No users found.</p>
            @else
                <div class="space-y-3 inbox-thread">
                    @foreach($filteredUsers as $user)
                        <a href="{{ route('messages.show', $user->id) }}" class="block rounded-lg transition hover:bg-gray-100">
                            <div class="p-4 border border-gray-300 rounded shadow bg-white flex items-center space-x-4">
                                <img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : asset('storage/profile_photos/placeholder_pfp.jpg') }}" class="inbox-profile-photo" alt="PFP">
                                <div class="flex flex-col">
                                    <span class="font-semibold text-gray-800">{{ $user->name }}</span>
                                    @if ($user->status === 'banned')
                                        <span class="text-sm font-semibold text-red-600">(Banned)</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    @endif

    <div class="space-y-4 inbox-thread">
        @forelse(collect($conversations)->sortByDesc(fn($messages) => $messages->last()->created_at) as $userId => $messages)
            @php
                $lastMessage = $messages->last();
                $receiver = $lastMessage->sender_id == auth()->id() ? $lastMessage->receiver : $lastMessage->sender;
                $isBanned = $receiver->status === 'banned';
                $isOwnMessage = $lastMessage->sender_id === auth()->id();
                $profilePhoto = $receiver->profile_photo ? asset('storage/' . $receiver->profile_photo) : asset('storage/profile_photos/placeholder_pfp.jpg');
            @endphp

            <a href="{{ route('messages.show', $receiver->id) }}" class="block rounded-lg transition">
                <div class="inbox-message-row">
                    <div class="inbox-message-info">
                        <img src="{{ $receiver->profile_photo ? asset('storage/' . $receiver->profile_photo) : asset('storage/profile_photos/placeholder_pfp.jpg') }}" class="inbox-profile-photo" alt="PFP">
                        <div>
                            <div class="flex items-center space-x-2 font-semibold">
                                {{ $receiver->name }}
                                @if ($isBanned)
                                    <span class="text-sm font-semibold text-red-600">(Banned)</span>
                                @endif
                            </div>
                            <div class="text-content">
                                @if ($isOwnMessage)
                                    <strong>You:</strong> {{ Str::limit($lastMessage->message_text, 50) }}
                                @else
                                    {{ Str::limit($lastMessage->message_text, 50) }}
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="inbox-message-timestamp">
                        {{ $lastMessage->created_at->format('m/d/y H:i') }}
                    </div>
                </div>
            </a>
        @empty
            <p>No messages found.</p>
        @endforelse
    </div>
</div>
@endsection
