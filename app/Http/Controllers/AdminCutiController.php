<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cuti; // Model Cuti (asumsi)
use App\Models\Absensi; // Wajib import
use App\Models\CutiKaryawan;
use App\Models\Karyawan; // Wajib import
use Carbon\Carbon; // Wajib import

class AdminCutiController extends Controller
{
    public function index()
    {
        // Asumsi model Cuti memiliki relasi 'karyawan'
        $cuti = CutiKaryawan::with('karyawan')->latest()->get();
        return view('admin.cuti.index', compact('cuti'));
    }

    public function approve($id)
    {
        $cuti = CutiKaryawan::findOrFail($id);
        
        if ($cuti->status !== 'menunggu') {
            return back()->with('error', 'Cuti ini sudah diproses sebelumnya.');
        }

        $startDate = Carbon::parse($cuti->tanggal_mulai);
        $endDate = Carbon::parse($cuti->tanggal_selesai);
        $durasiCuti = $startDate->diffInDays($endDate) + 1;

        $karyawan = Karyawan::findOrFail($cuti->karyawan_id);

        // 1. CEK & KURANGI KUOTA CUTI (FIX KRUSIAL)
        if ($karyawan->kuota_cuti < $durasiCuti) {
             return back()->with('error', 'Gagal disetujui! Kuota cuti karyawan tidak mencukupi (' . $karyawan->kuota_cuti . ' hari).');
        }

        $cuti->status = 'disetujui';
        $cuti->save();

        $karyawan->kuota_cuti -= $durasiCuti;
        $karyawan->save(); // Kuota cuti sudah dikurangi

        // 2. OTOMATIS CATAT KE TABEL ABSENSI
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $tanggalAbsensi = $date->toDateString();
            
            // Cek duplikasi: Jangan catat jika sudah ada absensi
            $exists = Absensi::where('karyawan_id', $cuti->karyawan_id)
                             ->where('tanggal', $tanggalAbsensi)
                             ->exists();

            if (!$exists) {
                Absensi::create([
                    'karyawan_id' => $cuti->karyawan_id,
                    'tanggal' => $tanggalAbsensi,
                    'status' => 'Cuti', 
                    'keterangan' => 'Cuti Disetujui: ' . $cuti->alasan,
                ]);
            }
        }
        
        return back()->with('success', 'Pengajuan cuti telah disetujui, dicatat ke Absensi, dan kuota cuti dikurangi.');
    }

    public function reject($id)
    {
        $cuti = CutiKaryawan::findOrFail($id);
        $cuti->status = 'ditolak';
        $cuti->save();

        return back()->with('success', 'Pengajuan cuti telah ditolak.');
    }

    public function detail($id)
    {
        $cuti = CutiKaryawan::with('karyawan')->findOrFail($id);
        return view('admin.cuti.detail', compact('cuti'));
    }
}