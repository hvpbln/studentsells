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
        background-color:rgb(150, 179, 92);
    }

    .btn-secondary {
        border-radius: 10px;
    }
</style>

{{-- Main Listing Card --}}
<div class="card mb-4 shadow-sm card-display">
    <div class="card-body">
        <h4 class="fw-bold">{{ $item->title }}</h4>

        <div class="d-flex align-items-center mb-3">
            <img src="{{ $item->user->profile_photo ? asset('storage/' . $item->user->profile_photo) : asset('storage/profile_photos/placeholder_pfp.jpg') }}"
                 alt="Profile Photo"
                 class="rounded-circle me-3"
                 style="width: 64px; height: 64px; object-fit: cover;">

            <div>
                <p class="mb-1">
                    <strong>
                        <a href="{{ route('users.show', $item->user_id) }}">
                            {{ $item->user->name ?? 'Unknown' }}
                        </a>
                    </strong>
                </p>
                @auth
                    @if(auth()->id() !== $item->user_id)
                        <a href="{{ route('messages.show', ['userId' => $item->user_id, 'item_id' => $item->id]) }}" class="btn btn-sm btn-outline-secondary">Chat</a>
                    @endif
                @endauth
            </div>
        </div>

        <p class="text-muted">{{ $item->description }}</p>
        <p><strong>Price:</strong> ₱{{ $item->price }}</p>
        <p><strong>Status:</strong> <span class="badge bg-secondary">{{ $item->status }}</span></p>

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
                <div id="response-{{ $response->id }}" class="response-card mb-3">
                    <p><strong>{{ $response->user->name ?? 'User' }}:</strong> {{ $response->message }}</p>
                    @if($response->offer_price)
                        <p><strong>Offer Price:</strong> ₱{{ number_format($response->offer_price, 2) }}</p>
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
@endsection

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