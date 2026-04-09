<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('kasir.dashboard');
    }

    return redirect()->route('login');
});

// Login
Route::get('/login', function () {
    if (Auth::check()) {
        return redirect()->route('kasir.dashboard');
    }
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');

// Register
Route::get('/register', function () {
    if (Auth::check()) {
        return redirect()->route('kasir.dashboard');
    }
    return view('auth.register');
})->name('register');

Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');

Route::post('/admin/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required', 'string'],
    ]);

    if (! Auth::attempt($credentials, $request->boolean('remember'))) {
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    $request->session()->regenerate();

    return redirect()->intended('/admin');
})->name('admin.login.store');

Route::post('/finance/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required', 'string'],
    ]);

    if (! Auth::attempt($credentials, $request->boolean('remember'))) {
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    $request->session()->regenerate();

    return redirect()->intended('/finance');
})->name('finance.login.store');

Route::middleware('auth')->get('/kasir', function () {
    return view('kasir.dashboard');
})->name('kasir.dashboard');

// Logout
Route::match(['post', 'get'], '/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// Dashboard
Route::middleware('auth')->get('/dashboard', function () {
    return redirect()->route('kasir.dashboard');
})->name('dashboard');
