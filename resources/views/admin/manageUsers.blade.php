@extends('layouts.admin')

@section('title', 'Manage Users')

@section('content')
<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
</head>
<body>
    <h1>Manage All Users</h1>

    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    <table border="1" cellpadding="5" cellspacing="0">
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
                    <td>
                        @if($user->status === 'pending')
                            <form method="POST" action="{{ route('admin.users.updateStatus', $user->id) }}" style="display:inline;">
                                @csrf
                                <input type="hidden" name="status" value="active">
                                <button type="submit">Approve</button>
                            </form>
                        @elseif($user->status === 'active')
                            <button disabled>Approved</button>
                            <form method="POST" action="{{ route('admin.users.updateStatus', $user->id) }}" style="display:inline;">
                                @csrf
                                <input type="hidden" name="status" value="banned">
                                <button type="submit">Ban</button>
                            </form>
                        @elseif($user->status === 'banned')
                            <form method="POST" action="{{ route('admin.users.updateStatus', $user->id) }}" style="display:inline;">
                                @csrf
                                <input type="hidden" name="status" value="active">
                                <button type="submit">Revoke Ban</button>
                            </form>
                        @endif
                            <form method="POST" action="{{ route('admin.users.delete', $user->id) }}" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="color: red; background: none; border: none; cursor: pointer;">Delete</button>
                            </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p><a href="{{ route('admin.dashboard') }}">Back to Dashboard</a></p>
</body>
</html>
@endsection
