@extends('layouts.admin')

@section('title', 'Manage All Responses')

@section('content')

<style>
  table.table-bordered th,
  table.table-bordered td {
    border: 1px solid #dee2e6 !important;
    padding: 0.75rem;
  }
</style>

<h1>All Responses</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- Wishlist Responses --}}
<h3 class="mt-4">Wishlist Responses</h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Responder</th>
            <th>Wishlist Title</th>
            <th>Message</th>
            <th>Offer Price</th>
            <th>Sent At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($wishlistResponses as $response)
            <tr>
                <td>{{ $response->user->name ?? 'Unknown' }}</td>
                <td>{{ $response->wishlist->title ?? 'Deleted Wishlist' }}</td>
                <td>{{ Str::limit($response->message, 50) }}</td>
                <td>{{ $response->offer_price ? '$' . number_format($response->offer_price, 2) : 'N/A' }}</td>
                <td>{{ $response->created_at->format('M d, Y H:i') }}</td>
                <td>
                    <form action="{{ route('admin.responses.wishlist.delete', $response->id) }}" method="POST" onsubmit="return confirm('Delete this wishlist response?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-center">No wishlist responses found.</td></tr>
        @endforelse
    </tbody>
</table>

{{-- Listing Responses --}}
<h3 class="mt-5">Listing Responses</h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Responder</th>
            <th>Listing Title</th>
            <th>Message</th>
            <th>Offer Price</th>
            <th>Sent At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($listingResponses as $response)
            <tr>
                <td>{{ $response->user->name ?? 'Unknown' }}</td>
                <td>{{ $response->item->title ?? 'Deleted Listing' }}</td>
                <td>{{ Str::limit($response->message, 50) }}</td>
                <td>{{ $response->offer_price ? '$' . number_format($response->offer_price, 2) : 'N/A' }}</td>
                <td>{{ $response->created_at->format('M d, Y H:i') }}</td>
                <td>
                    <form action="{{ route('admin.responses.listing.delete', $response->id) }}" method="POST" onsubmit="return confirm('Delete this listing response?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-center">No listing responses found.</td></tr>
        @endforelse
    </tbody>
</table>

@endsection
