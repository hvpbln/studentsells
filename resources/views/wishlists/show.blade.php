@extends('layouts.layout')

@section('content')
<div class="container mt-4">
    <!-- Wishlist Card -->
    <div class="card shadow-lg border-0 mb-4">
        <div class="card-body">
            <h2 class="card-title mb-2">
                <i class="bi bi-star-fill text-warning me-2"></i>{{ $wishlist->title }}
            </h2>

            <p class="text-muted mb-1">
                <i class="bi bi-person-circle me-1"></i>
                <strong>Posted by:</strong> {{ $wishlist->user->name ?? 'Unknown' }}
            </p>

            <p class="mb-1">
                <i class="bi bi-cash-coin me-1"></i>
                <strong>Price Range:</strong>
                @if($wishlist->price_range_min)
                    ${{ number_format($wishlist->price_range_min, 2) }}
                @endif
                -
                @if($wishlist->price_range_max)
                    ${{ number_format($wishlist->price_range_max, 2) }}
                @endif
            </p>

            <p class="mb-3">
                <i class="bi bi-info-circle me-1"></i>
                <strong>Status:</strong>
                <span class="badge bg-{{ $wishlist->status == 'open' ? 'success' : 'secondary' }}">
                    {{ ucfirst($wishlist->status) }}
                </span>
            </p>

            <!-- Images -->
            @if($wishlist->images->count())
                <div class="d-flex flex-wrap mt-3">
                    @foreach($wishlist->images as $image)
                        <div class="me-2 mb-2">
                            <img src="{{ asset('storage/' . $image->image_url) }}"
                                 alt="Wishlist Image"
                                 class="rounded shadow-sm"
                                 style="width: 150px; height: auto; object-fit: cover;">
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Responses Section -->
    <div class="mb-4">
        <h4 class="mb-3"><i class="bi bi-chat-left-dots me-2"></i>Responses</h4>

        @if($wishlist->responses->count())
            @foreach($wishlist->responses as $response)
                <div class="card mb-3 border-0 shadow-sm">
                    <div class="card-body">
                        <p class="mb-1">
                            <strong><i class="bi bi-person-circle me-1"></i>{{ $response->user->name ?? 'User' }}:</strong>
                            {{ $response->message }}
                        </p>

                        @if($response->offer_price)
                            <p class="mb-1">
                                <i class="bi bi-currency-dollar me-1 text-success"></i>
                                <strong>Offer Price:</strong> ${{ number_format($response->offer_price, 2) }}
                            </p>
                        @endif

                        <small class="text-muted">
                            <i class="bi bi-clock me-1"></i>
                            Sent on {{ $response->created_at->format('M d, Y H:i') }}
                        </small>
                    </div>
                </div>
            @endforeach
        @else
            <div class="alert alert-info" role="alert">
                <i class="bi bi-info-circle me-1"></i> No responses yet. Be the first to respond!
            </div>
        @endif
    </div>

    <!-- Action Buttons -->
    <div class="d-flex gap-3">
        <a href="{{ route('wishlists.responses.create', $wishlist->id) }}" class="btn btn-primary">
            <i class="bi bi-reply-fill me-1"></i> Respond to Wishlist
        </a>
        <a href="{{ route('wishlists.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back to List
        </a>
    </div>
</div>
@endsection
