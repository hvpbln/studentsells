@extends('layouts.layout')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Shrikhand&family=Great+Vibes&display=swap');
    
    body {
        font-family: 'Montserrat', sans-serif;
    }
    
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
        width: 600px;
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
        width: 192px;
        height: 192px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 20px;
    }

    .btn {
        font-size: 0.75rem;
        color: #6c6c6c;
        border: 1px solid #bbbbbb;
        padding: 4px 8px;
        border-radius: 6px;
        text-decoration: none;
    }

    .btn:hover {
        background-color: #eff6ff;
    }

    .container2 {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

</style>

<div class="container">

    {{-- Profile Header --}}
    <div class="profile-header">
        <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Profile Photo" class="user-header-photo">
        <div class="flex-grow-1">
            <h2>{{ $user->name }}</h2>
            <p class="text-muted mb-1">{{ $user->email }}</p>

            {{-- Average Rating --}}
            @if($user->ratingsReceived()->count())
                <div class="text-warning d-flex align-items-center">
                    <div style="font-size: 1.2rem; margin-right: 8px;">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= floor($user->averageRating()))
                                ★
                            @elseif ($i - 0.5 <= $user->averageRating())
                                ☆
                            @else
                                ☆
                            @endif
                        @endfor
                    </div>
                    <span class="text-muted" style="font-size: 0.95rem;">
                        ({{ number_format($user->averageRating(), 1) }} / 5 from {{ $user->ratingsReceived()->count() }} ratings)
                    </span>
                </div>
            @else
                <p class="text-muted mt-1">No ratings yet.</p>
            @endif

            @if(Auth::id() === $user->id)
                <a href="{{ route('student.profile.edit') }}" class="btn btn-outline-primary btn-sm">Edit Profile</a>
            @endif
        </div>
    </div>

    <div class="container2">
            {{-- Tab Buttons --}}
        <div class="tab-buttons">
            <button class="tab-btn active" onclick="switchTab('listings')">My Listings</button>
            <button class="tab-btn" onclick="switchTab('wishlists')">My Wishlists</button>

        </div>

        {{-- Listings Section --}}
        <div id="listings" class="tab-content active">
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
                            @auth
                                @if(auth()->id() !== $item->user_id)
                                    <a href="{{ route('messages.show', $item->user_id) }}?item_id={{ $item->id }}" class="btn btn-contact btn-sm">Contact Seller</a>
                                @endif
                            @endauth
                    </div>
                </div>
            @empty
                <p class="text-muted">You haven't posted any listings.</p>
            @endforelse
        </div>

        {{-- Wishlists Section --}}
        <div id="wishlists" class="tab-content">
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
                            @auth
                                @if(auth()->id() !== $wishlist->user_id)
                                    <a href="{{ route('messages.show', $wishlist->user_id) }}?wishlist_id={{ $wishlist->id }}" class="btn btn-contact btn-sm">Contact Poster</a>
                                @endif
                            @endauth
                    </div>
                </div>
            @empty
                <p class="text-muted">You haven't added any wishlists.</p>
            @endforelse
        </div>

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