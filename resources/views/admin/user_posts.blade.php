@extends('layouts.admin')

@section('title', 'Posts of ' . $user->name)

@section('content')
<style>
    body {
        font-family: 'Montserrat', sans-serif;
    }

    h1, h2 {
        margin-top: 30px;
        font-weight: 600;
        color: #222;
    }
    .table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
        background-color: white;
        border-radius: 6px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .table thead {
        background-color: #f2f2f2;
    }
    .table th, .table td {
        padding: 12px 16px;
        text-align: left;
        border-bottom: 1px solid #eee;
        vertical-align: top;
    }
    .table img {
        border-radius: 6px;
        border: 1px solid #ccc;
    }
    .d-flex {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    p {
        margin-top: 10px;
        color: #666;
    }
    a {
        display: inline-block;
        margin-top: 20px;
        text-decoration: none;
        color: #0066cc;
        font-weight: 500;
    }
    a:hover {
        text-decoration: underline;
    }

    .dashboard-btn {
        display: inline-block;
        background-color: #8E9DCC;
        color: white;
        padding: 10px 20px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 500;S
        transition: background-color 0.3s ease;
    }

    .dashboard-btn:hover {
        background-color: #7d84b2;
    }

</style>

<h1>Posts of {{ $user->name }}</h1>

<h2>Listings</h2>
@if($listings->isEmpty())
    <p>No listings found.</p>
@else
    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Price</th>
                <th>Condition</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Images</th>
            </tr>
        </thead>
        <tbody>
            @foreach($listings as $listing)
            <tr>
                <td>{{ $listing->title }}</td>
                <td>{{ Str::limit($listing->description, 100) }}</td>
                <td>${{ number_format($listing->price, 2) }}</td>
                <td>{{ ucfirst($listing->condition) }}</td>
                <td>{{ ucfirst($listing->status) }}</td>
                <td>{{ $listing->created_at->format('M d, Y') }}</td>
                <td>
                    @if($listing->images->count())
                        <div class="d-flex">
                            @foreach($listing->images as $image)
                                <img src="{{ asset('storage/' . $image->image_url) }}" alt="Image" width="60">
                            @endforeach
                        </div>
                    @else
                        N/A
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endif

<h2>Listing Responses</h2>
@if($listingResponses->isEmpty())
    <p>No listing responses found.</p>
@else
    <table class="table">
        <thead>
            <tr>
                <th>Listing Title</th>
                <th>Message</th>
                <th>Offer Price</th>
                <th>Sent At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($listingResponses as $response)
            <tr>
                <td>{{ $response->item->title ?? 'Deleted Listing' }}</td>
                <td>{{ Str::limit($response->message, 100) }}</td>
                <td>{{ $response->offer_price ? '$' . number_format($response->offer_price, 2) : 'N/A' }}</td>
                <td>{{ $response->created_at->format('M d, Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endif

<h2>Wishlists</h2>
@if($wishlists->isEmpty())
    <p>No wishlists found.</p>
@else
    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Price Range</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Images</th>
            </tr>
        </thead>
        <tbody>
            @foreach($wishlists as $wishlist)
            <tr>
                <td>{{ $wishlist->title }}</td>
                <td>{{ Str::limit($wishlist->description, 100) }}</td>
                <td>
                    @if($wishlist->price_range_min || $wishlist->price_range_max)
                        ${{ number_format($wishlist->price_range_min ?? 0, 2) }} - ${{ number_format($wishlist->price_range_max ?? 0, 2) }}
                    @else
                        N/A
                    @endif
                </td>
                <td>{{ ucfirst($wishlist->status) }}</td>
                <td>{{ $wishlist->created_at->format('M d, Y') }}</td>
                <td>
                    @if($wishlist->images->count())
                        <div class="d-flex">
                            @foreach($wishlist->images as $image)
                                <img src="{{ asset('storage/' . $image->image_url) }}" alt="Image" width="60">
                            @endforeach
                        </div>
                    @else
                        N/A
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endif

<h2>Wishlist Responses</h2>
@if($wishlistResponses->isEmpty())
    <p>No wishlist responses found.</p>
@else
    <table class="table">
        <thead>
            <tr>
                <th>Wishlist Title</th>
                <th>Message</th>
                <th>Offer Price</th>
                <th>Sent At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($wishlistResponses as $response)
            <tr>
                <td>{{ $response->wishlist->title ?? 'Deleted Wishlist' }}</td>
                <td>{{ Str::limit($response->message, 100) }}</td>
                <td>{{ $response->offer_price ? '$' . number_format($response->offer_price, 2) : 'N/A' }}</td>
                <td>{{ $response->created_at->format('M d, Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endif

<a href="{{ route('admin.manageUsers') }}" class="dashboard-btn">← Back to Users</a>
<BR></BR>
@endsection
