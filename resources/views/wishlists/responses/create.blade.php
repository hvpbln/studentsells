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

    .form-wrapper {
        background-color: #ffffff;
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    }

    .form-title {
        font-size: 1.75rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        color: #2f2f2f;
    }

    .form-label {
        font-weight: 500;
    }

    .btn-submit {
        background-color: #e6f49c;
        font-weight: 600;
        border-radius: 10px;
        border: none;
        color: #333;
        padding: 8px 16px;
    }

    .btn-cancel {
        border-radius: 10px;
        border: 1px solid #bbb;
        padding: 8px 16px;
        font-weight: 500;
        color: #444;
        margin-left: 10px;
    }
</style>

<div class="container-custom">
    <div class="form-wrapper">
        <h2 class="form-title">
            <i class="bi bi-reply-fill me-2"></i>Respond to Wishlist:
            <span class="text-primary">{{ $wishlist->title }}</span>
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
            <div class="d-flex">
                <button type="submit" class="btn btn-submit">
                    <i class="bi bi-send-fill me-1"></i>Send Response
                </button>
                <a href="{{ route('wishlists.show', $wishlist->id) }}" class="btn btn-cancel">
                    <i class="bi bi-x-circle me-1"></i>Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
