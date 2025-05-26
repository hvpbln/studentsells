@extends('layouts.layout')

@section('content')

<a href="{{ route('items.create') }}" class="btn btn-primary mb-3">Create New Listing</a>

<form method="GET" action="{{ route('items.index') }}" class="mb-3">
    <input type="text" name="search" class="form-control" placeholder="Search items..." value="{{ request('search') }}">
</form>

@foreach($items as $item)
    <div class="card mb-3">
        <div class="card-body">
            <h5>
                {{ $item->title }} 
                <span class="badge bg-secondary">{{ $item->status }}</span>
            </h5>
            <p class="mb-1">Posted by: <strong>{{ $item->user->name }}</strong></p>
            <p>{{ $item->description }}</p>
            <a href="{{ route('items.show', $item->id) }}" class="btn btn-sm btn-info">View</a>

            @if(Auth::id() === $item->user_id)
                <a href="{{ route('items.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('items.destroy', $item->id) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Delete</button>
                </form>
            @endif
        </div>
    </div>
@endforeach

<form method="POST" action="{{ route('logout') }}" class="mb-3 text-end">
    @csrf
    <button type="submit" class="btn btn-danger">Logout</button>
</form>

@endsection
