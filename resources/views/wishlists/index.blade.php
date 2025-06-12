@extends('layouts.layout')

@section('content')
<style>
    .wishlist-card {
        background-color: #f9f9f2;
        border: none;
        border-radius: 16px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.06);
        padding: 1rem;
        margin-bottom: 1rem;
    }

    .wishlist-status {
        color: #838ab6;
        font-weight: 500;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .wishlist-images img {
        width: 120px;
        border-radius: 10px;
        margin-right: 10px;
    }

    .wishlist-buttons .btn {
        margin-right: 0.5rem;
        font-size: 0.875rem;
    }

    .btn-contact {
        background-color: #e5f4c6;
        color: #6c757d;
        border-radius: 10px;
    }

    .wishlist-badge {
        background-color: #f0f0f0;
        color: #333;
        font-weight: 500;
        border-radius: 10px;
        padding: 0.25rem 0.5rem;
        font-size: 0.8rem;
    }
    .name {
        font-size: 1.2rem;
        font-weight: 500;
    }


</style>

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
        <div class="wishlist-card position-relative">
            <div class="d-flex justify-content-between">
                <div class="name">
                        <strong>
                        <a href="{{ route('users.show', $wishlist->user_id) }}">
                            {{ $wishlist->user->name ?? 'Unknown' }}
                        </a>
                    </strong>
                </div>
                @if(Auth::id() === $wishlist->user_id)
                
                    <div class="dropdown">
                        <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="background: transparent; border: none; font-size: 1.25rem;">
                            &#8942;
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('wishlists.edit', $wishlist->id) }}">Edit Post</a></li>
                            <li>
                                <button class="dropdown-item text-danger"
                                    onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this wishlist?')) document.getElementById('delete-wishlist-{{ $wishlist->id }}').submit();">
                                     Delete Post
                                </button>
                            </li>
                        </ul>
                        <form id="delete-wishlist-{{ $wishlist->id }}" action="{{ route('wishlists.destroy', $wishlist->id) }}" method="POST" class="d-none">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                @endif
            </div>

            <hr style="border-top: 1px solid #000000; margin: 0.5rem 0;">

            <div class="wishlist-status">{{ ucfirst($wishlist->status) }}</div>

                <h5 class="card-title">
                    {{ $wishlist->title }}
                </h5>

            <p>{{ Str::limit($wishlist->description, 150) }}</p>

            @if($wishlist->images->count())
                <div class="wishlist-images mb-2 d-flex">
                    @foreach($wishlist->images as $image)
                        <img src="{{ asset('storage/' . $image->image_url) }}" alt="Image" class="img-thumbnail">
                    @endforeach
                </div>
            @endif

            <div class="wishlist-buttons">
                <a href="{{ route('wishlists.show', $wishlist->id) }}" class="btn btn-outline-info btn-sm">View</a>
                <a href="{{ route('wishlists.responses.create', $wishlist->id) }}" class="btn btn-outline-info btn-sm">Respond</a>
                <a href="#" class="btn btn-contact btn-sm">Contact Seller</a>
            </div>
        </div>
    @endforeach

    {{ $wishlists->links() }}
@else
    <p>No wishlists found.</p>
@endif
@endsection
