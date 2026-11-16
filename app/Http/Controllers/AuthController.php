<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.auth', ['mode' => 'login']);
    }

    public function showRegister()
    {
        return view('auth.auth', ['mode' => 'register']);
    }

    public function login(Request $request)
    {
        $credentials = $request->validateWithBag('login', [
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // lock per email + IP (5 tries) and per IP alone (20 tries)
        $key   = Str::lower($credentials['email']) . '|' . $request->ip();
        $ipKey = 'login-ip|' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5) || RateLimiter::tooManyAttempts($ipKey, 20)) {
            $seconds = max(RateLimiter::availableIn($key), RateLimiter::availableIn($ipKey));

            return back()
                ->withErrors(['email' => "Too many login attempts. Try again in {$seconds} seconds."], 'login')
                ->onlyInput('email');
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            RateLimiter::clear($key);
            RateLimiter::clear($ipKey);
            $request->session()->regenerate();

            return redirect()->route('students.index');
        }

        RateLimiter::hit($key, 300);   // locked for 5 minutes after 5 failures
        RateLimiter::hit($ipKey, 300);

        $left = max(RateLimiter::remaining($key, 5), 0);

        return back()
            ->withErrors(['email' => "Incorrect email or password. {$left} attempt(s) left."], 'login')
            ->onlyInput('email');
    }

    public function register(Request $request)
    {
        $data = $request->validateWithBag('register', [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('students.index');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}