@extends('layouts.admin')

@section('title', 'Manage Listings')

@section('content')
<h1>Manage Listings</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
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
                        <img src="{{ asset('storage/' . $item->images->first()->image_url) }}" alt="Image" width="60" class="img-thumbnail">
                    @else
                        N/A
                    @endif
                </td>
                <td>
                    <form action="{{ route('admin.listings.delete', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this listing?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="7" class="text-center">No listings found.</td></tr>
        @endforelse
    </tbody>
</table>

{{ $items->links() }}

@endsection
