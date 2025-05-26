@extends('layouts.layout')

@section('content')
<h4>{{ $item->title }}</h4>
<p>Posted by: <strong>{{ $item->user->name }}</strong></p>
//<p>Posted by: {{ $item->user?->name ?? 'Guest' }}</p> ONLY USE IF HINDI MAACCESS YUNG LISTING (INDEX & SHOW)
<p>{{ $item->description }}</p>
<p>Price: ${{ $item->price }}</p>
<p>Status: <strong>{{ $item->status }}</strong></p>

@if($item->images->count())
    <div class="row">
        @foreach($item->images as $img)
            <div class="col-md-3">
                <img src="{{ asset('storage/' . $img->image_url) }}" class="img-fluid mb-2">
            </div>
        @endforeach
    </div>
@endif

<a href="{{ route('items.index') }}" class="btn btn-secondary">Back</a>
@endsection
