<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Karyawan;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index()
    {
        $absensi = Absensi::with('karyawan')->orderBy('tanggal', 'desc')->get();
        return view('admin.absensi.index', compact('absensi'));
    }

    public function create()
    {
        $karyawan = Karyawan::all();
        return view('admin.absensi.create', compact('karyawan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'karyawan_id' => 'required|exists:karyawan,id',
            'tanggal' => 'required|date',
            'status' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        Absensi::create($validated);

        return redirect()->route('absensi.index')->with('success', 'Absensi berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $absensi = Absensi::findOrFail($id);
        $karyawan = Karyawan::all();
        return view('admin.absensi.edit', compact('absensi', 'karyawan'));
    }

    public function update(Request $request, $id)
    {
        $absensi = Absensi::findOrFail($id);
        $validated = $request->validate([
            'karyawan_id' => 'required|exists:karyawan,id',
            'tanggal' => 'required|date',
            'status' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        $absensi->update($validated);
        return redirect()->route('absensi.index')->with('success', 'Data absensi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $absensi = Absensi::findOrFail($id);
        $absensi->delete();
        return redirect()->route('absensi.index')->with('success', 'Data absensi berhasil dihapus!');
    }

    // ==========================================
    // 🔥 FITUR BARU: PRINT REKAP ABSENSI
    // ==========================================
    public function print(Request $request)
    {
        // Ambil input bulan & tahun, default ke bulan ini kalau kosong
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        // Ambil data absensi sesuai filter
        $absensi = Absensi::with('karyawan')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal', 'asc')
            ->get();

        // Return ke view khusus print (Pastikan file print.blade.php sudah dibuat)
        return view('admin.absensi.print', compact('absensi', 'bulan', 'tahun'));
    }
}