<?php

namespace App\Http\Controllers;

use App\Models\LaporanMasalah;
use Illuminate\Http\Request;

class AdminLaporanController extends Controller
{
    public function index()
    {
        $laporan = LaporanMasalah::with('karyawan')->latest()->get();
        return view('admin.laporan.index', compact('laporan'));
    }

    public function detail($id)
    {
        $laporan = LaporanMasalah::with('karyawan.divisi')->findOrFail($id);
        return view('admin.laporan.detail', compact('laporan'));
    }

    // 1. DARI PENDING -> DIPROSES
    public function process($id)
    {
        $laporan = LaporanMasalah::findOrFail($id);
        
        // Cek status 'pending' (bukan menunggu)
        if ($laporan->status === 'pending') {
            $laporan->status = 'diproses';
            $laporan->save();
            return back()->with('success', 'Status berubah: Laporan sedang DIPROSES.');
        }

        return back()->with('error', 'Gagal: Hanya laporan "Pending" yang bisa diproses.');
    }

    // 2. DARI DIPROSES -> SELESAI
    public function done($id)
    {
        $laporan = LaporanMasalah::findOrFail($id);
        
        if ($laporan->status === 'diproses') {
            $laporan->status = 'selesai';
            $laporan->save();
            return back()->with('success', 'Status berubah: Laporan telah SELESAI.');
        }

        return back()->with('error', 'Gagal: Laporan harus "Diproses" dulu sebelum diselesaikan.');
    }

    // 3. TOLAK LAPORAN
    public function reject($id)
    {
        $laporan = LaporanMasalah::findOrFail($id);
        
        // Bisa tolak kalau statusnya pending atau diproses
        if (in_array($laporan->status, ['pending', 'diproses'])) {
            $laporan->status = 'ditolak';
            $laporan->save();
            return back()->with('success', 'Laporan telah DITOLAK.');
        }
        
        return back()->with('error', 'Gagal: Laporan yang sudah selesai tidak bisa ditolak.');
    }
}