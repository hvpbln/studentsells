@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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
        overflow: hidden;
    }

    .left-section, .right-section {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 2rem;
        margin-top: -150px;
        overflow: hidden;
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
    .password-input {
        width: 100%;
        padding: 0.65rem 1rem;
        margin-bottom: 1.3rem;
        border: none;
        border-radius: 10px;
        background-color: #f1f1f1;
        font-size: 1rem;
        box-sizing: border-box;
    }

    input[type="password"]::-ms-reveal,
    input[type="password"]::-webkit-credentials-auto-fill-button {
        display: none !important;
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

    .password-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .password-wrapper input {
        padding-right: 2.5rem;
    }

    .toggle-password {
        position: absolute;
        right: 1rem;
        top: 33%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #666;
        font-size: 1.1rem;
        user-select: none;
        display: none;
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
                <div class="password-wrapper">
                    <input type="password" name="password" id="password" class="password-input" required>
                        <span class="toggle-password" id="togglePassword">
                            <i class="fa-solid fa-eye"></i>
                        </span>
                </div>

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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('togglePassword');
        const icon = toggleIcon.querySelector('i');
        let iconClicked = false;

        passwordInput.addEventListener('focus', () => {
            toggleIcon.style.display = 'block';
        });

        passwordInput.addEventListener('blur', () => {
            setTimeout(() => {
                if (!iconClicked && document.activeElement !== toggleIcon) {
                    toggleIcon.style.display = 'none';
                }
                iconClicked = false;
            }, 100);
        });

        toggleIcon.addEventListener('mousedown', () => {
            iconClicked = true;
        });

        toggleIcon.addEventListener('click', () => {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';

            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');

            passwordInput.focus();
        });
    });
</script>
@endsection