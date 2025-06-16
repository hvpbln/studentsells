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

    .img-thumbnail {
        border-radius: 12px;
    }
</style>

<div class="container-custom">
    <div class="form-wrapper">
        <h2 class="form-title">
            <i class="bi bi-pencil-square me-2"></i>Edit Listing
        </h2>

        <form method="POST" action="{{ route('items.update', $item->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div class="mb-3">
                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                <input type="text" id="title" name="title"
                       class="form-control @error('title') is-invalid @enderror"
                       value="{{ old('title', $item->title) }}" required maxlength="150">
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="description"
                          class="form-control @error('description') is-invalid @enderror"
                          maxlength="1000" oninput="updateCharCount()" rows="4">{{ old('description', $item->description) }}</textarea>
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
                       value="{{ old('price', $item->price) }}">
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Status -->
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select id="status" name="status" class="form-select @error('status') is-invalid @enderror">
                    @foreach(['Available', 'Reserved', 'Sold'] as $status)
                        <option value="{{ $status }}" @selected(old('status', $item->status) == $status)>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- New Images -->
            <div class="mb-3">
                <label for="images" class="form-label">Upload New Images (optional)</label>
                <input type="file" id="images" name="images[]" multiple accept="image/*"
                       class="form-control @error('images.*') is-invalid @enderror">
                @error('images.*')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Existing Images -->
            @if($item->images->count())
                <div class="mt-4">
                    <p class="fw-bold">Current Images:</p>
                    <div class="row">
                        @foreach($item->images as $image)
                            <div class="col-md-3 text-center mb-3">
                                <img src="{{ asset('storage/' . $image->image_url) }}" alt="Image"
                                     width="120" class="img-thumbnail mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                           name="delete_images[]" value="{{ $image->id }}"
                                           id="delete_image_{{ $image->id }}">
                                    <label class="form-check-label" for="delete_image_{{ $image->id }}">
                                        Delete
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Buttons -->
            <div class="d-flex mt-4">
                <button type="submit" class="btn btn-submit">
                    <i class="bi bi-save me-1"></i>Update Listing
                </button>
                <a href="{{ route('items.index') }}" class="btn btn-cancel">
                    <i class="bi bi-x-circle me-1"></i>Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
