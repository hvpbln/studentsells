@extends('layouts.layout')

@section('content')
<h1>Respond to Listing: {{ $item->title }}</h1>

<form method="POST" action="{{ route('items.sendresponse', $item->id) }}">
    @csrf

    <div class="mb-3">
        <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
        <textarea id="message" name="message" class="form-control @error('message') is-invalid @enderror" rows="4" required>{{ old('message') }}</textarea>
        @error('message')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Send Response</button>
    <a href="{{ route('items.show', $item->id) }}" class="btn btn-secondary ms-2">Cancel</a>
</form>
@endsection
