@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Shrikhand&family=Great+Vibes&display=swap');

    body {
        background-color: #d9dbf0;
        font-family: 'Montserrat', sans-serif;
    }

    .dashboard-logo-section {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        height: calc(100vh - 60px);
        text-align: center;
        gap: 1.5rem;
        margin-top: -100px;
    }

    .logo2 {
        position: relative;
        width: 360px;
        height: 160px;
        transform: translateX(-80px);
    }

    .logo-circle2 {
        position: absolute;
        width: 180px;
        height: 180px;
        background-color: #daf3a7;
        border-radius: 50%;
        left: 0;
        top: -10px;
        z-index: 1;
    }

    .logo-text2 {
        position: absolute;
        left: 65px;
        top: 40px;
        font-size: 4.2rem;
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
        font-size: 1.4rem;
        color: #222;
        max-width: 90%;
    }
</style>

<div class="dashboard-logo-section">
    <div class="logo2">
        <div class="logo-circle2"></div>
        <div class="logo-text2">
            <span class="bold">Student</span><span class="script">Sells</span>
        </div>
    </div>
    <p class="homepage-subtitle">a user-friendly platform that enables students to buy and sell</p>
</div>
@endsection
