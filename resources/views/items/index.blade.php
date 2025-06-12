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
            @auth
                @if(auth()->id() === $item->user_id)
                    <div class="dropdown position-absolute top-0 end-0 m-2">
                        <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <strong>&#8942;</strong>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('items.edit', $item->id) }}">Edit</a></li>
                            <li>
                                <form action="{{ route('items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                    @csrf @method('DELETE')
                                    <button class="dropdown-item text-danger" type="submit">Delete</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endif
            @endauth

            <h5 class="fw-bold">{{ $item->title }}
                <span class="badge bg-secondary">{{ $item->status }}</span>
            </h5>

            <p>Posted by 
                <strong>
                    <a href="{{ route('users.show', $item->user_id) }}">
                        {{ $item->user->name ?? 'Unknown' }}
                    </a>
                </strong>
            </p>
            <p class="text-muted">{{ $item->description }}</p>

            <div class=list-img>
                @if($item->images->count())
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        @foreach($item->images as $image)
                            <img src="{{ asset('storage/' . $image->image_url) }}?v={{ time() }}"
                                class="img-fluid rounded img-list"
                                style="width: 200px; height: auto;">
                        @endforeach
                    </div>
                @endif
            </div>
            <a href="{{ route('items.show', $item->id) }}" class="btn btn-outline-primary mt-2">View Listing</a>
            <a href="{{ route('items.respond', $item->id) }}" class="btn btn-primary mt-2">Respond to Listing</a>
        </div>
    </div>
@endforeach

@elseif(request('search'))
    <div class="alert alert-warning">
        No results found for "{{ request('search') }}".
    </div>
@else
    <div class="alert alert-info">
        No items have been listed yet.
    </div>
@endif
@endsection
