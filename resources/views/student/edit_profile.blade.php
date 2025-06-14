@extends('layouts.layout')

@section('content')
<div class="container mt-4">
    <h2>Edit Profile</h2>

    @if(session('success'))
        <div class="alert alert-success mt-2">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('student.profile.update') }}" enctype="multipart/form-data" class="mt-4">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Name<span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            @error('name')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">New Password</label>
            <input type="password" name="password" class="form-control">
            @error('password')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm New Password</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

        <div class="mb-3">
            <label for="profile_photo" class="form-label">Profile Photo</label>
            <input type="file" name="profile_photo" class="form-control">
            @error('profile_photo')<small class="text-danger">{{ $message }}</small>@enderror

            @if ($user->profile_photo)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Profile Photo" width="100">
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>
@endsection
