<!DOCTYPE html>
<html>
<head>
    <title>StudentSells</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="css/layout.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css ">
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
        
        .card-display {
            border-radius: 12px;
            overflow: visible;
        }
        
        .img-list {
            max-height: auto;
            object-fit: cover;
            width: 500px;
        }

        .list-img {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
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
            <a href="{{ route('student.dashboard') }}">Home</a>
            <a href="{{ route('items.index') }}">Shop</a>
            <a href="{{ route('wishlists.index') }}">Wishlist</a>
            <a href="#">Message</a>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
        </nav>

        <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
            @csrf
        </form>

        <div class="right-section">
        <div class="search-box">
            <div class="box">🔍</div>
        </div>
        <div class="icon"><a href="#">👤</a></div>
        </div>
    </header>
        <div class="container mt-4">
            
            @yield('content')
        </div>

<script src="js/navbar.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
