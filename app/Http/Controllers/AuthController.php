<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login_id' => 'required',
            'password' => 'required'
        ]);

        // 1. Coba login sebagai admin (email)
        if (filter_var($request->login_id, FILTER_VALIDATE_EMAIL)) {
            if (Auth::guard('web')->attempt([
                'email' => $request->login_id,
                'password' => $request->password
            ])) {
                return redirect()->route('admin.dashboard');
            }
        }

        // 2. Kalau bukan email → login sebagai karyawan pakai NIK
        if (Auth::guard('karyawan')->attempt([
            'nik' => $request->login_id,
            'password' => $request->password
        ])) {
            return redirect()->route('karyawan.dashboard');
        }

        return back()->withErrors([
            'login_id' => 'NIK/email atau password salah!'
        ]);
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        Auth::guard('karyawan')->logout();
        return redirect('/login');
    }
}
