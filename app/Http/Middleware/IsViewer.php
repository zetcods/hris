<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // pastikan user sudah login dan role-nya 'viewer'
        if (Auth::check() && Auth::user()->role === 'viewer') {
            return $next($request); // lanjut ke halaman
        }

        // kalau bukan admin, arahkan ke halaman home atau tampilkan error
        return redirect('/')->with('error', 'Akses ditolak: Anda bukan viewer.');
    }
}
