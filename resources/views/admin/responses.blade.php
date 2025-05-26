@extends('layouts.admin')

@section('title', 'Manage Wishlist Responses')

@section('content')
<h1>Manage Wishlist Responses</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

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
        @forelse($responses as $response)
            <tr>
                <td>{{ $response->user->name ?? 'Unknown' }}</td>
                <td>{{ $response->wishlist->title ?? 'Deleted Wishlist' }}</td>
                <td>{{ Str::limit($response->message, 50) }}</td>
                <td>
                    @if($response->offer_price)
                        ${{ number_format($response->offer_price, 2) }}
                    @else
                        N/A
                    @endif
                </td>
                <td>{{ $response->created_at->format('M d, Y H:i') }}</td>
                <td>
                    <form action="{{ route('admin.responses.delete', $response->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this response?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-center">No responses found.</td></tr>
        @endforelse
    </tbody>
</table>

{{ $responses->links() }}

@endsection
