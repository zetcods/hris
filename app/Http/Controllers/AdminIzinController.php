<?php

namespace App\Http\Controllers;

use App\Models\Izin; // Model Izin (asumsi)
use App\Models\Absensi; // Wajib import
use App\Models\IzinKaryawan;
use Illuminate\Http\Request;

class AdminIzinController extends Controller
{
    public function index()
    {
        $izin = IzinKaryawan::with('karyawan')->latest()->get();
        return view('admin.izin.index', compact('izin'));
    }

    public function detail($id)
    {
        $izin = IzinKaryawan::with('karyawan')->findOrFail($id);
        
        if ($izin->karyawan) {
            $izin->karyawan->load('divisi');
        }

        return view('admin.izin.detail', compact('izin'));
    }

    public function approve($id)
    {
        $izin = IzinKaryawan::findOrFail($id);
        
        if ($izin->status !== 'menunggu') {
            return back()->with('error', 'Izin ini sudah diproses sebelumnya.');
        }

        // 1. UPDATE STATUS DI TABEL PENGAJUAN IZIN
        $izin->status = 'disetujui';
        $izin->save();
        
        // 2. OTOMATIS CATAT KE TABEL ABSENSI (FIX BARU)
        $statusAbsensi = ($izin->jenis === 'Sakit') ? 'Sakit' : 'Izin'; 
        
        $exists = Absensi::where('karyawan_id', $izin->karyawan_id)
                         ->where('tanggal', $izin->tanggal)
                         ->exists();

        if (!$exists) {
            Absensi::create([
                'karyawan_id' => $izin->karyawan_id,
                'tanggal' => $izin->tanggal,
                'status' => $statusAbsensi, // Status 'Izin' atau 'Sakit'
                'keterangan' => 'Pengajuan ' . $statusAbsensi . ' Disetujui: ' . $izin->keterangan,
            ]);
        }

        return back()->with('success', 'Pengajuan izin berhasil disetujui dan dicatat ke Absensi.');
    }

    public function reject($id)
    {
        $izin = IzinKaryawan::findOrFail($id);
        $izin->status = 'ditolak';
        $izin->save();

        return back()->with('success', 'Pengajuan izin berhasil ditolak.');
    }
}