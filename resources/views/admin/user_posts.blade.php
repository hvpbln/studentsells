@extends('layouts.admin')

@section('title', 'Posts of ' . $user->name)

@section('content')
<h1>Posts of {{ $user->name }}</h1>

<h2>Listings</h2>
@if($listings->isEmpty())
    <p>No listings found.</p>
@else
    <table class="table table-bordered">
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
                        <div class="d-flex flex-wrap" style="gap: 5px;">
                            @foreach($listing->images as $image)
                                <img src="{{ asset('storage/' . $image->image_url) }}" alt="Image" width="60" class="img-thumbnail">
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
    <table class="table table-bordered">
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
    <table class="table table-bordered">
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
                        <div class="d-flex flex-wrap" style="gap: 5px;">
                            @foreach($wishlist->images as $image)
                                <img src="{{ asset('storage/' . $image->image_url) }}" alt="Image" width="60" class="img-thumbnail">
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
    <table class="table table-bordered">
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

<p><a href="{{ route('admin.manageUsers') }}">Back to Users</a></p>
@endsection
