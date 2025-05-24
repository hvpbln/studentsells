@extends('layout')

@section('content')
<h4>Edit Listing</h4>

<form method="POST" action="{{ route('items.update', $item->id) }}">
    @csrf @method('PUT')
    <div class="mb-2"><input type="text" name="title" class="form-control" value="{{ $item->title }}"></div>
    <div class="mb-2"><textarea name="description" class="form-control">{{ $item->description }}</textarea></div>
    <div class="mb-2"><input type="number" name="price" step="0.01" class="form-control" value="{{ $item->price }}"></div>
    <div class="mb-2">
        <select name="status" class="form-control">
            @foreach(['Available', 'Reserved', 'Sold'] as $status)
                <option value="{{ $status }}" @if($item->status == $status) selected @endif>{{ $status }}</option>
            @endforeach
        </select>
    </div>
    <button class="btn btn-primary">Update</button>
</form>
@endsection
