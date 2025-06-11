@extends('layouts.admin')

@section('title', 'Manage Users')

@section('content')
<style>
    h1 {
        text-align: center;
        margin-bottom: 20px;
    }

    .success-message {
        color: green;
        font-weight: bold;
        margin-bottom: 15px;
        text-align: center;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    th, td {
        padding: 12px;
        border: 1px solid #000000;
        text-align: left;
    }

    th {
        background-color: #f5f5f5;
    }

    .actions form,
    .actions a {
        display: inline-block;
        margin-right: 5px;
    }

    .actions button {
        padding: 6px 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .approve-btn {
        background-color: #28a745;
        color: white;
    }

    .approve-btn:hover {
        background-color: #1c7030;
    }

    .ban-btn {
        background-color: #dc3545;
        color: white;
    }

    .ban-btn:hover {
        background-color: #aa0617;
    }

    .revoke-btn {
        background-color: #ffc107;
        color: black;
    }

    .delete-btn {
        background-color: transparent;
        color: red;
        border: none;
        cursor: pointer;
    }

    .view-posts {
        background-color: #8E9DCC;
        color: white;
        padding: 6px 10px;
        text-decoration: none;
        border-radius: 4px;
    }

    .view-posts:hover {
        background-color: #7d84b2;
    }

    .back-link {
        display: block;
        text-align: center;
        margin-top: 20px;
    }

    .dashboard-btn {
        display: inline-block;
        background-color: #8E9DCC;
        color: white;
        padding: 8px 15px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }

    .dashboard-btn:hover {
        background-color: #7d84b2;
    }

</style>

<h1>Manage All Users</h1>

@if(session('success'))
    <div class="success-message">{{ session('success') }}</div>
@endif

<table>
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
                <td class="actions">
                    @if($user->status === 'pending')
                        <form method="POST" action="{{ route('admin.users.updateStatus', $user->id) }}">
                            @csrf
                            <input type="hidden" name="status" value="active">
                            <button type="submit" class="approve-btn">Approve</button>
                        </form>
                    @elseif($user->status === 'active')
                        <button class="approve-btn" disabled>Approved</button>
                        <form method="POST" action="{{ route('admin.users.updateStatus', $user->id) }}">
                            @csrf
                            <input type="hidden" name="status" value="banned">
                            <button type="submit" class="ban-btn">Ban</button>
                        </form>
                    @elseif($user->status === 'banned')
                        <form method="POST" action="{{ route('admin.users.updateStatus', $user->id) }}">
                            @csrf
                            <input type="hidden" name="status" value="active">
                            <button type="submit" class="revoke-btn">Revoke Ban</button>
                        </form>
                    @endif

                    <form method="POST" action="{{ route('admin.users.delete', $user->id) }}" onsubmit="return confirm('Are you sure you want to delete this user?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn">Delete</button>
                    </form>

                    <a href="{{ route('admin.users.posts', $user->id) }}" class="view-posts">View Posts</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<p class="back-link">
    <a href="{{ route('admin.dashboard') }}" class="dashboard-btn">← Back to Dashboard</a>
</p>

@endsection
