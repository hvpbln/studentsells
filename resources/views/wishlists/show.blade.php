@extends('layouts.layout')

@section('content')
<style>
    body {
        background-color: #d9dbf0;
    }

    .container-custom {
        max-width: 700px;
        margin: 0 auto;
        padding: 30px 20px;
    }

    .section-title {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 1.5rem;
        color: #2f2f2f;
    }

    .wishlist-container,
    .response-card {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 16px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        margin-bottom: 20px;
    }

    .profile-photo {
        width: 64px;
        height: 64px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #ccc;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 20px;
    }

    .wishlist-image {
        width: 160px;
        height: 120px;
        object-fit: cover;
        border-radius: 12px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.08);
    }

    .btn-respond {
        background-color: #e6f49c;
        font-weight: 600;
        border-radius: 10px;
        border: none;
        color: #333;
        padding: 8px 16px;
    }

    .btn-back {
        border-radius: 10px;
        border: 1px solid #bbb;
        padding: 8px 16px;
        font-weight: 500;
        color: #444;
    }

    .action-buttons {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }

    .badge-status {
        font-size: 0.9rem;
        padding: 6px 12px;
        border-radius: 12px;
    }

    a {
        text-decoration: none;
        color: black;
    }
</style>

<div class="container-custom">
    <h2 class="section-title">Wishlist</h2>

    <div class="wishlist-container">
        <h3 class="mb-3"><i class="bi bi-star-fill text-warning me-2"></i>{{ $wishlist->title }}</h3>

        <div class="user-info">
            <img src="{{ $wishlist->user->profile_photo ? asset('storage/' . $wishlist->user->profile_photo) : asset('storage/profile_photos/placeholder_pfp.jpg') }}"
                 alt="Profile"
                 class="profile-photo">

            <div>
                <p class="mb-1"><strong>
                    <a href="{{ route('users.show', $wishlist->user_id) }}">
                        {{ $wishlist->user->name ?? 'Unknown' }}
                    </a></strong>
                </p>
                <a href="{{ route('messages.show', ['userId' => $wishlist->user_id, 'wishlist_id' => $wishlist->id]) }}"
                   class="btn btn-sm btn-outline-secondary">Chat</a>
            </div>
        </div>

        <p class="mb-1"><strong>Price Range:</strong>
            @if($wishlist->price_range_min) ₱{{ number_format($wishlist->price_range_min, 2) }} @endif -
            @if($wishlist->price_range_max) ₱{{ number_format($wishlist->price_range_max, 2) }} @endif
        </p>

        <p class="mb-3"><strong>Status:</strong>
            <span class="badge badge-status bg-{{ $wishlist->status == 'open' ? 'success' : 'secondary' }}">
                {{ ucfirst($wishlist->status) }}
            </span>
        </p>

        @if($wishlist->images->count())
            <div class="d-flex flex-wrap gap-2 mb-3">
                @foreach($wishlist->images as $image)
                    <img src="{{ asset('storage/' . $image->image_url) }}" class="wishlist-image" alt="Image">
                @endforeach
            </div>
        @endif
    </div>

    <div class="mb-4">
        <h4 class="mb-3"><i class="bi bi-chat-left-dots me-2"></i>Responses</h4>

        @if($wishlist->responses->count())
            @foreach($wishlist->responses as $response)
                <div class="response-card">
                    <p class="mb-1">
                        <strong><i class="bi bi-person-circle me-1"></i>{{ $response->user->name ?? 'User' }}:</strong>
                        {{ $response->message }}
                    </p>
                    @if($response->offer_price)
                        <p class="mb-1 text-success">
                            <i class="bi bi-currency-dollar me-1"></i>
                            <strong>Offer:</strong> ₱{{ number_format($response->offer_price, 2) }}
                        </p>
                    @endif
                    <small class="text-muted"><i class="bi bi-clock me-1"></i>
                        {{ $response->created_at->format('M d, Y H:i') }}</small>
                </div>
            @endforeach
        @else
            <div class="alert alert-info">
                <i class="bi bi-info-circle me-1"></i> No responses yet.
            </div>
        @endif
    </div>

    <div class="action-buttons">
        <a href="{{ route('wishlists.responses.create', $wishlist->id) }}" class="btn btn-respond">
            <i class="bi bi-reply-fill me-1"></i> Respond
        </a>
        <a href="{{ route('wishlists.index') }}" class="btn btn-back">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>
</div>
@endsection
