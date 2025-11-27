<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanMasalah;
use Illuminate\Support\Facades\Auth; // 1. Tambahin Facade Auth biar aman

class KaryawanLaporController extends Controller
{
    public function index()
    {
        // 2. PERBAIKAN: Gunakan Auth::guard('karyawan')->id()
        // auth()->id() defaultnya nyari di tabel 'users' (admin), bukan 'karyawan'
        $karyawanId = Auth::guard('karyawan')->id();

        $riwayat = LaporanMasalah::where('karyawan_id', $karyawanId)
                    ->latest() // Tambahin latest biar yang baru di atas
                    ->get();

        return view('karyawan.lapor', compact('riwayat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'kategori' => 'required',
            'deskripsi' => 'required',
        ]);

        LaporanMasalah::create([
            // 3. PERBAIKAN: Pastikan pakai guard karyawan
            'karyawan_id' => Auth::guard('karyawan')->id(),
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'status' => 'pending', // Tambahin status default biar jelas
        ]);

        return back()->with('success', 'Laporan berhasil dikirim!');
    }
}