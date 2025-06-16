@extends('layouts.guest')

@section('title', 'Welcome')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap');

    html, body {
        font-family: 'Montserrat', sans-serif;
        background-color: #d9dbf0;
        margin: 0;
        padding: 0;
        overflow: hidden;
        height: 100%;
    }

    .homepage-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        height: 70vh;
        justify-content: center;
        gap: 1.5rem;
        overflow: hidden;
    }

    .logo2 {
        position: relative;
        width: 300px;
        height: 180px;
        transform: translateX(-130px);
    }

    .logo-circle2 {
        position: absolute;
        width: 200px;
        height: 200px;
        background-color: #daf3a7;
        border-radius: 50%;
        left: 0;
        top: -10px;
        z-index: 1;
    }

    .logo-text2 {
        position: absolute;
        left: 75px;
        top: 45px;
        font-size: 5rem;
        z-index: 2;
        display: flex;
        align-items: baseline;
    }

    .logo-text2 .bold {
        font-family: 'Shrikhand', cursive;
        color: #333;
    }

    .logo-text2 .script {
        font-family: 'Great Vibes', cursive;
        font-size: 1em;
        margin-left: 6px;
        color: #333;
    }

    .homepage-subtitle {
        font-family: 'Montserrat', sans-serif;
        font-size: 1.5rem;
        color: #222;
        max-width: 90%;
    }

    .login-button {
        font-family: 'Montserrat', sans-serif;
        padding: 12px 48px;
        background-color: #8e9dcc;
        color: white;
        border-radius: 12px;
        font-size: 1.2rem;
        font-weight: 600;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .login-button:hover {
        background-color: #7a8abd;
    }

    .contact-link {
        font-family: 'Montserrat', sans-serif;
        text-decoration: none;
        color: #888;
        font-size: 1rem;
        margin-top: -0.5rem;
        display: inline-block;
    }

    nav a {
        font-family: 'Poppins', sans-serif;
    }
</style>

@section('content')
<div class="homepage-container">
    <div class="logo2">
        <div class="logo-circle2"></div>
        <div class="logo-text2">
            <span class="bold">Student</span><span class="script">Sells</span>
        </div>
    </div>

    <p class="homepage-subtitle">a user-friendly platform that enables students to buy and sell</p>

    <a href="{{ route('login.submit') }}" class="login-button">Log In</a>
    <a href="{{ url('/contactus') }}" class="contact-link">Contact Us</a>
</div>
@endsection