@extends('layouts.guest')

@section('title', 'Register')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Shrikhand&family=Great+Vibes&display=swap');

    html, body {
        margin: 0;
        padding: 0;
        height: 100%;
        font-family: 'Montserrat', sans-serif;
        background-color: #d9dbf0;
        overflow: hidden;
    }

    .register-page {
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
    }

    .register-form-container {
        background-color: #e6e6f0;
        padding: 3rem;
        border-radius: 20px;
        width: 440px;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
        position: relative;
    }

    .register-form-container.error-present {
        margin-top: 75px;
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

    h2 {
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

    input[type="text"],
    input[type="email"],
    input[type="password"] {
        width: 100%;
        padding: 0.65rem 1rem;
        margin-bottom: 1.2rem;
        border: none;
        border-radius: 10px;
        background-color: #f1f1f1;
        font-size: 1rem;
        box-sizing: border-box;
    }

    .photo-upload {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .photo-preview {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #999;
    }

    .custom-file-input {
        background-color: #daf3a7;
        color: #333;
        padding: 0.5rem 1rem;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 600;
        font-size: 0.95rem;
        border: none;
        transition: background-color 0.3s ease;
    }

    .custom-file-input:hover {
        background-color: #c9e997;
    }

    input[type="file"] {
        display: none;
    }

    .form-button {
        width: 100%;
        padding: 0.75rem;
        font-size: 1rem;
        font-weight: bold;
        border-radius: 10px;
        background-color: #8e9dcc;
        color: white;
        border: none;
        transition: background 0.3s ease;
    }

    .form-button:hover {
        background-color: #7a8abd;
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

    .alert.error {
        background-color: #fdecea;
        color: #c62828;
    }

    @media (max-width: 768px) {
        .register-page {
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

        .right-content-container {
            padding-top: 20px;
        }
    }
</style>

<div class="register-page">
    <div class="left-section">
        <div class="register-form-container {{ $errors->any() ? 'error-present' : '' }}">
            <a class="back-link" href="{{ route('login') }}">← Back</a>
            <h2>Create new account</h2>
            <p class="subtitle">Create account to continue</p>

            @if($errors->any())
                <div class="alert error">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.submit') }}" enctype="multipart/form-data">
                @csrf

                <label for="name">USERNAME</label>
                <input type="text" name="name" required placeholder="username">

                <label for="email">EMAIL</label>
                <input type="email" name="email" required placeholder="user@students.nu-laguna.edu.ph">

                <label for="password">PASSWORD</label>
                <input type="password" name="password" required>

                <label for="password_confirmation">CONFIRM PASSWORD</label>
                <input type="password" name="password_confirmation" required>

                <label for="profile_photo">PROFILE PHOTO</label>
                <div class="photo-upload">
                    <img id="photo-preview" class="photo-preview" src="{{ asset('storage/profile_photos/placeholder_pfp.jpg') }}" alt="Profile preview">
                    <label for="profile_photo" class="custom-file-input">Select Profile Picture</label>
                    <input type="file" name="profile_photo" id="profile_photo" accept="image/*" onchange="previewPhoto(event)">
                </div>

                <button type="submit" class="form-button">Create account</button>
            </form>
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
    function previewPhoto(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('photo-preview');
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection