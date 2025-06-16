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

    .listing-images {
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

    a.user-link {
        text-decoration: none;
        border-bottom: 2px solid transparent;
        color: #333;
        transition: border-color 0.2s ease;
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
</style>

{{-- Main Listing Card --}}
<div class="card mb-4 shadow-sm card-display">
    <div class="card-body">
        {{-- Title and Status --}}
        <div class="d-flex align-items-center gap-2 mb-2">
            <h4 class="fw-bold mb-0">{{ $item->title }}</h4>
            <span class="badge badge-status
                {{ $item->status === 'available' ? 'bg-success' :
                   ($item->status === 'reserved' ? 'bg-warning' : 'bg-secondary') }}">
                {{ ucfirst($item->status) }}
            </span>
        </div>

        {{-- Poster Info --}}
        <div class="d-flex align-items-center mb-3">
            <img src="{{ $item->user->profile_photo ? asset('storage/' . $item->user->profile_photo) : asset('storage/profile_photos/placeholder_pfp.jpg') }}"
                 alt="Profile Photo"
                 class="rounded-circle me-3"
                 style="width: 64px; height: 64px; object-fit: cover;">

            <div>
                <p class="mb-1">
                    <strong>
                        {{-- ✅ Conditional profile link for poster --}}
                        @php
                            $isOwner = auth()->check() && auth()->id() === $item->user_id;
                        @endphp
                        <a href="{{ $isOwner ? route('student.profile') : route('users.show', $item->user_id) }}" class="user-link">
                            {{ $item->user->name ?? 'Unknown' }}
                        </a>
                    </strong>
                </p>
                @auth
                    @if(auth()->id() !== $item->user_id)
                        <a href="{{ route('messages.show', ['userId' => $item->user_id, 'item_id' => $item->id]) }}" class="btn btn-sm btn-chat">Chat</a>
                    @endif
                @endauth
            </div>
        </div>

        <p><strong>Price:</strong> ₱{{ number_format($item->price, 2) }}</p>
        <p class="text-muted">{{ $item->description }}</p>

        @if($item->images->count())
            <div class="listing-images mb-2 d-flex flex-wrap gap-2">
                @foreach($item->images as $image)
                    <img src="{{ asset('storage/' . $image->image_url) }}"
                        alt="Item Image"
                        class="img-fluid preview-image"
                        data-bs-toggle="modal"
                        data-bs-target="#imagePreviewModal"
                        data-image="{{ asset('storage/' . $image->image_url) }}"
                        style="width: 300px; height: auto; object-fit: cover;
                        border-radius:10px; cursor: pointer;">
                @endforeach
            </div>
        @endif

        <a href="{{ route('items.respond', $item->id) }}" class="btn btn-respond mt-3">Respond to Listing</a>
        <a href="{{ route('items.index') }}" class="btn btn-secondary mt-3">Back to List</a>
    </div>
</div>

{{-- Responses Section --}}
<div class="card">
    <div class="card-body">
        <h3 class="fw-semibold mb-3">Responses</h3>

        @if($item->responses->count())
            @foreach($item->responses as $response)
                <div id="response-{{ $response->id }}" class="response-card mb-3 d-flex align-items-start gap-3">
                    <img src="{{ $response->user->profile_photo ? asset('storage/' . $response->user->profile_photo) : asset('storage/profile_photos/placeholder_pfp.jpg') }}"
                        alt="User Photo"
                        class="rounded-circle"
                        style="width: 48px; height: 48px; object-fit: cover;">

                    <div>
                        <p class="mb-1">
                            <strong>
                                {{-- ✅ Conditional profile link for responder --}}
                                @php
                                    $isResponder = auth()->check() && auth()->id() === $response->user_id;
                                @endphp
                                <a href="{{ $isResponder ? route('student.profile') : route('users.show', $response->user_id) }}" class="user-link">
                                    {{ $response->user->name ?? 'User' }}
                                </a>:
                            </strong>
                            {{ $response->message }}
                        </p>
                        @if($response->offer_price)
                            <p><strong>Offer Price:</strong> ₱{{ number_format($response->offer_price, 2) }}</p>
                        @endif
                        <small class="text-muted">Sent at {{ $response->created_at->format('M d, Y H:i') }}</small>
                    </div>
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
<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-labelledby="imagePreviewLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content bg-transparent border-0">
      <div class="modal-body text-center p-0">
        <img id="modalImage" src="" class="img-fluid rounded shadow" style="max-height: 80vh;">
      </div>
    </div>
  </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modalImage = document.getElementById('modalImage');
        const modal = document.getElementById('imagePreviewModal');
        document.querySelectorAll('[data-bs-target="#imagePreviewModal"]').forEach(img => {
            img.addEventListener('click', function () {
                modalImage.src = this.getAttribute('data-image');
            });
        });
        modal.addEventListener('hidden.bs.modal', () => {
            modalImage.src = '';
        });
    });
</script>
@endsection