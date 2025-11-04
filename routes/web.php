<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\AbsensiController;

// ========================
// 🔹 Halaman Utama
// ========================
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ========================
// 🔹 Halaman Login
// ========================
Route::get('/login', function () {
    return view('login');
})->name('login');

// ========================
// 🔹 Proses Login
// ========================
Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        $user = Auth::user();

        // ✅ Tambahkan flash message biar SweetAlert bisa muncul
        session()->flash('success', 'Selamat datang, ' . $user->name . ' ');

        if ($user && $user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('home');
        }
    }

    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ]);
})->name('login.process');

// ========================
// 🔹 Logout
// ========================
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    // ✅ Flash message biar muncul SweetAlert di halaman login
    return redirect()->route('login')->with('logout_success', 'Anda telah logout dengan aman. Sampai jumpa lagi!');
})->name('logout');
// ========================
// 🔹 Halaman Admin Dashboard
// ========================
Route::get('/admin/dashboard', [AdminController::class, 'index'])
    ->middleware('isAdmin')
    ->name('admin.dashboard');


Route::resource('/admin/karyawan', KaryawanController::class)
    ->middleware('isAdmin')
    ->names([
        'index' => 'karyawan.index',
        'create' => 'karyawan.create',
        'store' => 'karyawan.store',
        'edit' => 'karyawan.edit',
        'update' => 'karyawan.update',
        'destroy' => 'karyawan.destroy',
    ]);

// 🔹 CRUD Data Karyawan
Route::middleware(['isAdmin'])->group(function () {
    Route::get('/admin/karyawan', [KaryawanController::class, 'index'])->name('karyawan.index');
    Route::get('/admin/karyawan/create', [KaryawanController::class, 'create'])->name('karyawan.create');
    Route::post('/admin/karyawan', [KaryawanController::class, 'store'])->name('karyawan.store');
    Route::get('/admin/karyawan/{id}/edit', [KaryawanController::class, 'edit'])->name('karyawan.edit');
    Route::put('/admin/karyawan/{id}', [KaryawanController::class, 'update'])->name('karyawan.update');
    Route::delete('/admin/karyawan/{id}', [KaryawanController::class, 'destroy'])->name('karyawan.destroy');
});

// ========================
// 🔹 CRUD Divisi
// ========================
use App\Http\Controllers\DivisiController;

Route::middleware(['isAdmin'])->group(function () {
    Route::resource('/admin/divisi', DivisiController::class);
    Route::get('/admin/divisi/{divisi}', [App\Http\Controllers\DivisiController::class, 'show'])->name('divisi.show');
});

// Absensi
Route::prefix('admin')->middleware(['isAdmin'])->group(function () {
    Route::resource('absensi', \App\Http\Controllers\AbsensiController::class);
});
Route::middleware(['isAdmin'])->group(function () {
    Route::resource('/admin/absensi', AbsensiController::class);
});




// ========================
// 🔹 Halaman About
// ========================
Route::get('/about', function () {
    return view('about');
})->name('about');
