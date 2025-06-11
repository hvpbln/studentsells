@extends('layouts.admin')

@section('title', 'Manage Users')

@section('content')
<style>
    body {
        font-family: 'Segoe UI', Tahoma, sans-serif;
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
    }

    table.clean-table th {
        background-color: #fafafa;
        color: #555;
        font-weight: 600;
    }

    table.clean-table tr:hover {
        background-color: #f9f9f9;
    }

    .action-buttons form,
    .action-buttons a,
    .action-buttons button {
        display: inline-block;
        margin: 4px 4px 0 0;
    }

    .action-button {
        border: none;
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 0.85rem;
        cursor: pointer;
    }

    .approve {
        background-color: #28a745;
        color: white;
    }

    .approve[disabled] {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .ban {
        background-color: #dc3545;
        color: white;
    }

    .revoke {
        background-color: #ffc107;
        color: #333;
    }

    .delete {
        background-color: transparent;
        color: red;
        font-weight: bold;
        padding: 4px 6px;
        font-size: 0.85rem;
    }

    .view-posts {
        background-color: #8E9DCC;
        color: white;
        text-decoration: none;
        padding: 6px 10px;
        border-radius: 4px;
        font-size: 0.85rem;
    }

    .view-posts:hover {
        background-color: #7d84b2;
    }

    .back-link {
        margin-top: 2rem;
        text-align: center;
    }

    .dashboard-btn {
        display: inline-block;
        background-color: #8E9DCC;
        color: white;
        padding: 10px 20px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 500;
        transition: background-color 0.3s ease;
    }

    .dashboard-btn:hover {
        background-color: #7d84b2;
    }
</style>

<h1 class="page-title">Manage All Users</h1>

@if(session('success'))
    <div class="success-message">{{ session('success') }}</div>
@endif

<table class="clean-table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ ucfirst($user->status) }}</td>
                <td class="action-buttons">
                    @if($user->status === 'pending')
                        <form method="POST" action="{{ route('admin.users.updateStatus', $user->id) }}">
                            @csrf
                            <input type="hidden" name="status" value="active">
                            <button type="submit" class="action-button approve">Approve</button>
                        </form>
                    @elseif($user->status === 'active')
                        <button class="action-button approve" disabled>Approved</button>
                        <form method="POST" action="{{ route('admin.users.updateStatus', $user->id) }}">
                            @csrf
                            <input type="hidden" name="status" value="banned">
                            <button type="submit" class="action-button ban">Ban</button>
                        </form>
                    @elseif($user->status === 'banned')
                        <form method="POST" action="{{ route('admin.users.updateStatus', $user->id) }}">
                            @csrf
                            <input type="hidden" name="status" value="active">
                            <button type="submit" class="action-button revoke">Revoke Ban</button>
                        </form>
                    @endif

                    <form method="POST" action="{{ route('admin.users.delete', $user->id) }}" onsubmit="return confirm('Are you sure you want to delete this user?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-button delete">Delete</button>
                    </form>

                    <a href="{{ route('admin.users.posts', $user->id) }}" class="view-posts">View Posts</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="back-link">
    <a href="{{ route('admin.dashboard') }}" class="dashboard-btn">← Back to Dashboard</a>
</div>
@endsection
