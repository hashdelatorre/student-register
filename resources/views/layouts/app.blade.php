<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Registration System</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f8; margin: 0; color: #222; }
        nav { background: #1e3a8a; padding: 14px 24px; }
        nav a { color: #fff; margin-right: 18px; text-decoration: none; font-weight: bold; }
        nav a.active { text-decoration: underline; }
        .container { max-width: 1000px; margin: 24px auto; padding: 0 16px; }
        .card { background: #fff; border-radius: 8px; padding: 20px; margin-bottom: 24px; box-shadow: 0 1px 3px rgba(0,0,0,.1); }
        h1 { margin-top: 0; }
        label { display: block; margin: 10px 0 4px; font-size: 14px; }
        input, select { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 0 16px; }
        button { margin-top: 16px; background: #1e3a8a; color: #fff; border: 0; padding: 10px 20px; border-radius: 4px; cursor: pointer; }
        table { width: 100%; border-collapse: collapse; }
        th, td { text-align: left; padding: 10px; border-bottom: 1px solid #e5e7eb; font-size: 14px; }
        th { background: #f1f5f9; }
        .success { background: #dcfce7; color: #166534; padding: 10px; border-radius: 4px; margin-bottom: 16px; }
        .error { color: #b91c1c; font-size: 13px; margin: 4px 0 0; }
    </style>
</head>
<body>
    <nav>
    <a href="{{ route('students.index') }}" class="{{ request()->routeIs('students.*') ? 'active' : '' }}">Students</a>
    <a href="{{ route('departments.index') }}" class="{{ request()->routeIs('departments.*') ? 'active' : '' }}">Departments</a>
    <a href="{{ route('subjects.index') }}" class="{{ request()->routeIs('subjects.*') ? 'active' : '' }}">Subjects</a>
    <a href="{{ route('enrollments.index') }}" class="{{ request()->routeIs('enrollments.*') ? 'active' : '' }}">Enrollments</a>

    <span style="float:right; color:#fff;">
        {{ auth()->user()->name }}
        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
            @csrf
            <button type="submit" style="margin:0 0 0 12px; padding:6px 12px;">Logout</button>
        </form>
    </span>
</nav>
    <div class="container">
        @if (session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
    <div class="success" style="background:#fee2e2; color:#991b1b;">{{ session('error') }}</div>
@endif
        @yield('content')
    </div>
    @include('partials.no-double-click')
</body>
</html>