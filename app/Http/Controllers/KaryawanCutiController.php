<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CutiKaryawan;
use Illuminate\Support\Facades\Auth;

class KaryawanCutiController extends Controller
{
    public function index()
    {
        $data = CutiKaryawan::where('karyawan_id', Auth::guard('karyawan')->id())
            ->orderBy('id', 'desc')
            ->get();

        // 🔴 PERBAIKAN DI SINI BRO
        // Dari 'karyawan.cuti.index' jadi 'karyawan.cuti' (sesuai nama file lu)
        return view('karyawan.cuti', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'keterangan' => 'required|string'
        ]);

        CutiKaryawan::create([
            'karyawan_id' => Auth::guard('karyawan')->id(),
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'keterangan' => $request->keterangan, // Pastikan di database kolomnya 'keterangan' atau 'alasan' (sesuaikan)
            'status' => 'menunggu'
        ]);

        return redirect()->back()->with('success', 'Pengajuan cuti berhasil diajukan.');
    }

    // Update & Show method gue hide dulu krn logic utama di Index & Destroy
    // Kalau butuh balikin aja kayak file sebelumnya.

    public function destroy($id)
    {
        $cuti = CutiKaryawan::where('karyawan_id', Auth::guard('karyawan')->id())
            ->where('id', $id)
            ->firstOrFail();

        $cuti->delete();

        return redirect()->back()->with('success', 'Pengajuan cuti berhasil dibatalkan.');
    }
}