@extends('layouts.layout')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Shrikhand&family=Great+Vibes&display=swap');

    html, body {
        margin: 0;
        padding: 0;
        height: 100%;
        font-family: 'Montserrat', sans-serif;
        color: #1f2937;
    }

    .chat-wrapper {
        width: 100%;
        max-width: 800px;
        height: 83vh;
        margin: 1rem auto 2rem auto;
        display: flex;
        flex-direction: column;
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        padding: 1rem;
        box-sizing: border-box;
        overflow: hidden;
    }

    .user-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .user-header-photo {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        object-fit: cover;
    }

    .user-header-name {
        font-size: 1rem;
        font-weight: 600;
    }

    .view-profile-button {
        font-size: 0.75rem;
        color: #6c6c6c;
        border: 1px solid #bbbbbb;
        padding: 4px 8px;
        border-radius: 6px;
        text-decoration: none;
    }

    .view-profile-button:hover {
        background-color: #eff6ff;
    }

    #chat-history {
        flex: 1;
        overflow-y: auto;
        padding: 0.5rem;
        display: flex;
        flex-direction: column;
        gap: 0 rem;
    }

    #chat-history::-webkit-scrollbar {
        display: none;
    }

    .chat-bubble-wrapper {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        max-width: 100%;
    }

    .justify-end .chat-bubble-wrapper {
        align-items: flex-end;
    }

    .chat-bubble {
        display: inline-block;
        max-width: 100%;
        padding: 0.75rem 1rem;
        border-radius: 16px;
        font-size: 0.875rem;
        line-height: 1.4;
        word-break: break-word;
        background-color: #f3f4f6;
        position: relative;
    }

    .chat-bubble.you {
        background-color: #b8cbf3;
        color: #1e3a8a;
    }

    .timestamp {
        font-size: 0.75rem;
        color: #96a9d0;
        margin-top: 0.25rem;
        opacity: 0;
        transition: opacity 0.2s ease-in-out;
    }

    .chat-bubble:hover + .timestamp {
        opacity: 1;
    }

    .chat-input-container {
        display: flex;
        gap: 0.5rem;
        border-top: 1px solid #e5e7eb;
        padding-top: 0.75rem;
        margin-top: 0.75rem;
    }

    .chat-textarea {
        flex: 1;
        padding: 0.5rem 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 0.875rem;
        resize: none;
        min-height: 2.5rem;
        max-height: 8rem;
        outline: none;
    }

    .chat-textarea:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .chat-send-button {
        background-color: #dbf4a7;
        color: #838ab6;
        border: none;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        cursor: pointer;
    }

    .chat-send-button:hover {
        background-color: #95c235;
        color: #e5e5e9;
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

<div class="chat-wrapper container max-w-3xl">

    <div class="user-header">
        <img src="{{ $receiver->profile_photo ? asset('storage/' . $receiver->profile_photo) : asset('storage/profile_photos/placeholder_pfp.jpg') }}" class="user-header-photo" alt="PFP">
        <div class="user-header-info">
            <span class="user-header-name">{{ $receiver->name }}</span>
            <a href="{{ route('users.show', $receiver->id) }}" class="view-profile-button">View Profile</a>
        </div>
    </div>

    <hr style="border-top: 1px solid #000000; margin: 0.5rem 0;">

    <div id="chat-history">

    @if ($showPreview && $item)
        <div style="background-color: #fffce0; border-left: 4px solid #facc15; padding: 0.75rem 1rem; margin-bottom: 1rem; border-radius: 8px; font-size: 0.875rem;">
            🛈 You started a conversation about the item: <strong>"{{ $item->title }}"</strong>
        </div>
    @endif

    @if ($showPreview && $wishlist)
        <div style="background-color: #fffce0; border-left: 4px solid #facc15; padding: 0.75rem 1rem; margin-bottom: 1rem; border-radius: 8px; font-size: 0.875rem;">
            🛈 You started a conversation about the wishlist: <strong>"{{ $wishlist->title }}"</strong>
        </div>
    @endif

        @foreach ($messages as $message)
            @php $isSender = $message->sender_id === auth()->id(); @endphp
            <div class="flex {{ $isSender ? 'justify-end' : 'justify-start' }}">
                <div class="chat-bubble-wrapper">
                    <div class="chat-bubble {{ $isSender ? 'you' : '' }}">
                        <strong>{{ $isSender ? 'You' : $message->sender->name }}:</strong> {{ $message->message_text }}
                    </div>
                    <div class="timestamp">{{ $message->created_at->format('m/d/y H:i') }}</div>
                </div>
            </div>
        @endforeach
    </div>

    @if ($receiver->status === 'banned')
        <div style="text-align: center; font-style: italic;">
            ⚠️ <strong>This user has been banned.</strong> You can no longer send messages to them.
        </div>
    @else
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
    @endif

</div>
@endsection
