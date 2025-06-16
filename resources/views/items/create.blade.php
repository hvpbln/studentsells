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
        background-color: #ffffff;
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.05);
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
        background-color: #b4e88d;
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
</style>

<div class="container-custom">
    <div class="form-wrapper">
        <h2 class="form-title">
            <i class="bi bi-plus-circle me-2"></i>Create New Listing
        </h2>

        <form method="POST" action="{{ route('items.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- Title -->
            <div class="mb-3">
                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                <input type="text" id="title" name="title"
                       class="form-control @error('title') is-invalid @enderror"
                       value="{{ old('title') }}" required maxlength="150">
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="description"
                          class="form-control @error('description') is-invalid @enderror"
                          maxlength="1000" oninput="updateCharCount()" rows="4"
                          placeholder="Add more details here...">{{ old('description') }}</textarea>
                <small id="char-count" class="text-muted">1000 characters remaining</small>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Price -->
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" step="0.01" id="price" name="price"
                       class="form-control @error('price') is-invalid @enderror"
                       value="{{ old('price') }}">
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Status -->
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select id="status" name="status"
                        class="form-select @error('status') is-invalid @enderror">
                    @foreach(['Available', 'Reserved', 'Sold'] as $status)
                        <option value="{{ $status }}" @selected(old('status') == $status || $status == 'Available')>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Image Upload -->
            <div class="mb-3">
                <label for="images" class="form-label">Upload Images</label>
                <input type="file" id="images" name="images[]" multiple accept="image/*"
                       class="form-control @error('images.*') is-invalid @enderror">
                @error('images.*')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="d-flex mt-4">
                <button type="submit" class="btn btn-submit">
                    <i class="bi bi-upload me-1"></i>Create Listing
                </button>
                <a href="{{ route('items.index') }}" class="btn btn-cancel">
                    <i class="bi bi-x-circle me-1"></i>Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
