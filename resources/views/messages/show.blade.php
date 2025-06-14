@extends('layouts.layout')

@section('content')
<style>
    html, body {
        height: 100%;
        margin: 0;
    }

    body {
        display: flex;
        flex-direction: column;
    }

    .chat-wrapper {
        flex: 1;
        display: flex;
        flex-direction: column;
        max-height: 85vh;
    }

    #chat-history {
        flex: 1;
        overflow-y: auto;
        -ms-overflow-style: none;
        scrollbar-width: none;
        scroll-behavior: instant;
    }

    #chat-history::-webkit-scrollbar {
        display: none;
    }

    .chat-input-container {
        display: flex;
        flex-direction: row;
        align-items: flex-end;
        border: 1px solid #ddd;
        border-radius: 0.5rem;
        padding: 0.5rem;
        background-color: white;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        position: sticky;
        bottom: 0;
        width: 100%;
        gap: 0.5rem;
    }

    .chat-textarea {
        flex-grow: 1;
        width: 100% !important;
        min-height: 2.5rem;
        max-height: 12rem;
        padding: 0.5rem;
        resize: none;
        overflow: hidden;
        border-radius: 0.375rem;
        border: 1px solid #ccc;
        outline: none;
        font-size: 0.875rem;
    }

    .chat-textarea:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.3);
    }

    .chat-send-button {
        padding: 0.5rem 1rem;
        background-color: #2563eb;
        color: white;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        border: none;
        cursor: pointer;
    }

    .chat-send-button:hover {
        background-color: #1e40af;
    }

    .user-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .user-header-photo {
        width: 128px;
        height: 128px;
        object-fit: cover;
        border-radius: 9999px;
    }

    .user-header-info {
        display: flex;
        flex-direction: column;
    }

    .user-header-name {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 0.25rem;
    }

    .view-profile-button {
        display: inline-block;
        font-size: 0.875rem;
        color: #2563eb;
        border: 1px solid #2563eb;
        padding: 4px 12px;
        border-radius: 6px;
        text-decoration: none;
        transition: background-color 0.2s;
    }

    .view-profile-button:hover {
        background-color: #ebf4ff;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const chat = document.getElementById("chat-history");
        if (chat) {
            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    chat.scrollTop = chat.scrollHeight;
                });
            });
        }
    });
</script>

<div class="chat-wrapper container max-w-3xl mx-auto py-4">

    <div class="user-header">
        <img src="{{ $receiver->profile_photo ? asset('storage/' . $receiver->profile_photo) : asset('storage/profile_photos/placeholder_pfp.jpg') }}" class="user-header-photo" alt="PFP">
        <div class="user-header-info">
            <span class="user-header-name">{{ $receiver->name }}</span>
            <a href="{{ route('users.show', $receiver->id) }}" class="view-profile-button">View Profile</a>
        </div>
    </div>

    @if(isset($item) && $showPreview)
        <div class="card mb-4 shadow-sm p-3">
            <div class="d-flex">
                @if($item->images && count($item->images))
                    <img src="{{ asset('storage/' . $item->images[0]->image_url) }}"
                        class="me-3 rounded"
                        style="width: 120px; height: auto; object-fit: cover;">
                @else
                    <div class="me-3 bg-secondary text-white rounded d-flex align-items-center justify-content-center"
                        style="width: 120px; height: 90px; font-size: 0.8rem;">
                        No Image
                    </div>
                @endif

                <div style="font-size: 0.9rem;">
                    <h5 class="mb-1">{{ $item->title }}</h5>
                    <p class="mb-1 text-muted"><i>{{ \Illuminate\Support\Str::limit($item->description, 100) }}</i></p>
                    <p class="mb-0"><strong>Price:</strong> ₱{{ number_format($item->price, 2) }}</p>
                </div>
            </div>
        </div>
    @endif

    @if($showPreview && isset($wishlist))
        <div class="card mb-4 shadow-sm p-3">
            <div class="d-flex">
                @if($wishlist->images->count())
                    <img src="{{ asset('storage/' . $wishlist->images->first()->image_url) }}"
                         class="me-3 rounded"
                         style="width: 120px; height: auto; object-fit: cover;">
                @endif

                <div style="font-size: 0.9rem;">
                    <h5 class="mb-1">{{ $wishlist->title }}</h5>
                    <p class="mb-1"><strong>Price Range:</strong>
                        ₱{{ number_format($wishlist->price_range_min, 2) }}
                        -
                        ₱{{ number_format($wishlist->price_range_max, 2) }}
                    </p>
                    <p class="mb-1 text-muted"><i>{{ \Illuminate\Support\Str::limit($wishlist->description, 100) }}</i></p>
                    <p class="mb-0"><strong>Status:</strong> 
                        <span class="badge bg-{{ $wishlist->status == 'open' ? 'success' : 'secondary' }}">
                            {{ ucfirst($wishlist->status) }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    @endif

    @if($showPreview && $messages->count() && $messages->last()->sender_id === auth()->id() && \Illuminate\Support\Str::startsWith($messages->last()->message_text, '🛈 Started a conversation'))
        <div class="text-xs text-center text-gray-500 italic mb-2">
            {{ $messages->last()->message_text }}
        </div>
    @endif

    <div id="chat-history" class="bg-gray-100 p-4 rounded border h-[60vh] overflow-y-scroll mb-4 space-y-4 scrollbar-hide">
        @foreach ($messages as $message)
            @php $isSender = $message->sender_id === auth()->id(); @endphp
            <div class="flex {{ $isSender ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-[70%] flex {{ $isSender ? 'flex-row-reverse' : 'flex-row' }} items-end space-x-2 space-x-reverse">
                    <div class="bg-white border rounded-lg px-4 py-2 shadow-sm">
                        <p class="text-sm text-gray-900 whitespace-pre-line">
                            <strong>{{ $isSender ? 'You' : $message->sender->name }}:</strong> {{ $message->message_text }}
                        </p>
                        <div class="text-xs text-gray-500 mt-1 text-right">
                            {{ $message->created_at->format('m/d/y H:i') }}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <form action="{{ route('messages.store') }}" method="POST" class="w-full">
        @csrf
        <input type="hidden" name="receiver_id" value="{{ $receiver->id }}">

        <div class="chat-input-container">
            <textarea
                name="message_text"
                required
                placeholder="Type a message..."
                maxlength="500"
                class="chat-textarea"
                oninput="this.style.height='auto'; this.style.height=this.scrollHeight + 'px';"
            ></textarea>
            <button type="submit" class="chat-send-button">
                Send
            </button>
        </div>
    </form>
</div>
@endsection