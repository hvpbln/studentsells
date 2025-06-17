@extends('layouts.layout')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Shrikhand&family=Great+Vibes&display=swap');

body {
    background-color: #dedff1;
    font-family: 'Montserrat', sans-serif;
}

.listing-container {
    max-width: 800px;
    margin: 2rem auto;
    background-color: #dedff1;
    padding: 2rem;
}

.listing-card {
    background-color: #f9f9f2;
    border-radius: 16px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
    padding: 1rem 1.5rem;
    margin-bottom: 1.5rem;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    position: relative;
}

.listing-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
}

.listing-images img {
    width: 120px;
    border-radius: 10px;
    margin-right: 10px;
    cursor: pointer;
    transition: transform 0.2s ease;
}

.listing-images img:hover {
    transform: scale(1.02);
}

.btn, .btn-sm, .create-listing, .search-button, .btn-contact {
    border-radius: 8px !important;
    transition: all 0.25s ease-in-out;
}

.btn:hover {
    transform: translateY(-1px);
}

.search-button, .create-listing {
    background-color: #dbf4a7;
    color: #3b3f58;
    border: none;
    font-weight: 600;
    padding: 0.5rem 1rem;
}

.search-button:hover, .create-listing:hover {
    background-color: #95c235;
    color: #fff;
    transform: scale(1.03);
    box-shadow: 0 3px 12px rgba(149, 194, 53, 0.3);
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

.description-text.truncated {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    max-height: 4.5em;
    word-wrap: break-word;
    word-break: break-word;
}

.modal-body img {
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    max-height: 80vh;
    max-width: 100%;
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

<div class="listing-container">
    <div class="search-bar-wrapper">
        <a href="{{ route('items.create') }}" class="create-listing">Create New Listing</a>
        <form action="{{ route('items.index') }}" method="GET">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search listings..." class="form-control" style="width: 250px;">
            <button type="submit" class="search-button">Search</button>
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($items->count())
        @foreach($items as $item)
            <div class="listing-card position-relative">

                {{-- Dropdown for owner --}}
                @auth
                    @if(auth()->id() === $item->user_id)
                        <div class="dropdown position-absolute top-0 end-0 m-2">
                            <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="background: transparent; border: none;">
                                &#8942;
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('items.edit', $item->id) }}">Edit</a></li>
                                <li>
                                    <form action="{{ route('items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                        @csrf @method('DELETE')
                                        <button class="dropdown-item text-danger" type="submit">Delete</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endif
                @endauth

                {{-- User header --}}
                <div class="d-flex align-items-center mb-3">
                    <img src="{{ $item->user->profile_photo ? asset('storage/' . $item->user->profile_photo) : asset('storage/profile_photos/placeholder_pfp.jpg') }}"
                         class="rounded-circle me-3"
                         style="width: 55px; height: 55px; object-fit: cover;">
                    <div>
                        @php
                            $isOwner = auth()->check() && auth()->id() === $item->user_id;
                        @endphp

                        <a href="{{ $isOwner ? route('student.profile') : route('users.show', $item->user_id) }}">
                            <strong>{{ $item->user->name ?? 'Unknown' }}</strong>
                        </a>
                        <div><small class="text-muted">{{ $item->updated_at->diffForHumans() }}</small></div>
                    </div>
                </div>

                <hr style="margin: 0.5rem 0;">

                {{-- Title and status --}}
                <div class="d-flex align-items-center gap-2 mb-2">
                    <h5 class="fw-bold mb-0">{{ $item->title }}</h5>
                    <span class="badge badge-status
                        {{ $item->status === 'available' ? 'bg-success' :
                           ($item->status === 'reserved' ? 'bg-warning' : 'bg-secondary') }}">
                        {{ ucfirst($item->status) }}
                    </span>
                </div>

                {{-- Description --}}
                @php
                    $isLong = strlen(strip_tags($item->description)) > 300;
                @endphp

                <p class="description-text truncated" id="desc-{{ $item->id }}">{{ $item->description }}</p>
                @if($isLong)
                    <a href="javascript:void(0);" class="see-more-link" onclick="toggleDescription({{ $item->id }})" id="toggle-{{ $item->id }}">See More</a>
                @endif

                {{-- Images --}}
                @if($item->images->count())
                    <div class="listing-images mb-2 d-flex flex-wrap">
                        @foreach($item->images as $image)
                            <img src="{{ asset('storage/' . $image->image_url) }}" 
                                 data-bs-toggle="modal"
                                 data-bs-target="#imagePreviewModal"
                                 data-image="{{ asset('storage/' . $image->image_url) }}"
                                 alt="Item Image">
                        @endforeach
                    </div>
                @endif

                {{-- Buttons --}}
                <div class="listing-buttons d-flex justify-content-between align-items-center mt-2">
                    <div>
                        <a href="{{ route('items.show', $item->id) }}" class="btn btn-outline-info btn-sm me-2">View</a>
                        <a href="{{ route('items.respond', $item->id) }}" class="btn btn-outline-info btn-sm">Respond</a>
                    </div>
                    @auth
                        @if(auth()->id() !== $item->user_id)
                            <a href="{{ route('messages.show', ['userId' => $item->user_id, 'item_id' => $item->id]) }}" class="btn btn-contact btn-sm">Contact Seller</a>
                        @endif
                    @endauth
                </div>
            </div>
        @endforeach

        {{ $items->links() }}
    @elseif(request('search'))
        <div class="alert alert-warning">No results found for "{{ request('search') }}".</div>
    @else
        <div class="alert alert-info">No items have been listed yet.</div>
    @endif
</div>

{{-- Modal --}}
<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Preview">
            </div>
        </div>
    </div>
</div>

<script>
    function toggleDescription(id) {
        const desc = document.getElementById('desc-' + id);
        const toggle = document.getElementById('toggle-' + id);
        if (desc.classList.contains('truncated')) {
            desc.classList.remove('truncated');
            toggle.innerText = 'See Less';
        } else {
            desc.classList.add('truncated');
            toggle.innerText = 'See More';
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const previewImage = document.getElementById('modalImage');
        const modal = document.getElementById('imagePreviewModal');
        document.querySelectorAll('[data-bs-target="#imagePreviewModal"]').forEach(img => {
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