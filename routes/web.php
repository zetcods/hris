<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/login', function () {
    return view('login');
})->name('login');

// 🔹 Proses Login
Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        $user = Auth::user();

        if ($user && $user->role === 'admin') {
            return redirect('/admin/dashboard');
        } else {
            return redirect('/'); // user biasa ke home
        }
    }

    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ]);
})->name('login.process');

// 🔹 Logout
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

// 🔹 Halaman Admin Dashboard
Route::get('/admin/dashboard', [AdminController::class, 'index'])
    ->middleware('isAdmin')
    ->name('admin.dashboard');
