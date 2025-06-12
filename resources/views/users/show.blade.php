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

    /* Star Rating */
    .star-rating {
        font-size: 1.5rem;
        color: #ccc;
        cursor: pointer;
        display: flex;
        flex-direction: row;
    }
    .star-rating .star {
        color: #ccc;
        transition: color 0.2s ease;
    }
    .star-rating .star.hover,
    .star-rating .star.selected {
        color: #ffc107;
    }
</style>

<div class="container">

    {{-- Profile Header --}}
    <div class="profile-header">
        <img src="{{ asset('storage/' . ($user->profile_photo ?? 'default.png')) }}" alt="Profile Photo">
        <div>
            <h2>{{ $user->name }}</h2>
            <p class="text-muted">{{ $user->email }}</p>

            {{-- Display Average Rating --}}
            @if($user->ratingsReceived()->count())
                <div class="text-warning mt-1">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= floor($user->averageRating()))
                            ★
                        @elseif ($i - 0.5 <= $user->averageRating())
                            ☆
                        @else
                            ☆
                        @endif
                    @endfor
                    <span class="text-muted">({{ number_format($user->averageRating(), 1) }} / 5 from {{ $user->ratingsReceived()->count() }} ratings)</span>
                </div>
            @else
                <p class="text-muted">No ratings yet.</p>
            @endif

            {{-- Interactive Star Rating with Submit Button --}}
            @if(Auth::check() && Auth::id() !== $user->id)
                <br>
                <p> Give Ratings </p>
                <div class="star-rating mt-2" data-user-id="{{ $user->id }}">
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="star" data-value="{{ $i }}">&#9733;</span>
                    @endfor
                </div>
                <button id="submit-rating" class="btn btn-sm btn-primary mt-2" style="display:none;">Submit Rating</button>
                <div id="rating-message" class="mt-2 text-success" style="display:none;"></div>
            @endif
        </div>
    </div>

    {{-- Tab Buttons --}}
    <div class="tab-buttons">
        <button class="tab-btn active" onclick="switchTab('listings')">Listings</button>
        <button class="tab-btn" onclick="switchTab('wishlists')">Wishlists</button>
    </div>

    {{-- Listings --}}
    <div id="listings" class="tab-content active">
        <div class="section-title">Listings</div>
        @forelse($user->items as $item)
            <div class="card-section">
                <h5>{{ $item->title }}</h5>
                <div class="text-muted mb-2">{{ ucfirst($item->status) }} | ₱{{ number_format($item->price_range, 2) }}</div>
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
            <p class="text-muted">No listings found.</p>
        @endforelse
    </div>

    {{-- Wishlists --}}
    <div id="wishlists" class="tab-content">
        <div class="section-title">Wishlists</div>
        @forelse($user->wishlists as $wishlist)
            <div class="card-section">
                <h5>{{ $wishlist->title }}</h5>
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
            <p class="text-muted">No wishlists found.</p>
        @endforelse
    </div>

</div>

{{-- JavaScript --}}
<script>
    function switchTab(tabId) {
        document.querySelectorAll('.tab-content').forEach(div => div.classList.remove('active'));
        document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
        document.getElementById(tabId).classList.add('active');
        event.target.classList.add('active');
    }

    document.addEventListener('DOMContentLoaded', function () {
        const stars = document.querySelectorAll('.star-rating .star');
        const submitButton = document.getElementById('submit-rating');
        const message = document.getElementById('rating-message');
        const userId = document.querySelector('.star-rating')?.dataset.userId;

        if (!stars.length || !userId) return;

        let selected = 0;

        stars.forEach(star => {
            star.addEventListener('mouseenter', function () {
                highlightStars(parseInt(this.dataset.value));
            });

            star.addEventListener('mouseleave', function () {
                highlightStars(selected);
            });

            star.addEventListener('click', function () {
                selected = parseInt(this.dataset.value);
                highlightStars(selected);
                submitButton.style.display = 'inline-block';
                message.style.display = 'none';
            });
        });

        submitButton.addEventListener('click', function () {
            if (selected === 0) return;

            fetch(`/users/${userId}/rate`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ rating: selected })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    message.textContent = data.message;
                    message.style.display = 'block';
                    message.classList.remove('text-danger');
                    submitButton.style.display = 'none';
                } else {
                    message.textContent = data.message || 'Rating failed';
                    message.style.display = 'block';
                    message.classList.add('text-danger');
                }
            })
            .catch(() => {
                message.textContent = 'Error submitting rating.';
                message.style.display = 'block';
                message.classList.add('text-danger');
            });
        });

        function highlightStars(rating) {
            stars.forEach(star => {
                star.classList.remove('selected');
                if (parseInt(star.dataset.value) <= rating) {
                    star.classList.add('selected');
                }
            });
        }
    });
</script>
@endsection
