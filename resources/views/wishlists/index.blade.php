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
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        position: relative;
    }

    .wishlist-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
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

    .wishlist-buttons {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 1rem;
    }

    .btn, .btn-sm, .create-wishlist, .search-button, .btn-contact {
        border-radius: 8px !important;
        transition: all 0.25s ease-in-out;
    }

    .btn-contact {
        background-color: #e5f4c6;
        color: #3b3f58;
        border: none;
    }

    .btn-contact:hover {
        background-color: #cde38e;
        color: #2a2d3c;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-outline-info {
        border-radius: 8px;
    }

    .btn:hover {
        transform: translateY(-1px);
    }

    .search-button, .create-wishlist {
        background-color: #dbf4a7;
        color: #3b3f58;
        border: none;
        font-weight: 600;
        padding: 0.5rem 1rem;
    }

    .search-button:hover, .create-wishlist:hover {
        background-color: #95c235;
        color: #fff;
        transform: scale(1.03);
        box-shadow: 0 3px 12px rgba(149, 194, 53, 0.3);
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

    a {
        text-decoration: none;
        color: black;
    }

    .badge-status {
        padding: 0.4em 0.75em;
        font-size: 0.75rem;
        border-radius: 999px;
        font-weight: 600;
    }

    .bg-success {
        background-color: #b7e4c7 !important;
        color: #2b463c;
    }

    .bg-warning {
        background-color: #fff3cd !important;
        color: #856404;
    }

    .bg-secondary {
        background-color: #d6d6f5 !important;
        color: #3b3f58;
    }

    .modal-body img {
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        max-height: 80vh;
        max-width: 100%;
    }

    /* Scrollbar styling */
    ::-webkit-scrollbar {
        width: 10px;
    }

    ::-webkit-scrollbar-track {
        background: #dedff1;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: #b7e4c7;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #95c235;
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

                {{-- Dropdown for owner --}}
                @auth
                    @if(Auth::id() === $wishlist->user_id)
                    <div class="dropdown position-absolute top-0 end-0 m-2">
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
                @endauth

                {{-- User header --}}
                <div class="d-flex align-items-center mb-3">
                    <img src="{{ $wishlist->user->profile_photo ? asset('storage/' . $wishlist->user->profile_photo) : asset('storage/profile_photos/placeholder_pfp.jpg') }}"
                         class="rounded-circle me-3"
                         style="width: 55px; height: 55px; object-fit: cover;">
                    <div>
                        <a href="{{ route('users.show', $wishlist->user_id) }}"><strong>{{ $wishlist->user->name ?? 'Unknown' }}</strong></a>
                        <div><small class="text-muted">{{ $wishlist->created_at->diffForHumans() }}</small></div>
                    </div>
                </div>

                <hr style="margin: 0.5rem 0;">

                {{-- Title and status --}}
                <div class="d-flex align-items-center gap-2 mb-2">
                    <h5 class="fw-bold mb-0">{{ $wishlist->title }}</h5>
                        <span class="badge badge-status
                            {{ $wishlist->status === 'open' ? 'bg-success' :
                            ($wishlist->status === 'fulfilled' ? 'bg-warning' : 'bg-secondary') }}">
                            {{ ucfirst($wishlist->status) }}
                        </span>
                </div>

                {{-- Description --}}
                <p>{{ Str::limit($wishlist->description, 150) }}</p>

                {{-- Images --}}
                @if($wishlist->images->count())
                    <div class="wishlist-images mb-2 d-flex flex-wrap">
                        @foreach($wishlist->images as $image)
                            <img src="{{ asset('storage/' . $image->image_url) }}" 
                                data-bs-toggle="modal"
                                data-bs-target="#wishlistImagePreviewModal"
                                data-image="{{ asset('storage/' . $image->image_url) }}"
                                alt="Wishlist Image">
                        @endforeach
                    </div>
                @endif

                {{-- Buttons --}}
                <div class="wishlist-buttons">
                    <div>
                        <a href="{{ route('wishlists.show', $wishlist->id) }}" class="btn btn-outline-info btn-sm me-2">View</a>
                        <a href="{{ route('wishlists.responses.create', $wishlist->id) }}" class="btn btn-outline-info btn-sm">Respond</a>
                    </div>
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
        document.querySelectorAll('[data-bs-target="#wishlistImagePreviewModal"]').forEach(img => {
            img.addEventListener('click', function () {
                previewImage.src = this.getAttribute('data-image');
            });
        });
        document.getElementById('wishlistImagePreviewModal').addEventListener('hidden.bs.modal', () => {
            previewImage.src = '';
        });
    });
</script>
@endsection