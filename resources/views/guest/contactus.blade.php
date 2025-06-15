@extends('layouts.guest')

@section('title', 'Contact Us')

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

    .contact-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        justify-content: flex-start;
        height: 100vh;
        padding: 4rem 2rem 2rem 2rem;
    }

    .logo2 {
        position: relative;
        width: 300px;
        height: 180px;
        transform: translateX(-130px);
        margin-bottom: 2rem;
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

    .contact-title {
        font-size: 2rem;
        color: #333;
        margin-bottom: 1rem;
    }

    .contact-details {
        font-size: 1.1rem;
        color: #444;
        margin-bottom: 0.5rem;
    }

    .back-button {
        margin-top: 2rem;
        font-family: 'Montserrat', sans-serif;
        padding: 10px 30px;
        background-color: #8e9dcc;
        color: white;
        border-radius: 10px;
        text-decoration: none;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }

    .back-button:hover {
        background-color: #7a8abd;
    }
</style>

@section('content')
<div class="contact-container">
    <div class="logo2">
        <div class="logo-circle2"></div>
        <div class="logo-text2">
            <span class="bold">Student</span><span class="script">Sells</span>
        </div>
    </div>

    <h2 class="contact-title">Get in Touch With Us</h2>
    <p class="contact-details">📧 Email: support@studentsells.com</p>
    <p class="contact-details">📞 Phone: (123) 456-7890</p>
    <p class="contact-details">📍 Address: Calamba, Laguna</p>

    <a href="{{ route('home') }}" class="back-button">Back to Home</a>
</div>
@endsection