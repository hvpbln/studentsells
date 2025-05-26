@extends('layouts.admin')

@section('title', 'Manage Wishlists')

@section('content')
<h1>Manage Wishlists</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Title</th>
            <th>Posted By</th>
            <th>Price Range</th>
            <th>Status</th>
            <th>Images</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($wishlists as $wishlist)
            <tr>
                <td>{{ $wishlist->title }}</td>
                <td>{{ $wishlist->user->name ?? 'Unknown' }}</td>
                <td>
                    @if($wishlist->price_range_min) ${{ number_format($wishlist->price_range_min, 2) }} @endif -
                    @if($wishlist->price_range_max) ${{ number_format($wishlist->price_range_max, 2) }} @endif
                </td>
                <td>{{ ucfirst($wishlist->status) }}</td>
                <td>
                    @if($wishlist->images->count())
                        <img src="{{ asset('storage/' . $wishlist->images->first()->image_url) }}" alt="Image" width="60" class="img-thumbnail">
                    @else
                        N/A
                    @endif
                </td>
                <td>
                    <form action="{{ route('admin.wishlists.delete', $wishlist->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this wishlist?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-center">No wishlists found.</td></tr>
        @endforelse
    </tbody>
</table>

{{ $wishlists->links() }}

@endsection
