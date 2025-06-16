@extends('layouts.admin')

@section('title', 'Manage Wishlists')

@section('content')
<style>
    body {
        font-family: 'Montserrat', sans-serif;
    }

    .page-title {
        font-size: 1.75rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        color: #333;
    }

    .success-message {
        background-color: #e6ffed;
        border: 1px solid #b7f5c1;
        color: #257942;
        padding: 12px 16px;
        border-radius: 6px;
        margin-bottom: 1.5rem;
        font-size: 0.95rem;
    }

    table.min-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.95rem;
    }

    table.min-table th, table.min-table td {
        text-align: left;
        padding: 14px 10px;
        border-bottom: 1px solid #eee;
    }

    table.min-table th {
        background-color: #fafafa;
        font-weight: 600;
        color: #555;
    }

    table.min-table tr:hover {
        background-color: #f9f9f9;
    }

    .status {
        padding: 4px 8px;
        border-radius: 4px;
        background: #f0f0f0;
        font-size: 0.85rem;
        display: inline-block;
    }

    .image-thumb {
        width: 48px;
        height: 48px;
        object-fit: cover;
        border-radius: 4px;
        border: 1px solid #ddd;
        margin-right: 4px;
    }

    .image-container {
        display: flex;
        flex-wrap: wrap;
        gap: 4px;
    }

    .action-btn {
        background-color: #ff4d4f;
        border: none;
        padding: 6px 12px;
        color: #fff;
        border-radius: 4px;
        font-size: 0.85rem;
        cursor: pointer;
    }

    .action-btn:hover {
        background-color: #d9363e;
    }

    .empty-state {
        text-align: center;
        color: #888;
        padding: 2rem 0;
        font-style: italic;
    }

    .pagination {
        margin-top: 2rem;
    }
</style>

<h1 class="page-title">Manage Wishlists</h1>

@if(session('success'))
    <div class="success-message">{{ session('success') }}</div>
@endif

<table class="min-table">
    <thead>
        <tr>
            <th>Title</th>
            <th>Posted By</th>
            <th>Price Range</th>
            <th>Status</th>
            <th>Images</th>
            <th></th>
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
                <td><span class="status">{{ ucfirst($wishlist->status) }}</span></td>
                <td>
                    @if($wishlist->images->count())
                        <div class="image-container">
                            @foreach($wishlist->images as $image)
                                <img src="{{ asset('storage/' . $image->image_url) }}" alt="Image" class="image-thumb">
                            @endforeach
                        </div>
                    @else
                        <span style="color: #9d9a9a;">N/A</span>
                    @endif
                </td>
                <td>
                    <form action="{{ route('admin.wishlists.delete', $wishlist->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this wishlist?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="empty-state">No wishlists found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="pagination">
    {{ $wishlists->links() }}
</div>
@endsection
