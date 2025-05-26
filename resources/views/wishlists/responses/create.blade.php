@extends('layouts.layout')

@section('content')
<h1>Respond to Wishlist: {{ $wishlist->title }}</h1>

<form method="POST" action="{{ route('wishlists.responses.store', $wishlist->id) }}">
    @csrf

    <div class="mb-3">
        <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
        <textarea id="message" name="message" class="form-control @error('message') is-invalid @enderror" rows="4" required>{{ old('message') }}</textarea>
        @error('message')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="offer_price" class="form-label">Offer Price (optional)</label>
        <input type="number" step="0.01" min="0" id="offer_price" name="offer_price" class="form-control @error('offer_price') is-invalid @enderror" value="{{ old('offer_price') }}">
        @error('offer_price')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Send Response</button>
    <a href="{{ route('wishlists.show', $wishlist->id) }}" class="btn btn-secondary ms-2">Cancel</a>
</form>
@endsection
