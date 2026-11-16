<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Registration System</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; min-height: 100vh; display: flex; align-items: center; justify-content: center;
               background: linear-gradient(135deg, #e0e7ff, #f4f6f8); font-family: Arial, sans-serif; }

        .auth { position: relative; width: 860px; max-width: 95%; min-height: 580px; background: #fff;
                border-radius: 18px; box-shadow: 0 20px 50px rgba(30,58,138,.2); overflow: hidden; }

        .form-box { position: absolute; top: 0; left: 0; width: 50%; height: 100%; padding: 0 44px;
                    display: flex; flex-direction: column; justify-content: center;
                    transition: all .6s ease-in-out; }
        .form-box h1 { margin: 0 0 6px; color: #1e3a8a; }
        .form-box .sub { margin: 0 0 16px; color: #64748b; font-size: 14px; }
        .form-box input[type="text"], .form-box input[type="email"], .form-box input[type="password"] {
            width: 100%; padding: 11px 12px; margin-bottom: 10px; border: 1px solid #d1d5db;
            border-radius: 8px; background: #f8fafc; font-size: 14px; }
        .form-box input:focus { outline: 2px solid #3b82f6; background: #fff; }
        .remember { font-size: 13px; color: #475569; margin-bottom: 4px; }
        .form-box button { margin-top: 12px; padding: 12px; border: 0; border-radius: 8px; background: #1e3a8a;
                           color: #fff; font-weight: bold; cursor: pointer; }
        .form-box button:disabled { opacity: .6; cursor: not-allowed; }
        .error { color: #b91c1c; font-size: 12px; margin: -4px 0 8px; }
        .alert { background: #fee2e2; color: #991b1b; padding: 8px 10px; border-radius: 8px; font-size: 13px; margin-bottom: 10px; }

        .login { z-index: 2; }
        .register { opacity: 0; z-index: 1; visibility: hidden; }
        .auth.active .login { transform: translateX(100%); opacity: 0; pointer-events: none; }
        .auth.active .register { transform: translateX(100%); opacity: 1; z-index: 5; visibility: visible; }

        .overlay-wrap { position: absolute; top: 0; left: 50%; width: 50%; height: 100%; overflow: hidden;
                        transition: transform .6s ease-in-out; z-index: 100; }
        .auth.active .overlay-wrap { transform: translateX(-100%); }
        .overlay { position: relative; left: -100%; width: 200%; height: 100%; color: #fff;
                   background: linear-gradient(135deg, #1e3a8a, #3b82f6); transition: transform .6s ease-in-out; }
        .auth.active .overlay { transform: translateX(50%); }

        .panel { position: absolute; top: 0; width: 50%; height: 100%; padding: 0 36px; text-align: center;
                 display: flex; flex-direction: column; align-items: center; justify-content: center;
                 transition: transform .6s ease-in-out; }
        .panel h2 { margin: 0 0 10px; }
        .panel p { font-size: 14px; line-height: 1.5; margin: 0 0 20px; }
        .panel-left { transform: translateX(-20%); }
        .auth.active .panel-left { transform: translateX(0); }
        .panel-right { right: 0; }
        .auth.active .panel-right { transform: translateX(20%); }
        .ghost { background: transparent; border: 2px solid #fff; color: #fff; padding: 10px 32px;
                 border-radius: 8px; font-weight: bold; cursor: pointer; }
    </style>
</head>
<body>
@php
    $le = $errors->getBag('login');
    $re = $errors->getBag('register');
@endphp

<div class="auth {{ $mode === 'register' ? 'active' : '' }}" id="auth">

    {{-- LOGIN FORM --}}
    <div class="form-box login">
        <form method="POST" action="{{ route('login.attempt') }}">
            @csrf
            <h1>Sign in</h1>
            <p class="sub">Welcome back! Please log in to continue.</p>

            @if (session('error')) <div class="alert">{{ session('error') }}</div> @endif

            <input type="email" name="email" placeholder="Email" value="{{ $mode === 'login' ? old('email') : '' }}">
            @if ($le->has('email')) <p class="error">{{ $le->first('email') }}</p> @endif

            <input type="password" name="password" placeholder="Password">
            @if ($le->has('password')) <p class="error">{{ $le->first('password') }}</p> @endif

            <label class="remember"><input type="checkbox" name="remember"> Remember me</label>
            <button type="submit">Sign in</button>
        </form>
    </div>

    {{-- REGISTER FORM --}}
    <div class="form-box register">
        <form method="POST" action="{{ route('register.store') }}">
            @csrf
            @include('partials.once')
            <h1>Create account</h1>
            <p class="sub">Fill in your details to register.</p>

            @if (session('error')) <div class="alert">{{ session('error') }}</div> @endif

            <input type="text" name="name" placeholder="Full name" value="{{ $mode === 'register' ? old('name') : '' }}">
            @if ($re->has('name')) <p class="error">{{ $re->first('name') }}</p> @endif

            <input type="email" name="email" placeholder="Email" value="{{ $mode === 'register' ? old('email') : '' }}">
            @if ($re->has('email')) <p class="error">{{ $re->first('email') }}</p> @endif

            <input type="password" name="password" placeholder="Password (min. 8 characters)">
            @if ($re->has('password')) <p class="error">{{ $re->first('password') }}</p> @endif

            <input type="password" name="password_confirmation" placeholder="Confirm password">
            <button type="submit">Sign up</button>
        </form>
    </div>

    {{-- SLIDING PANEL --}}
    <div class="overlay-wrap">
        <div class="overlay">
            <div class="panel panel-left">
                <h2>Already registered?</h2>
                <p>Log in with your account to manage students, subjects and enrollments.</p>
                <button type="button" class="ghost" id="goLogin">Sign in</button>
            </div>
            <div class="panel panel-right">
                <h2>New here?</h2>
                <p>Create an account and start using the Student Registration System.</p>
                <button type="button" class="ghost" id="goRegister">Sign up</button>
            </div>
        </div>
    </div>
</div>

<script>
    var auth = document.getElementById('auth');

    document.getElementById('goRegister').addEventListener('click', function () {
        auth.classList.add('active');
        history.replaceState(null, '', "{{ route('register') }}");
    });

    document.getElementById('goLogin').addEventListener('click', function () {
        auth.classList.remove('active');
        history.replaceState(null, '', "{{ route('login') }}");
    });
</script>
@include('partials.no-double-click')
</body>
</html>