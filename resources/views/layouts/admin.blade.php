<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Dashboard')</title>

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Shrikhand&family=Great+Vibes&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: sans-serif;
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
            background-color: #e6f49c;
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

        .nav-wrapper {
            flex: 1;
            display: flex;
            justify-content: center;
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

        .search-box {
            display: flex;
            align-items: center;
            background-color: #d9dbf0;
            padding: 5px 15px;
            border-radius: 20px;
        }

        .search-box input {
            border: none;
            background: transparent;
            outline: none;
            padding-left: 100px;
        }

        .icon {
            width: 30px;
            height: 30px;
            border: 2px solid #aaa;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .box {
            width: 150px;
            height: 30px;
            border-radius: 10%;
        }

        .tab-content {
            padding: 2rem;
        }
    </style>
</head>
<body>
<header>
    <div class="logo">
        <div class="logo-circle"></div>
        <div class="logo-text">
            <span class="bold">Student</span><span class="script">Sells</span>
        </div>
    </div>

    <div class="nav-wrapper">
        <nav>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('admin.manageUsers') }}" class="{{ request()->routeIs('admin.manageUsers') ? 'active' : '' }}">Users</a>
            <a href="{{ route('admin.listings') }}" class="{{ request()->routeIs('admin.listings') ? 'active' : '' }}">Listings</a>
            <a href="{{ route('admin.wishlists') }}" class="{{ request()->routeIs('admin.wishlists') ? 'active' : '' }}">Wishlists</a>
            <a href="{{ route('admin.responses') }}" class="{{ request()->routeIs('admin.responses') ? 'active' : '' }}">Responses</a>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
        </nav>
    </div>

    <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
        @csrf
    </form>
</header>


<div class="tab-content">
    @yield('content')
</div>

</body>
</html>
