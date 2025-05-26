<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Admin Dashboard')</title>
    <style>
        body { font-family: Arial, sans-serif; }
        nav { margin-bottom: 20px; }
        nav a { margin-right: 15px; text-decoration: none; }
        .tab-content { margin-top: 20px; }
        .danger { color: red; }
    </style>
</head>
<body>
    <br>
    <nav>
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a href="{{ route('admin.manageUsers') }}">Manage Users</a>
        <a href="{{ route('admin.listings') }}">Manage Listings</a>
        <a href="{{ route('admin.wishlists') }}">Manage Wishlists</a>
        <a href="{{ route('admin.responses') }}">Manage Responses</a>
    </nav>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
    <div class="tab-content">
        @yield('content')
    </div>
</body>
</html>
