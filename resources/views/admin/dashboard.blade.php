<!DOCTYPE html>
<html>
<head><title>Admin Dashboard</title></head>
<body>
    <h1>Welcome, {{ auth()->user()->name }}</h1>
    <p><a href="{{ route('admin.manageUsers') }}">Manage Users</a></p>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>