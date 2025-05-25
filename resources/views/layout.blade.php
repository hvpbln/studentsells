<!DOCTYPE html>
<html>
<head>
    <title>StudentSells</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('items.index') }}" class="btn btn-success">Listings</a>
        <a href="{{ route('wishlists.index') }}" class="btn btn-success">Wishlists</a>
    </div>
    @yield('content')
</div>
</body>
</html>

