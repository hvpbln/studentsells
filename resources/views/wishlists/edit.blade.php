@extends('layouts.layout')

@section('content')
<h1>Edit Wishlist</h1>

<form method="POST" action="{{ route('wishlists.update', $wishlist->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
        <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $wishlist->title) }}" required maxlength="150">
        @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $wishlist->description) }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="price_range_min" class="form-label">Minimum Price</label>
            <input type="number" step="0.01" min="0" id="price_range_min" name="price_range_min" class="form-control @error('price_range_min') is-invalid @enderror" value="{{ old('price_range_min', $wishlist->price_range_min) }}">
            @error('price_range_min')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <label for="price_range_max" class="form-label">Maximum Price</label>
            <input type="number" step="0.01" min="0" id="price_range_max" name="price_range_max" class="form-control @error('price_range_max') is-invalid @enderror" value="{{ old('price_range_max', $wishlist->price_range_max) }}">
            @error('price_range_max')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="mb-3">
        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
        <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
            @foreach(['open', 'in negotiation', 'fulfilled', 'closed'] as $status)
                <option value="{{ $status }}" @selected(old('status', $wishlist->status) == $status)>{{ ucfirst($status) }}</option>
            @endforeach
        </select>
        @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="images" class="form-label">Upload Additional Images (optional)</label>
        <input type="file" id="images" name="images[]" multiple accept="image/*" class="form-control @error('images.*') is-invalid @enderror">
        @error('images.*')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        <div class="mt-3">
            <p>Current Images:</p>
            <div class="row">
                @foreach($wishlist->images as $image)
                    <div class="col-md-3 text-center mb-3">
                        <img src="{{ asset('storage/' . $image->image_url) }}" alt="Image" width="120" class="img-thumbnail mb-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="delete_images[]" value="{{ $image->id }}" id="delete_image_{{ $image->id }}">
                            <label class="form-check-label" for="delete_image_{{ $image->id }}">
                                Delete
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Update Wishlist</button>
    <a href="{{ route('wishlists.index') }}" class="btn btn-secondary ms-2">Cancel</a>
</form>
<br>
<br>
@endsection
