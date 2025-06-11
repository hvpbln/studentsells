@extends('layouts.admin')

@section('title', 'Manage Listings')

@section('content')
<style>
    .page-title {
        font-size: 1.75rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        color: #333;
    }

    .alert-success {
        background-color: #e6ffed;
        border: 1px solid #b7f5c1;
        color: #257942;
        padding: 12px 16px;
        border-radius: 6px;
        margin-bottom: 1.5rem;
        font-size: 0.95rem;
    }

    table.clean-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.95rem;
    }

    table.clean-table th,
    table.clean-table td {
        text-align: left;
        padding: 14px 12px;
        border-bottom: 1px solid #eee;
        vertical-align: top;
    }

    table.clean-table th {
        background-color: #fafafa;
        color: #555;
        font-weight: 600;
    }

    table.clean-table tr:hover {
        background-color: #f9f9f9;
    }

    .img-thumbnail {
        border-radius: 6px;
        width: 60px;
        height: 60px;
        object-fit: cover;
    }

    .action-buttons form {
        display: inline-block;
        margin: 0;
    }

    .btn-delete {
        background-color: transparent;
        color: red;
        border: 1px solid red;
        padding: 6px 10px;
        border-radius: 4px;
        font-size: 0.85rem;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .btn-delete:hover {
        background-color: red;
        color: white;
    }

    .pagination {
        margin-top: 2rem;
        display: flex;
        justify-content: center;
    }
</style>

<h1 class="page-title">Manage Listings</h1>

@if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif

<table class="clean-table">
    <thead>
        <tr>
            <th>Title</th>
            <th>Posted By</th>
            <th>Description</th>
            <th>Price</th>
            <th>Status</th>
            <th>Images</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($items as $item)
            <tr>
                <td>{{ $item->title }}</td>
                <td>{{ $item->user->name ?? 'Unknown' }}</td>
                <td>{{ Str::limit($item->description, 50) }}</td>
                <td>${{ number_format($item->price, 2) }}</td>
                <td><strong>{{ ucfirst($item->status) }}</strong></td>
                <td>
                    @if($item->images->count())
                        <img src="{{ asset('storage/' . $item->images->first()->image_url) }}" alt="Image" class="img-thumbnail">
                    @else
                        <span style="color:#aaa;">N/A</span>
                    @endif
                </td>
                <td class="action-buttons">
                    <form action="{{ route('admin.listings.delete', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this listing?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="7" class="text-center" style="padding: 20px; color: #888;">No listings found.</td></tr>
        @endforelse
    </tbody>
</table>

<div class="pagination">
    {{ $items->links() }}
</div>

@endsection
