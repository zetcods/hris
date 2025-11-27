<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Karyawan;

class AuthKaryawanController extends Controller
{
    public function showLogin()
    {
        return view('karyawan.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'nik' => 'required',
            'password' => 'required'
        ]);

        // Cek NIK & Password
        if (Auth::guard('karyawan')->attempt([
            'nik' => $request->nik,
            'password' => $request->password
        ])) {
            return redirect()->route('karyawan.dashboard');
        }

        return back()->withErrors([
            'nik' => 'NIK atau password salah!'
        ]);
    }

    public function logout()
    {
        Auth::guard('karyawan')->logout();
        return redirect()->route('karyawan.login');
    }
}
