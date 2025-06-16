@extends('layouts.layout')

@section('content')
<style>
    .card {
        background-color: #f9f9f2;
        border: none;
        border-radius: 16px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
        padding: 1rem;
        margin-bottom: 1rem;
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
    }

    .wishlist-images {
        justify-content: center;
    }

    .response-card {
        background-color: #ffffff;
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        padding: 1rem;
        box-shadow: 0 1px 4px rgba(0,0,0,0.03);
    }

    .highlighted {
        background-color: #fcf7c2 !important;
        transition: background-color 0.1s ease;
    }

    .btn-respond {
        background-color: #e5f4c6;
        color: #6c757d;
        border-radius: 10px;
    }

    .btn-respond:hover {
        background-color: rgb(150, 179, 92);
    }

    .btn-secondary {
        border-radius: 10px;
    }

    .btn-chat {
        background-color: #d4edb0;
        color: #2f3e2f;
        border: none;
        border-radius: 10px;
        transition: background-color 0.2s ease;
    }

    .btn-chat:hover {
        background-color: #a5c67a;
        color: #1c2a1c;
    }

    .badge-status {
        padding: 0.4em 0.75em;
        font-size: 0.75rem;
        border-radius: 999px;
        font-weight: 600;
    }

    .bg-success {
        background-color: #b7e4c7 !important;
        color: #2b463c;
    }

    .bg-warning {
        background-color: #fff3cd !important;
        color: #856404;
    }

    .bg-secondary {
        background-color: #d6d6f5 !important;
        color: #3b3f58;
    }
</style>

{{-- Main Wishlist Card --}}
<div class="card mb-4 shadow-sm card-display">
    <div class="card-body">
        {{-- Title and Status --}}
        <div class="d-flex align-items-center gap-2 mb-2">
            <h4 class="fw-bold mb-0">
                <i class="bi bi-star-fill text-warning me-2"></i>{{ $wishlist->title }}
            </h4>
            <span class="badge badge-status
                {{ $wishlist->status === 'open' ? 'bg-success' :
                   ($wishlist->status === 'fulfilled' ? 'bg-warning' : 'bg-secondary') }}">
                {{ ucfirst($wishlist->status) }}
            </span>
        </div>

        {{-- Poster Info --}}
        <div class="d-flex align-items-center mb-3">
            <img src="{{ $wishlist->user->profile_photo ? asset('storage/' . $wishlist->user->profile_photo) : asset('storage/profile_photos/placeholder_pfp.jpg') }}"
                 alt="Profile Photo"
                 class="rounded-circle me-3"
                 style="width: 64px; height: 64px; object-fit: cover;">

            <div>
                <p class="mb-1">
                    <strong>
                        @php
                            $isOwner = auth()->check() && auth()->id() === $wishlist->user_id;
                        @endphp
                        <a href="{{ $isOwner ? route('student.profile') : route('users.show', $wishlist->user_id) }}" class="text-decoration-none text-dark fw-semibold">
                            {{ $wishlist->user->name ?? 'Unknown' }}
                        </a>
                    </strong>
                </p>
                @auth
                    @if(auth()->id() !== $wishlist->user_id)
                        <a href="{{ route('messages.show', ['userId' => $wishlist->user_id, 'wishlist_id' => $wishlist->id]) }}" class="btn btn-sm btn-chat">Chat</a>
                    @endif
                @endauth
            </div>
        </div>

        <p><strong>Price Range:</strong>
            @if($wishlist->price_range_min) ₱{{ number_format($wishlist->price_range_min, 2) }} @endif -
            @if($wishlist->price_range_max) ₱{{ number_format($wishlist->price_range_max, 2) }} @endif
        </p>

        @if($wishlist->description)
            <p class="text-muted">{{ $wishlist->description }}</p>
        @endif

        @if($wishlist->images->count())
            <div class="wishlist-images mb-2 d-flex flex-wrap gap-2">
                @foreach($wishlist->images as $image)
                    <img src="{{ asset('storage/' . $image->image_url) }}"
                        alt="Wishlist Image"
                        class="img-fluid preview-image"
                        data-bs-toggle="modal"
                        data-bs-target="#wishlistImagePreviewModal"
                        data-image="{{ asset('storage/' . $image->image_url) }}"
                        style="width: 300px; height: auto; object-fit: cover; border-radius: 10px; cursor: pointer;">
                @endforeach
            </div>
        @endif

        <a href="{{ route('wishlists.responses.create', $wishlist->id) }}" class="btn btn-respond mt-3">Respond to Wishlist</a>
        <a href="{{ route('wishlists.index') }}" class="btn btn-secondary mt-3">Back to List</a>
    </div>
</div>

{{-- Responses Section --}}
<div class="card">
    <div class="card-body">
        <h3 class="fw-semibold mb-3">Responses</h3>

        @if($wishlist->responses->count())
            @foreach($wishlist->responses as $response)
                <div id="response-{{ $response->id }}" class="response-card mb-3">
                    <div class="d-flex align-items-center mb-2">
                        @php
                            $isResponder = auth()->check() && auth()->id() === $response->user_id;
                        @endphp
                        <a href="{{ $isResponder ? route('student.profile') : route('users.show', $response->user_id) }}">
                            <img src="{{ $response->user->profile_photo ? asset('storage/' . $response->user->profile_photo) : asset('storage/profile_photos/placeholder_pfp.jpg') }}"
                                class="rounded-circle me-3"
                                style="width: 48px; height: 48px; object-fit: cover;"
                                alt="Profile Photo">
                        </a>
                        <strong>
                            <a href="{{ $isResponder ? route('student.profile') : route('users.show', $response->user_id) }}" class="text-decoration-none text-dark fw-semibold">
                                {{ $response->user->name ?? 'User' }}
                            </a>
                        </strong>
                    </div>
                    <p class="mb-1">{{ $response->message }}</p>
                    @if($response->offer_price)
                        <p class="mb-1 text-success"><strong>Offer Price:</strong> ₱{{ number_format($response->offer_price, 2) }}</p>
                    @endif
                    <small class="text-muted">Sent at {{ $response->created_at->format('M d, Y H:i') }}</small>
                </div>
            @endforeach
        @else
            <p class="text-muted">No responses yet.</p>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const hash = window.location.hash;
        if (hash && hash.startsWith('#response-')) {
            const el = document.querySelector(hash);
            if (el) {
                el.classList.add('highlighted');
                setTimeout(() => {
                    el.classList.remove('highlighted');
                }, 1500);
            }
        }
    });
</script>

<!-- Image Preview Modal -->
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
