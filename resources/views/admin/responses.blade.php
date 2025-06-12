@extends('layouts.admin')

@section('title', 'Manage All Responses')

@section('content')

<style>
    .page-title {
        font-size: 1.75rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        color: #333;
    }

    .section-title {
        font-size: 1.25rem;
        margin-top: 2rem;
        margin-bottom: 1rem;
        color: #444;
        border-left: 4px solid #8E9DCC;
        padding-left: 10px;
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
        margin-bottom: 2rem;
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

    .text-center {
        text-align: center;
        color: #999;
        padding: 1.5rem;
    }

    .tab-buttons {
        margin-bottom: 1rem;
    }

    .tab-buttons button {
        padding: 10px 16px;
        margin-right: 10px;
        border: 1px solid #ccc;
        background-color: #f1f1f1;
        color: #333;
        cursor: pointer;
        border-radius: 4px;
        font-size: 0.95rem;
    }

    .tab-buttons button.active {
        background-color: #8E9DCC;
        color: white;
    }
</style>

<h1 class="page-title">Manage All Responses</h1>

@if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif

{{-- Tab Buttons --}}
<div class="tab-buttons">
    <button class="active" onclick="showTab('listing')">Listing Responses</button>
    <button onclick="showTab('wishlist')">Wishlist Responses</button>
</div>

{{-- Listing Responses Tab --}}
<div id="listing-tab">
    <h3 class="section-title">Listing Responses</h3>
    <table class="clean-table">
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
                            <button class="btn-delete">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center">No listing responses found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Wishlist Responses Tab --}}
<div id="wishlist-tab" style="display:none;">
    <h3 class="section-title">Wishlist Responses</h3>
    <table class="clean-table">
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
                            <button class="btn-delete">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center">No wishlist responses found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
    function showTab(tab) {
        document.getElementById('wishlist-tab').style.display = (tab === 'wishlist') ? 'block' : 'none';
        document.getElementById('listing-tab').style.display = (tab === 'listing') ? 'block' : 'none';

        const buttons = document.querySelectorAll('.tab-buttons button');
        buttons.forEach(btn => btn.classList.remove('active'));
        if (tab === 'wishlist') buttons[1].classList.add('active');
        if (tab === 'listing') buttons[0].classList.add('active');
    }
</script>

@endsection
