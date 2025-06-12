@extends('layouts.layout')

@section('content')
<style>
    .tab-buttons {
        margin-bottom: 20px;
    }

    .tab-buttons button {
        margin-right: 10px;
        padding: 8px 20px;
        border: none;
        background-color: #e6e6f0;
        border-radius: 10px;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }

    .tab-buttons button.active {
        background-color: #cdd7a7;
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    .card-section {
        background-color: #f9f9f2;
        border-radius: 16px;
        padding: 1rem;
        box-shadow: 0 2px 6px rgba(0,0,0,0.06);
        margin-bottom: 1.5rem;
    }

    .item-images img, .wishlist-images img {
        width: 120px;
        height: 120px;
        border-radius: 10px;
        margin-right: 10px;
        object-fit: cover;
    }

    .btn-contact {
        background-color: #e5f4c6;
        color: #6c757d;
        border-radius: 10px;
    }

    .section-title {
        font-size: 1.8rem;
        font-weight: bold;
        margin-bottom: 25px;
    }

    .profile-header {
        display: flex;
        align-items: center;
        margin-bottom: 40px;
    }

    .profile-header img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 20px;
    }
</style>

<div class="container">

    {{-- Profile Header --}}
    <div class="profile-header">
        <img src="{{ asset('storage/' . ($user->profile_photo ?? 'default.png')) }}" alt="Profile Photo">
        <div>
            <h2>{{ $user->name }}</h2>
            <p class="text-muted">{{ $user->email }}</p>
        </div>
    </div>

    {{-- Tab Buttons --}}
    <div class="tab-buttons">
        <button class="tab-btn active" onclick="switchTab('listings')">Listings</button>
        <button class="tab-btn" onclick="switchTab('wishlists')">Wishlists</button>
    </div>

    {{-- Listings Section --}}
    <div id="listings" class="tab-content active">
        <div class="section-title">My Listings</div>
        @forelse($user->items as $item)
            <div class="card-section">
                <div class="d-flex justify-content-between align-items-center">
                    <h5>{{ $item->title }}</h5>
                    @if(Auth::id() === $item->user_id)
                        <div class="dropdown">
                            <button class="btn btn-sm" type="button" data-bs-toggle="dropdown">&#8942;</button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('items.edit', $item->id) }}">Edit</a></li>
                                <li>
                                    <form action="{{ route('items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete this listing?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger">Delete</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endif
                </div>

                <div class="text-muted mb-2">{{ ucfirst($item->status) }}</div>
                <p>{{ Str::limit($item->description, 150) }}</p>

                @if($item->images->count())
                    <div class="item-images d-flex mb-2">
                        @foreach($item->images as $image)
                            <img src="{{ asset('storage/' . $image->image_url) }}" alt="Item Image" class="img-thumbnail">
                        @endforeach
                    </div>
                @endif

                <div>
                    <a href="{{ route('items.show', $item->id) }}" class="btn btn-outline-info btn-sm">View</a>
                    <a href="{{ route('items.respond', $item->id) }}" class="btn btn-outline-info btn-sm">Respond</a>
                    <a href="#" class="btn btn-contact btn-sm">Contact Poster</a>
                </div>
            </div>
        @empty
            <p class="text-muted">You haven't posted any listings.</p>
        @endforelse
    </div>

    {{-- Wishlists Section --}}
    <div id="wishlists" class="tab-content">
        <div class="section-title">My Wishlists</div>
        @forelse($user->wishlists as $wishlist)
            <div class="card-section">
                <div class="d-flex justify-content-between align-items-center">
                    <h5>{{ $wishlist->title }}</h5>
                    @if(Auth::id() === $wishlist->user_id)
                        <div class="dropdown">
                            <button class="btn btn-sm" type="button" data-bs-toggle="dropdown">&#8942;</button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('wishlists.edit', $wishlist->id) }}">Edit</a></li>
                                <li>
                                    <form action="{{ route('wishlists.destroy', $wishlist->id) }}" method="POST" onsubmit="return confirm('Delete this wishlist?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger">Delete</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endif
                </div>

                <div class="text-muted mb-2">{{ ucfirst($wishlist->status) }}</div>
                <p>{{ Str::limit($wishlist->description, 150) }}</p>

                @if($wishlist->images->count())
                    <div class="wishlist-images d-flex mb-2">
                        @foreach($wishlist->images as $image)
                            <img src="{{ asset('storage/' . $image->image_url) }}" alt="Wishlist Image" class="img-thumbnail">
                        @endforeach
                    </div>
                @endif

                <div>
                    <a href="{{ route('wishlists.show', $wishlist->id) }}" class="btn btn-outline-info btn-sm">View</a>
                    <a href="{{ route('wishlists.responses.create', $wishlist->id) }}" class="btn btn-outline-info btn-sm">Respond</a>
                    <a href="#" class="btn btn-contact btn-sm">Contact Seller</a>
                </div>
            </div>
        @empty
            <p class="text-muted">You haven't added any wishlists.</p>
        @endforelse
    </div>

</div>

{{-- JavaScript to Handle Tab Switching --}}
<script>
    function switchTab(tabId) {
        // Hide all
        document.querySelectorAll('.tab-content').forEach(div => div.classList.remove('active'));
        document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));

        // Show selected
        document.getElementById(tabId).classList.add('active');
        event.target.classList.add('active');
    }
</script>
@endsection
