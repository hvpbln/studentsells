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
                    @auth
                        @if(auth()->id() !== $wishlist->user_id)
                            <a href="{{ route('messages.show', ['userId' => $wishlist->user_id, 'wishlist_id' => $wishlist->id]) }}" class="btn btn-sm btn-outline-secondary">Chat</a>
                        @endif
                    @endauth
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
            <div class="wishlist-images mb-2 d-flex flex-wrap gap-2">
                @foreach($wishlist->images as $image)
                    <img src="{{ asset('storage/' . $image->image_url) }}"
                        alt="Image"
                        class="wishlist-image"
                        style="cursor: pointer;"
                        data-bs-toggle="modal"
                        data-bs-target="#wishlistImagePreviewModal"
                        data-image="{{ asset('storage/' . $image->image_url) }}">
                @endforeach
            </div>
        @endif
    </div>

    <div class="mb-4">
        <h4 class="mb-3"><i class="bi bi-chat-left-dots me-2"></i>Responses</h4>

        @if($wishlist->responses->count())
            @foreach($wishlist->responses as $response)
                <div id="response-{{ $response->id }}" class="response-card">
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

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const hash = window.location.hash;
        if (hash && hash.startsWith('#response-')) {
            const el = document.querySelector(hash);
            if (el) {
                el.style.transition = 'background-color 0.1s ease';
                el.style.backgroundColor = '#fcf7c2';
                setTimeout(() => {
                    el.style.backgroundColor = '';
                }, 1500);
            }
        }
    });
</script>

<div class="modal fade" id="wishlistImagePreviewModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content bg-transparent border-0">
      <div class="modal-body text-center">
        <img id="wishlistPreviewImage" src="" alt="Preview" class="img-fluid rounded shadow" style="max-height: 80vh;">
      </div>
    </div>
  </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const previewImage = document.getElementById('wishlistPreviewImage');
        const modal = document.getElementById('wishlistImagePreviewModal');
        document.querySelectorAll('[data-bs-target="#wishlistImagePreviewModal"]').forEach(img => {
            img.addEventListener('click', function () {
                previewImage.src = this.getAttribute('data-image');
            });
        });
        modal.addEventListener('hidden.bs.modal', () => {
            previewImage.src = '';
        });
    });
</script>
@endsection