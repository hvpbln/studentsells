@extends('layouts.layout')

@section('content')

<a href="{{ route('items.create') }}" class="btn btn-primary mb-3">Create New Listing</a>

<form method="GET" action="{{ route('items.index') }}" class="mb-3">
    <input type="text" name="search" class="form-control" placeholder="Search items..." value="{{ request('search') }}">
</form>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($items->count())
    @foreach($items as $item)
    <div class="card mb-4 shadow-sm position-relative card-display">
        <div class="card-body position-relative">
            {{-- Three-dot menu --}}
            <div class="dropdown">
                <div class="dropdown position-absolute top-0 end-0 m-2">
                    <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <strong>&#8942;</strong>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('items.show', $item->id) }}">View</a></li>
                        <li><a class="dropdown-item" href="{{ route('items.edit', $item->id) }}">Edit</a></li>
                        <li>
                            <form action="{{ route('items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf @method('DELETE')
                                <button class="dropdown-item text-danger" type="submit">Delete</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

            <h5 class="fw-bold">{{ $item->title }}
                <span class="badge bg-secondary">{{ $item->status }}</span>
            </h5>

            <p class="text-muted">{{ $item->description }}</p>
            <div class=list-img>
                @if($item->images->first())
                    <img src="{{ asset('storage/' . $item->images->first()->image_url) }}?v={{ time() }}"
                    class="img-fluid rounded mb-3 img-list">
                @endif
            </div>
        </div>
    </div>
@endforeach

@endif
@endsection
