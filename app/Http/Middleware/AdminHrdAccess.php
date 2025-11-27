<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Divisi;
use Illuminate\Support\Str;

class AdminHrdAccess
{
    public function handle(Request $request, Closure $next)
    {
        // 1. Cek jika Admin standar (guard 'web') login
        if (Auth::guard('web')->check()) {
            return $next($request);
        }

        // 2. Cek jika Karyawan (guard 'karyawan') login
        if (Auth::guard('karyawan')->check()) {
            $karyawan = Auth::guard('karyawan')->user();
            $isHrd = false;

            $divisi = $karyawan->divisi ?? Divisi::find($karyawan->divisi_id);
            
            if ($divisi) {
                $divisiName = strtolower($divisi->nama_divisi);
                if (Str::contains($divisiName, 'human resource') || Str::contains($divisiName, 'sdm')) {
                    $isHrd = true;
                }
            }
            
            if ($isHrd) {
                return $next($request);
            }
        }

        // Jika tidak lolos otorisasi, hapus semua session dan redirect ke login
        if (Auth::guard('karyawan')->check()) {
             Auth::guard('karyawan')->logout();
        }
        if (Auth::guard('web')->check()) {
             Auth::guard('web')->logout();
        }
        return redirect('/login')->with('error', 'Akses ditolak. Anda tidak memiliki hak Admin/HRD.');
    }
}