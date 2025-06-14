@extends('layouts.layout')

@section('content')
<h4>Edit Listing</h4>

<form method="POST" action="{{ route('items.update', $item->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-2">
        <input type="text" name="title" class="form-control" value="{{ old('title', $item->title) }}" required>
    </div>

    <div class="mb-2">
        <textarea name="description" class="form-control" id="description" maxlength="1000" oninput="updateCharCount()">{{ old('description', $item->description) }}</textarea>
        <small id="char-count" class="text-muted">1000 characters remaining</small>
    </div>


    <div class="mb-2">
        <input type="number" name="price" step="0.01" class="form-control" value="{{ old('price', $item->price) }}">
    </div>

    <div class="mb-2">
        <select name="status" class="form-control">
            @foreach(['Available', 'Reserved', 'Sold'] as $status)
                <option value="{{ $status }}" @if($item->status == $status) selected @endif>{{ $status }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-2">
        <label>Upload New Images (optional)</label>
        <input type="file" name="images[]" multiple class="form-control">
    </div>

    @if($item->images->count())
        <h5>Current Images:</h5>
        <div class="d-flex flex-wrap gap-3 mb-4">
            @foreach($item->images as $image)
                <div class="position-relative" style="width: 120px;">
                    <img src="{{ asset('storage/' . $image->image_url) }}" class="img-fluid rounded" style="width: 100%; height: auto;">
                    <label class="me-3">
                        <input type="checkbox" name="delete_images[]" value="{{ $image->id }}">
                        Delete
                    </label>
                </div>
            @endforeach
        </div>
    @endif

    <button class="btn btn-primary">Update</button>
</form>
@endsection
