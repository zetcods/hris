<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\KaryawanDashboardController;

// Tambahan Controller Admin
use App\Http\Controllers\AdminCutiController;
use App\Http\Controllers\AdminIzinController;
use App\Http\Controllers\AdminLaporanController;
use App\Http\Controllers\PenggajianController; 

// Tambahan Controller Karyawan (PENTING BIAR GAK ERROR)
use App\Http\Controllers\KaryawanCutiController;

// ========================
// 🟢 Halaman Utama & Login
// ========================
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// =================================================================
// 🟢 DASHBOARD ADMIN (Wajib Login sebagai Admin / Karyawan Role Admin)
// =================================================================
Route::middleware(['auth:web,karyawan'])->prefix('admin')->group(function () { 

    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // CRUD Master Data
    Route::resource('/karyawan', KaryawanController::class);
    Route::resource('/divisi', DivisiController::class);
    
    // 🟠 RUTE PRINT ABSENSI (TARUH SEBELUM RESOURCE ABSENSI)
    Route::get('/absensi/print', [AbsensiController::class, 'print'])->name('absensi.print');
    
    Route::resource('/absensi', AbsensiController::class);

    // FITUR: CUTI ADMIN
    Route::get('/cuti', [AdminCutiController::class, 'index'])->name('admin.cuti'); 
    Route::get('/cuti/{id}/detail', [AdminCutiController::class, 'detail'])->name('admin.cuti.detail');
    Route::post('/cuti/{id}/approve', [AdminCutiController::class, 'approve'])->name('admin.cuti.approve');
    Route::post('/cuti/{id}/reject', [AdminCutiController::class, 'reject'])->name('admin.cuti.reject');

    // FITUR: IZIN / SAKIT ADMIN
    Route::get('/izin', [AdminIzinController::class, 'index'])->name('admin.izin');
    Route::get('/izin/{id}/detail', [AdminIzinController::class, 'detail'])->name('admin.izin.detail'); 
    Route::post('/izin/{id}/approve', [AdminIzinController::class, 'approve'])->name('admin.izin.approve');
    Route::post('/izin/{id}/reject', [AdminIzinController::class, 'reject'])->name('admin.izin.reject');

    // FITUR: LAPORAN MASALAH ADMIN
    Route::get('/laporan', [AdminLaporanController::class, 'index'])->name('admin.laporan.index'); 
    Route::get('/laporan/{id}/detail', [AdminLaporanController::class, 'detail'])->name('admin.laporan.detail'); 
    
    // RUTE POST UPDATE STATUS
    Route::post('/laporan/{id}/process', [AdminLaporanController::class, 'process'])->name('admin.laporan.process');
    Route::post('/laporan/{id}/done', [AdminLaporanController::class, 'done'])->name('admin.laporan.done');
    Route::post('/laporan/{id}/reject', [AdminLaporanController::class, 'reject'])->name('admin.laporan.reject'); 

    // FITUR: PENGGAJIAN
    Route::get('/penggajian', [PenggajianController::class, 'index'])->name('admin.penggajian.index');
    Route::post('/penggajian/generate', [PenggajianController::class, 'generate'])->name('admin.penggajian.generate');
    Route::get('/penggajian/{id}/slip', [PenggajianController::class, 'showSlip'])->name('admin.penggajian.slip');

    // FITUR: ADMIN PROFILE
    Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::post('/profile/update', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
    Route::post('/password/update', [AdminController::class, 'updatePassword'])->name('admin.password.update');
});


// ===========================================
// 🟢 DASHBOARD KARYAWAN (Wajib Login sebagai Karyawan)
// ===========================================
Route::middleware(['auth:karyawan'])->prefix('karyawan')->group(function () {

    // Dashboard
    Route::get('/dashboard', [KaryawanDashboardController::class, 'index'])->name('karyawan.dashboard');

    // Profile
    Route::get('/profile', [KaryawanDashboardController::class, 'profile'])->name('karyawan.profile');
    Route::post('/profile/update-info', [KaryawanDashboardController::class, 'updateInfo'])->name('karyawan.updateInfo');
    Route::post('/profile/update-password', [KaryawanDashboardController::class, 'updatePassword'])->name('karyawan.updatePassword');

    // Pengajuan Cuti (INI YANG SUDAH DIPERBAIKI)
    Route::get('/cuti', [KaryawanCutiController::class, 'index'])->name('karyawan.cuti');
    Route::post('/cuti/store', [KaryawanCutiController::class, 'store'])->name('karyawan.cuti.store');
    Route::delete('/cuti/{id}', [KaryawanCutiController::class, 'destroy'])->name('karyawan.cuti.destroy');

    // Pengajuan Izin
    Route::get('/izin', [KaryawanDashboardController::class, 'izin'])->name('karyawan.izin');
    Route::post('/izin/store', [KaryawanDashboardController::class, 'izinStore'])->name('karyawan.izin.store');
    Route::delete('/izin/{id}', [KaryawanDashboardController::class, 'izinDestroy'])->name('karyawan.izin.destroy');

    // Lapor Masalah
    Route::get('/lapor', [KaryawanDashboardController::class, 'lapor'])->name('karyawan.lapor');
    Route::post('/lapor/store', [KaryawanDashboardController::class, 'laporStore'])->name('karyawan.lapor.store');
    Route::delete('/lapor/{id}', [KaryawanDashboardController::class, 'laporDestroy'])->name('karyawan.lapor.destroy');
});

// Halaman About
Route::get('/about', function () {
    return view('about');
})->name('about');