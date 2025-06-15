<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'StudentSells')</title>
    <link href="https://fonts.googleapis.com/css2?family=Shrikhand&family=Great+Vibes&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">

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
            gap: 30px;
        }

        nav a {
            font-family: 'Montserrat', sans-serif;
            text-decoration: none;
            color: #333;
            font-weight: 500;
            font-size: 1.1em;
            transition: all 0.3s ease;
        }

        nav a.active {
            font-weight: bold;
        }

        nav a:hover {
            background-color: #f0f0f0;
            cursor: pointer;
        }

        .content {
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
        <nav>
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
            <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About Us</a>
            <a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'active' : '' }}">Login</a>
        </nav>
    </header>

    <div class="content">
        @yield('content')
    </div>
</body>
</html>