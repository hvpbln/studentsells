@extends('layouts.guest')

@section('title', 'About Us')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Shrikhand&family=Great+Vibes&display=swap');

    html, body {
        font-family: 'Montserrat', sans-serif;
        background-color: #d9dbf0;
        margin: 0;
        padding: 0;
        overflow: hidden;
        height: 100%;
    }

    .about-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        justify-content: flex-start;
        height: 100vh;
        padding: 3.5rem 2rem 2rem 2rem;
        gap: 1.2rem;
    }

    .about-label {
        position: absolute;
        top: 40px;
        left: 30px;
        font-family: 'Great Vibes', cursive;
        font-size: 2.2rem;
        color: #555;
        z-index: 2;
        transform: rotate(-5deg);
    }

    .logo2 {
        position: relative;
        width: 300px;
        height: 180px;
        transform: translateX(-130px);
        margin-bottom: 1rem;
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

    .about-description {
        font-size: 1.2rem;
        color: #444;
        line-height: 2rem;
        max-width: 700px;
        margin-top: 1rem;
    }

    .back-button {
        margin-top: 2rem;
        font-family: 'Montserrat', sans-serif;
        padding: 12px 36px;
        background-color: #8e9dcc;
        color: white;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        font-size: 1rem;
        transition: background-color 0.3s ease;
    }

    .back-button:hover {
        background-color: #7a8abd;
    }
</style>

@section('content')
<div class="about-container">

    <div class="logo2">
        <div class="about-label">About</div>
        <div class="logo-circle2"></div>
        <div class="logo-text2">
            <span class="bold">Student</span><span class="script">Sells</span>
        </div>
    </div>

    <p class="about-description">
        StudentSells is a user-friendly platform designed to empower students in buying and selling items within their academic communities.
        Whether you're looking to sell pre-loved textbooks, gadgets, dorm essentials, or simply find great deals on what you need, 
        StudentSells provides a safe and convenient environment to connect with fellow students. 
        We believe in sustainability, affordability, and student-to-student support.
    </p>

    <a href="{{ route('home') }}" class="back-button">Back to Home</a>
</div>
@endsection