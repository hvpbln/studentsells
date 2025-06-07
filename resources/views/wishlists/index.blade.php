@extends('layouts.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Wishlists</h1>

    <div class="d-flex">
        <form action="{{ route('wishlists.index') }}" method="GET" class="d-flex me-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search wishlists..." class="form-control me-2">
            <button type="submit" class="btn btn-outline-secondary">Search</button>
        </form>
        <a href="{{ route('wishlists.create') }}" class="btn btn-primary">Create New Wishlist</a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($wishlists->count())
    @foreach($wishlists as $wishlist)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">
                    {{ $wishlist->title }}
                    <span class="badge bg-secondary">{{ ucfirst($wishlist->status) }}</span>
                </h5>
                <p><strong>Posted by:</strong> {{ $wishlist->user->name ?? 'Unknown' }}</p>
                <p>{{ Str::limit($wishlist->description, 150) }}</p>

                @if($wishlist->images->count())
                    <div class="mb-2">
                        @foreach($wishlist->images as $image)
                            <img src="{{ asset('storage/' . $image->image_url) }}" alt="Image" width="100" class="me-2 img-thumbnail">
                        @endforeach
                    </div>
                @endif

                <a href="{{ route('wishlists.show', $wishlist->id) }}" class="btn btn-sm btn-info">View</a>
                <a href="{{ route('wishlists.responses.create', $wishlist->id) }}" class="btn btn-sm btn-info">Respond to Wishlist</a>

                @if(Auth::id() === $wishlist->user_id)
                    <a href="{{ route('wishlists.edit', $wishlist->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('wishlists.destroy', $wishlist->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this wishlist?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                @endif
            </div>
        </div>
    @endforeach

    {{ $wishlists->links() }}
@else
    <p>No wishlists found.</p>
@endif
@endsection