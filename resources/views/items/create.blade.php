@extends('layouts.layout')

@section('content')
<h4>Create New Listing</h4>

<form method="POST" action="{{ route('items.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="mb-2"><input type="text" name="title" class="form-control" placeholder="Title" required></div>
    <div class="mb-2">
        <textarea 
            name="description" 
            class="form-control" 
            id="description" 
            maxlength="1000" 
            placeholder="Description" 
            oninput="updateCharCount()"
        >{{ old('description') }}</textarea>
        <small id="char-count" class="text-muted">1000 characters remaining</small>
    </div>
    <div class="mb-2"><input type="number" name="price" step="0.01" class="form-control" placeholder="Price"></div>
    <div class="mb-2">
        <select name="status" class="form-control">
            <option value="Available" selected>Available</option>
            <option value="Reserved">Reserved</option>
            <option value="Sold">Sold</option>
        </select>
    </div>
    <div class="mb-2"><input type="file" name="images[]" multiple class="form-control"></div>
    <button class="btn btn-success">Create</button>
</form>
@endsection
