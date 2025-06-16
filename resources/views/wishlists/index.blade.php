@extends('layouts.layout')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Shrikhand&family=Great+Vibes&display=swap');
    
    body {
        background-color: #dedff1;
        font-family: 'Montserrat', sans-serif;
    }

    .wishlist-container {
        max-width: 800px;
        margin: 2rem auto;
        background-color: #dedff1;
        padding: 2rem;
    }

    .wishlist-card {
        background-color: #f9f9f2;
        border-radius: 16px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
    }

    .wishlist-image {
        cursor: zoom-in;
    }

    .wishlist-images img {
        width: 120px;
        border-radius: 10px;
        margin-right: 10px;
        cursor: pointer;
        transition: transform 0.2s ease;
    }

    .wishlist-images img:hover {
        transform: scale(1.02);
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

    .search-button, .create-wishlist {
        background-color: #dbf4a7;
        color: #3b3f58;
        border: none;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-weight: 600;
    }

    .search-button:hover, .create-wishlist:hover {
        background-color: #95c235;
        color: white;
    }

    .search-bar-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .search-bar-wrapper form {
        display: flex;
        gap: 0.5rem;
    }

    .name {
        font-size: 1.2rem;
        font-weight: 400;
    }

    a {
        text-decoration: none;
        color: black;
    }

    .badge {
        margin-bottom: 10px;
    }

    /* Modal image preview */
    .modal-body img {
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        max-height: 80vh;
        max-width: 100%;
    }
</style>

<div class="wishlist-container">
    <div class="search-bar-wrapper">
        <a href="{{ route('wishlists.create') }}" class="create-wishlist">Create New Wishlist</a>
        <form action="{{ route('wishlists.index') }}" method="GET">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search wishlists..." class="form-control" style="width: 250px;">
            <button type="submit" class="search-button">Search</button>
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($wishlists->count())
        @foreach($wishlists as $wishlist)
            <div class="wishlist-card">
                <div class="d-flex justify-content-between">
                    <div class="name">
                        <h3>
                            <a href="{{ route('users.show', $wishlist->user_id) }}">
                                {{ $wishlist->user->name ?? 'Unknown' }}
                            </a>
                        </h3>
                    </div>

                    @if(Auth::id() === $wishlist->user_id)
                    <div class="dropdown">
                        <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="background: transparent; border: none;">
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

                <hr style="margin: 0.5rem 0;">

                <span class="badge badge-status bg-{{ $wishlist->status == 'open' ? 'success' : 'secondary' }}">
                    {{ ucfirst($wishlist->status) }}
                </span> 

                <h5>{{ $wishlist->title }}</h5>
                <p>{{ Str::limit($wishlist->description, 150) }}</p>

                @if($wishlist->images->count())
                    <div class="wishlist-images mb-2 d-flex">
                        @foreach($wishlist->images as $image)
                            <img src="{{ asset('storage/' . $image->image_url) }}" 
                                alt="Image"
                                data-bs-toggle="modal"
                                data-bs-target="#wishlistImagePreviewModal"
                                data-image="{{ asset('storage/' . $image->image_url) }}">
                        @endforeach
                    </div>
                @endif

                <div class="wishlist-buttons">
                    <a href="{{ route('wishlists.show', $wishlist->id) }}" class="btn btn-outline-info btn-sm">View</a>
                    <a href="{{ route('wishlists.responses.create', $wishlist->id) }}" class="btn btn-outline-info btn-sm">Respond</a>
                    @auth
                        @if(auth()->id() !== $wishlist->user_id)
                            <a href="{{ route('messages.show', ['userId' => $wishlist->user_id, 'wishlist_id' => $wishlist->id]) }}" class="btn btn-contact btn-sm">Contact Poster</a>
                        @endif
                    @endauth
                </div>
            </div>
        @endforeach

        {{ $wishlists->links() }}
    @else
        <p>No wishlists found.</p>
    @endif
</div>

<!-- Modal for Image Preview -->
<div class="modal fade" id="wishlistImagePreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body text-center">
                <img id="wishlistPreviewImage" src="" alt="Preview">
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const previewImage = document.getElementById('wishlistPreviewImage');
        const modal = document.getElementById('wishlistImagePreviewModal');
        document.querySelectorAll('[data-bs-target="#wishlistImagePreviewModal"]').forEach(img => {
            img.addEventListener('click', function () {
                previewImage.src = this.getAttribute('data-image');
            });
        });
        modal.addEventListener('hidden.bs.modal', () => {
            previewImage.src = '';
        });
    });
</script>
@endsection