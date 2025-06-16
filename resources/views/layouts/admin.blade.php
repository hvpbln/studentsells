<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Dashboard')</title>

    {{-- External Fonts & Styles --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Shrikhand&family=Great+Vibes&family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css ">

    <style>
        body {
            margin: 0;
            font-family: 'Montserrat', sans-serif;
            background-color: #d9dbf0;
        }

        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 30px;
            background-color: #e6e6f0;
            border-bottom: 1px solid #ccc;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo-circle {
            width: 60px;
            height: 60px;
            background-color: #daf3a7;
            border-radius: 50%;
            margin-right: -30px;
            padding-left: 10px;
        }

        .logo-text {
            display: flex;
            align-items: baseline;
            font-size: 1.8em;
        }

        .logo-text .bold {
            font-family: 'Shrikhand', cursive;
            font-weight: normal;
        }

        .logo-text .script {
            font-family: 'Great Vibes', cursive;
            font-size: 1em;
            margin-left: 6px;
        }

        nav {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        nav a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            font-size: 1.1em;
            transition: all 0.3s ease;
        }

        nav a.active {
            font-weight: 700;
        }

        nav a:hover {
            background-color: #f0f0f0;
            cursor: pointer;
        }

        .right-section {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .icon {
            width: 40px;
            height: 40px;
            border: 2px solid #aaa;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .tab-content {
            padding: 2rem;
        }
    </style>

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

<header>
    <div class="logo">
        <div class="logo-circle"></div>
        <div class="logo-text">
            <span class="bold">Student</span><span class="script">Sells</span>
        </div>
    </div>

    <nav>
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
        <a href="{{ route('admin.manageUsers') }}" class="{{ request()->routeIs('admin.manageUsers') ? 'active' : '' }}">Users</a>
        <a href="{{ route('admin.listings') }}" class="{{ request()->routeIs('admin.listings') ? 'active' : '' }}">Listings</a>
        <a href="{{ route('admin.wishlists') }}" class="{{ request()->routeIs('admin.wishlists') ? 'active' : '' }}">Wishlists</a>
        <a href="{{ route('admin.responses') }}" class="{{ request()->routeIs('admin.responses') ? 'active' : '' }}">Responses</a>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
    </nav>

    <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
        @csrf
    </form>

    <div class="right-section">
        {{-- Optional admin profile icon here --}}
    </div>
</header>

<div class="container mt-4">
    @yield('content')
</div>

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
