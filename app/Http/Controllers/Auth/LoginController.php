<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Karyawan;
use App\Models\Divisi; 

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        $login = $request->login;
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'nik';

        // ============================
        // LOGIN ADMIN (EMAIL)
        // ============================
        if ($field === 'email') {
            if (Auth::guard('web')->attempt([
                'email' => $login,
                'password' => $request->password
            ], $request->remember)) {
                return redirect('/admin/dashboard')
                    ->with('success', 'Berhasil login sebagai Admin');
            }
        }

        // ============================
        // LOGIN KARYAWAN (NIK / CEK ROLE DIVISI)
        // ============================
        if ($field === 'nik') {

            // Cari user dan eager load divisinya
            $karyawan = Karyawan::with('divisi')->where('nik', $login)->first();

            if (!$karyawan) {
                return back()->with('error', 'NIK tidak ditemukan');
            }

            if (!Hash::check($request->password, $karyawan->password)) {
                return back()->with('error', 'Password salah');
            }

            // CEK ROLE DIVISI BARU
            $isAdmin = false;
            // Jika divisi ada dan role-nya 'admin'
            if ($karyawan->divisi && $karyawan->divisi->role === 'admin') {
                $isAdmin = true;
            }

            // Login manual guard Karyawan
            Auth::guard('karyawan')->login($karyawan, $request->remember);

            // Jika Role Divisi adalah Admin, arahkan ke Admin Dashboard
            if ($isAdmin) {
                return redirect('/admin/dashboard')
                       ->with('success', 'Berhasil login sebagai Admin (Divisi: ' . $karyawan->divisi->nama_divisi . ').');
            } else {
                // Karyawan biasa
                return redirect('/karyawan/dashboard')
                       ->with('success', 'Berhasil login sebagai Karyawan');
            }
        }

        return back()->with('error', 'Email / NIK atau Password salah.');
    }

    public function logout(Request $request)
    {
        if (Auth::guard('karyawan')->check()) {
            Auth::guard('karyawan')->logout();
        }

        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('logout_success', 'Anda telah logout.');
    }
}