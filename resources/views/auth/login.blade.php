@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Shrikhand&family=Great+Vibes&display=swap');

    html, body {
        margin: 0;
        padding: 0;
        height: 100%;
        overflow: hidden;
        font-family: 'Montserrat', sans-serif;
        background-color: #d9dbf0;
    }

    .login-page {
        display: flex;
        height: calc(100vh - 60px);
        width: 100%;
    }

    .left-section, .right-section {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 2rem;
        margin-top: -150px;
    }

    .login-form-container {
        background-color: #e6e6f0;
        padding: 3rem;
        border-radius: 20px;
        width: 440px;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
        position: relative;
    }

    .back-link {
        position: absolute;
        top: 20px;
        left: 25px;
        font-size: 0.9rem;
        text-decoration: none;
        color: #555;
        font-weight: 600;
    }

    .login-form-container h2 {
        font-size: 2.4rem;
        font-weight: 700;
        margin-bottom: 0.3rem;
        color: #000;
        text-align: center;
    }

    .subtitle {
        color: #888;
        font-size: 0.95rem;
        text-align: center;
        margin-bottom: 2rem;
    }

    label {
        font-size: 0.85rem;
        font-weight: 600;
        letter-spacing: 1px;
        color: #555;
        margin-bottom: 0.3rem;
        display: block;
    }

    input[type="email"],
    input[type="password"] {
        width: 100%;
        padding: 0.65rem 1rem;
        margin-bottom: 1.3rem;
        border: none;
        border-radius: 10px;
        background-color: #f1f1f1;
        font-size: 1rem;
        box-sizing: border-box;
    }

    .form-button,
    .btn-register {
        width: 100%;
        padding: 0.75rem;
        font-size: 1rem;
        font-weight: bold;
        border-radius: 10px;
        display: inline-block;
        text-align: center;
        box-sizing: border-box;
        text-decoration: none;
        transition: background 0.3s ease;
    }

    .form-button {
        background-color: #8e9dcc;
        color: white;
        border: none;
        margin-top: 0.5rem;
    }

    .form-button:hover {
        background-color: #7a8abd;
    }

    .btn-register {
        background-color: #6b6e8b;
        color: white;
        border: none;
    }

    .btn-register:hover {
        background-color: #5a5d7a;
    }

    .or-divider {
        text-align: center;
        margin: 1.5rem 0 1rem;
        font-size: 0.85rem;
        color: #888;
    }

    .right-content-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        justify-content: center;
        gap: 1.5rem;
        height: 100%;
        width: 100%;
    }

    .logo2 {
        position: relative;
        width: 220px;
        height: 130px;
        transform: translateX(-80px);
    }

    .logo-circle2 {
        position: absolute;
        width: 150px;
        height: 150px;
        background-color: #daf3a7;
        border-radius: 50%;
        left: 0;
        top: -10px;
        z-index: 1;
    }

    .logo-text2 {
        position: absolute;
        left: 55px;
        top: 35px;
        font-size: 3.5rem;
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
        font-size: 1.25rem;
        color: #222;
        max-width: 90%;
    }

    .alert {
        font-size: 0.9rem;
        padding: 0.75rem 1rem;
        border-radius: 8px;
        margin-bottom: 1rem;
        text-align: left;
    }

    .alert.success {
        background-color: #d0f4c1;
        color: #2e7d32;
    }

    .alert.error {
        background-color: #fdecea;
        color: #c62828;
    }

    @media (max-width: 768px) {
        .login-page {
            flex-direction: column;
            height: auto;
        }

        .left-section, .right-section {
            width: 100%;
            padding: 2rem 1rem;
            margin-top: 0;
        }

        .right-section {
            order: -1;
        }
    }
</style>

<div class="login-page">
    <div class="left-section">
        <div class="login-form-container">
            <a class="back-link" href="{{ route('home') }}">← Back</a>
            <h2>Login</h2>
            <p class="subtitle">Log in to continue</p>

            @if(session('success'))
                <div class="alert success">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert error">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login.submit') }}">
                @csrf
                <label for="email">EMAIL</label>
                <input type="email" name="email" placeholder="user@students.nu-laguna.edu.ph" required autofocus>

                <label for="password">PASSWORD</label>
                <input type="password" name="password" required>

                <button type="submit" class="form-button">Log In</button>
            </form>

            <div class="or-divider">OR</div>

            <a href="{{ route('register') }}" class="btn-register">Create a new account</a>
        </div>
    </div>

    <div class="right-section">
        <div class="right-content-container">
            <div class="logo2">
                <div class="logo-circle2"></div>
                <div class="logo-text2">
                    <span class="bold">Student</span><span class="script">Sells</span>
                </div>
            </div>
            <p class="homepage-subtitle">a user-friendly platform that enables students to buy and sell</p>
        </div>
    </div>
</div>
@endsection