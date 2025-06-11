@extends('layouts.layout')

@section('content')
<div class="container mt-4">
    <div class="card shadow border-0">
        <div class="card-body">
            <h2 class="card-title mb-3">
                <i class="bi bi-reply-fill me-2"></i>Respond to Wishlist: <span class="text-primary">{{ $wishlist->title }}</span>
            </h2>

            <form method="POST" action="{{ route('wishlists.responses.store', $wishlist->id) }}">
                @csrf

                <!-- Message -->
                <div class="mb-3">
                    <label for="message" class="form-label">
                        <i class="bi bi-chat-left-dots me-1"></i> Message <span class="text-danger">*</span>
                    </label>
                    <textarea id="message" name="message" rows="4"
                              class="form-control @error('message') is-invalid @enderror"
                              placeholder="Write your response...">{{ old('message') }}</textarea>
                    @error('message')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Offer Price -->
                <div class="mb-3">
                    <label for="offer_price" class="form-label">
                        <i class="bi bi-currency-dollar me-1"></i> Offer Price (optional)
                    </label>
                    <input type="number" step="0.01" min="0" id="offer_price" name="offer_price"
                           class="form-control @error('offer_price') is-invalid @enderror"
                           value="{{ old('offer_price') }}" placeholder="e.g., 99.99">
                    @error('offer_price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Actions -->
                <button type="submit" class="btn btn-primary">Send Response</button>
                    <a href="{{ route('wishlists.show', $wishlist->id) }}" class="btn btn-secondary ms-2">Cancel</a>
                </form>

            </form>
        </div>
    </div>
</div>
@endsection
