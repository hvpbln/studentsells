@extends('layouts.layout')

@section('content')
<style>
    body {
        background-color: #d9dbf0;
    }

    .container-custom {
        max-width: 720px;
        margin: 0 auto;
        padding: 30px 20px;
    }

    .form-wrapper {
        background-color: none;
        border-radius: 16px;
        padding: 30px;
        box-shadow: 4px 8px 16px 8px rgba(0,0,0,0.10);
    }

    .form-title {
        font-size: 1.75rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        color: #2f2f2f;
    }

    .form-label {
        font-weight: 500;
    }

    .btn-submit {
        background-color: #e6f49c;
        font-weight: 600;
        border-radius: 10px;
        border: none;
        color: #333;
        padding: 8px 16px;
    }

    .btn-cancel {
        border-radius: 10px;
        border: 1px solid #bbb;
        padding: 8px 16px;
        font-weight: 500;
        color: #444;
        margin-left: 10px;
    }

    .profile-img-preview {
        margin-top: 10px;
        border-radius: 8px;
    }

    .alert-success {
        margin-bottom: 1rem;
    }
</style>

<div class="container-custom">
    <div class="form-wrapper">
        <h2 class="form-title">
            <i class="bi bi-person-circle me-2"></i>Edit Profile
        </h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('student.profile.update') }}" enctype="multipart/form-data">
            @csrf

            <!-- Name -->
            <div class="mb-3">
                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">New Password</label>
                <input type="password" name="password" id="password"
                       class="form-control @error('password') is-invalid @enderror">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
            </div>

            <!-- Profile Photo -->
            <div class="mb-3">
                <label for="profile_photo" class="form-label">Profile Photo</label>
                <input type="file" name="profile_photo" id="profile_photo"
                       class="form-control @error('profile_photo') is-invalid @enderror">
                @error('profile_photo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                <div class="profile-img-preview mt-2">
                    <img src="{{ asset('storage/' . ($user->profile_photo ?? 'profile_photos/placeholder_pfp.jpg')) }}"
                         alt="Profile Photo" width="100">
                </div>

                @if($user->profile_photo && $user->profile_photo !== 'profile_photos/placeholder_pfp.jpg')
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" name="remove_profile_photo" id="remove_profile_photo" value="1">
                        <label class="form-check-label" for="remove_profile_photo">
                            Remove current profile photo
                        </label>
                    </div>
                @endif
            </div>

            <!-- Buttons -->
            <div class="d-flex">
                <button type="submit" class="btn btn-submit">
                    <i class="bi bi-save me-1"></i>Save Changes
                </button>
                <a href="{{ url()->previous() }}" class="btn btn-cancel">
                    <i class="bi bi-x-circle me-1"></i>Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection