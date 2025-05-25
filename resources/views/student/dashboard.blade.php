<!DOCTYPE html>
<html>
<head><title>Student Dashboard</title></head>
<body>
    <h1>Welcome, {{ auth()->user()->name }}</h1>
    <p>Your account status: {{ auth()->user()->status }}</p>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>