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
        <textarea name="description" class="form-control">{{ old('description', $item->description) }}</textarea>
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
        <div class="mb-2">
            <label>Current Images:</label>
            <div class="d-flex flex-wrap">
                @foreach($item->images as $image)
                    <img src="{{ asset('storage/' . $image->image_url) }}" alt="Image" 
                         class="img-thumbnail me-2 mb-2" style="width: 120px;">
                @endforeach
            </div>
        </div>
    @endif

    <button class="btn btn-primary">Update</button>
</form>
@endsection
