@extends('layouts.admin')

@section('title', 'Admin Dashboard')

<style>
    .logo2 {
            display: flex;
            align-items: center;
        }
    .div1 {
        margin: 100px 0 0 200px;
    }

    .logo-circle2 {
        width: 240px;
        height: 240px;
        background-color: #e6f49c;
        border-radius: 50%;
        margin-right: -80px;
        margin-right: -80px;
        padding-left: 10px;
    }

    .a {
        margin-left: 100px;
    }

    .logo-text2 {
        display: flex;
        align-items: baseline;
        font-size: 6.8em;
    }

    .logo-text2 .bold {
        font-family: 'Shrikhand', cursive;
        font-weight: normal;
    }

    .logo-text2 .script {
        font-family: 'Great Vibes', cursive;
        font-size: 1em;
        margin-left: 6px;
    }
</style>

@section('content')
    <div class="div1">
        <div class="logo2">
            <div class="logo-circle2"></div>
            <div class="logo-text2">
                <span class="bold">Student</span><span class="script">Sells</span>
            </div>
            
        </div>
            <h2 class="a">a user-friendly platform that enables students to buy and sell</h2>
    </div> 

@endsection
