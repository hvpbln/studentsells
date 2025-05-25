@extends('layout')

@section('content')
<h1>{{ $wishlist->title }}</h1>

<p><strong>Description:</strong> {{ $wishlist->description }}</p>

<p>
    <strong>Price Range:</strong> 
    @if($wishlist->price_range_min) ${{ number_format($wishlist->price_range_min, 2) }} @endif -
    @if($wishlist->price_range_max) ${{ number_format($wishlist->price_range_max, 2) }} @endif
</p>

<p><strong>Status:</strong> {{ ucfirst($wishlist->status) }}</p>

@if($wishlist->images->count())
    <div class="mb-3">
        @foreach($wishlist->images as $image)
            <img src="{{ asset('storage/' . $image->image_url) }}" alt="Image" width="150" class="img-thumbnail me-2 mb-2">
        @endforeach
    </div>
@endif

<h3>Responses</h3>

@if($wishlist->responses->count())
    @foreach($wishlist->responses as $response)
        <div class="card mb-2">
            <div class="card-body">
                <p><strong>{{ $response->user->name ?? 'User' }}:</strong> {{ $response->message }}</p>
                @if($response->offer_price)
                    <p><strong>Offer Price:</strong> ${{ number_format($response->offer_price, 2) }}</p>
                @endif
                <small class="text-muted">Sent at {{ $response->created_at->format('M d, Y H:i') }}</small>
            </div>
        </div>
    @endforeach
@else
    <p>No responses yet.</p>
@endif

<a href="{{ route('wishlists.responses.create', $wishlist->id) }}" class="btn btn-primary mt-3">Respond to Wishlist</a>
<a href="{{ route('wishlists.index') }}" class="btn btn-secondary mt-3">Back to List</a>
@endsection
