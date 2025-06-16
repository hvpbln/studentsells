@extends('layouts.layout')

@section('content')

<style>
    .listing-card {
        background-color: #f9f9f2;
        border: none;
        border-radius: 16px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
        padding: 1rem;
        margin-bottom: 1rem;

        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
    }

    .listing-status {
        color: #838ab6;
        font-weight: 500;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .listing-images {
        justify-content: center;
    }

    .listing-images img {
        width: 300px;
        border-radius: 10px;
        margin-right: 10px;
    }

    .listing-buttons .btn {
        margin-right: 0.5rem;
        font-size: 0.875rem;
    }

    .btn-contact {
        background-color: #e5f4c6;
        color: #6c757d;
        border-radius: 10px;
    }

    .btn-primary {
        background-color: #e5f4c6;
        color: #6c757d;
        border-radius: 10px;
    }

    .btn-primary:hover {
        background-color:rgb(150, 179, 92);
    }

    .listing-badge {
        background-color: #f0f0f0;
        color: #333;
        font-weight: 500;
        border-radius: 10px;
        padding: 0.25rem 0.5rem;
        font-size: 0.8rem;
    }

    .profile-pic {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 50%;
        margin-right: 10px;
    }

    .listing-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .listing-user {
        display: flex;
        align-items: center;
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

    .description-text {
        word-wrap: break-word;
        word-break: break-word;
    }

    .see-more-link {
        cursor: pointer;
        color:rgb(153, 129, 203);
        text-decoration: none;
    }


</style>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Listings</h1>
    <div class="d-flex">
        <form action="{{ route('items.index') }}" method="GET" class="d-flex me-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search Listings..." class="form-control me-2">
            <button type="submit" class="btn btn-outline-secondary">Search</button>
        </form>
        <a href="{{ route('items.create') }}" class="btn btn-primary">Create New Listing</a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($items->count())
    @foreach($items as $item)
        <div class="listing-card position-relative">

            {{-- Top right dropdown for lister --}}
            @auth
                @if(auth()->id() === $item->user_id)
                    <div class="dropdown position-absolute top-0 end-0 m-2">
                        <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="background: transparent; border: none; font-size: 1.25rem;">
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

            {{-- Header --}}
            <div class="listing-header mb-2">
                <div class="d-flex align-items-center mb-3">
                    <img src="{{ $item->user->profile_photo ? asset('storage/' . $item->user->profile_photo) : asset('storage/profile_photos/placeholder_pfp.jpg') }}"
                        alt="Profile Photo"
                        class="rounded-circle me-3"
                        style="width: 55px; height: 55px; object-fit: cover;">

                    <div>
                        <div class="mb-0">
                            <strong>
                                <a href="{{ route('users.show', $item->user_id) }}">
                                    {{ $item->user->name ?? 'Unknown' }}
                                </a>
                            </strong>
                            <div class="mt-1">
                                <small class="text-muted">{{ $item->updated_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <hr style="border-top: 1px solid #000000; margin: 0 0 0.3rem 0;">
            </div>

            <div class="d-flex align-items-center gap-2 mb-2">
                <h5 class="fw-bold mb-0">{{ $item->title }}</h5>
                <span class="px-2 py-1 text-white fw-semibold"
                    style="background-color:
                        {{ $item->status === 'available' ? '#28a745' : 
                        ($item->status === 'reserved' ? '#ffc107' : 
                        ($item->status === 'sold' ? '#6c757d' : '#999')) }};
                        border-radius: 10px;">
                    {{ ucfirst($item->status) }}
                </span>
            </div>



            @php
                $isLong = strlen(strip_tags($item->description)) > 300;
            @endphp

            <div class="listing-description">
                <p class="description-text truncated" id="desc-{{ $item->id }}">
                    {{ $item->description }}
                </p>
                @if($isLong)
                    <a href="javascript:void(0);" class="see-more-link" onclick="toggleDescription({{ $item->id }})" id="toggle-{{ $item->id }}">See More</a>
                @endif
            </div>


            @if($item->images->count())
                <div class="listing-images mb-2 d-flex flex-wrap gap-2" style="max-width: 100%;">
                    @foreach($item->images as $image)
                        <img src="{{ asset('storage/' . $image->image_url) }}"
                        alt="Item Image"
                        class="img-fluid preview-image"
                        data-bs-toggle="modal"
                        data-bs-target="#imagePreviewModal"
                        data-image="{{ asset('storage/' . $image->image_url) }}"
                        style="width: 300px; height: auto; object-fit: cover; 
                        border-radius:10px; cursor: zoom-in;">
                    @endforeach
                </div>
            @endif


            {{-- Buttons --}}
            <div class="listing-buttons d-flex justify-content-between align-items-center mt-2">
                <div>
                    <a href="{{ route('items.show', $item->id) }}" class="btn btn-outline-info btn-sm me-2">View</a>
                    <a href="{{ route('items.respond', $item->id) }}" class="btn btn-outline-info btn-sm">Respond</a>
                </div>

                <div>
                    @auth
                        @if(auth()->id() !== $item->user_id)
                            <a href="{{ route('messages.show', ['userId' => $item->user_id, 'item_id' => $item->id]) }}" class="btn btn-contact btn-sm">Contact Seller</a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    @endforeach

    <div class="mt-4">
        {{ $items->links() }}
    </div>
@elseif(request('search'))
    <div class="alert alert-warning">No results found for "{{ request('search') }}".</div>
@else
    <div class="alert alert-info">No items have been listed yet.</div>
@endif
@endsection

<!-- Image Preview Modal -->
<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-labelledby="imagePreviewLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content bg-transparent border-0">
      <div class="modal-body text-center p-0">
        <img id="modalImage" src="" class="img-fluid rounded shadow" style="max-height: 80vh;">
      </div>
    </div>
  </div>
</div>
