@extends('layout')

@section('content')
<h1>Create New Wishlist</h1>

<form method="POST" action="{{ route('wishlists.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
        <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required maxlength="150">
        @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description') }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="price_range_min" class="form-label">Minimum Price</label>
            <input type="number" step="0.01" min="0" id="price_range_min" name="price_range_min" class="form-control @error('price_range_min') is-invalid @enderror" value="{{ old('price_range_min') }}">
            @error('price_range_min')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <label for="price_range_max" class="form-label">Maximum Price</label>
            <input type="number" step="0.01" min="0" id="price_range_max" name="price_range_max" class="form-control @error('price_range_max') is-invalid @enderror" value="{{ old('price_range_max') }}">
            @error('price_range_max')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="mb-3">
        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
        <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
            @foreach(['open', 'in negotiation', 'fulfilled', 'closed'] as $status)
                <option value="{{ $status }}" @selected(old('status') == $status)>{{ ucfirst($status) }}</option>
            @endforeach
        </select>
        @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="images" class="form-label">Upload Images (optional)</label>
        <input type="file" id="images" name="images[]" multiple accept="image/*" class="form-control @error('images.*') is-invalid @enderror">
        @error('images.*')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Create Wishlist</button>
    <a href="{{ route('wishlists.index') }}" class="btn btn-secondary ms-2">Cancel</a>
</form>
@endsection
