@extends('layouts.layout')

@section('content')
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
                <div class="d-flex gap-2">
                    <a href="{{ route('messages.show', ['userId' => $item->user_id, 'item_id' => $item->id]) }}" class="btn btn-sm btn-outline-secondary">Chat</a>
                </div>
            </div>
        </div>

        <p class="text-muted">{{ $item->description }}</p>
        <p><strong>Price:</strong> ${{ $item->price }}</p>
        <p><strong>Status:</strong> <span class="badge bg-secondary">{{ $item->status }}</span></p>

        @if($item->images->count())
            <div class="row mt-3">
                @foreach($item->images as $img)
                    <div class="col-md-3 col-sm-6 mb-3">
                        <img src="{{ asset('storage/' . $img->image_url) }}" class="img-fluid rounded shadow-sm" style="object-fit: cover; height: auto; width: 200px;">
                    </div>
                @endforeach
            </div>
        @endif

        <h3 class="mt-4">Responses</h3>
        @if($item->responses->count())
            @foreach($item->responses as $response)
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

        <a href="{{ route('items.respond', $item->id) }}" class="btn btn-primary mt-3">Respond to Listing</a>
        <a href="{{ route('items.index') }}" class="btn btn-secondary mt-4">Back to List</a>
    </div>
</div>
@endsection