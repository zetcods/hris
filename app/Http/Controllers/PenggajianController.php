<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penggajian;
use App\Models\Karyawan;
use App\Models\Absensi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PenggajianController extends Controller
{
    public function index(Request $request)
    {
        $listBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $listTahun = range(Carbon::now()->year, Carbon::now()->year - 5);
        
        $bulanSekarang = Carbon::now()->translatedFormat('F');
        $tahunSekarang = Carbon::now()->year;

        $bulan = $request->input('bulan', $bulanSekarang);
        $tahun = $request->input('tahun', $tahunSekarang);

        $gaji = Penggajian::with('karyawan')
                    ->where('bulan', $bulan)
                    ->where('tahun', $tahun)
                    ->latest()
                    ->get();
                    
        return view('admin.penggajian.index', compact('gaji', 'bulan', 'tahun', 'listBulan', 'listTahun'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'bulan' => 'required|string',
            'tahun' => 'required|numeric',
        ]);

        $bulan = $request->bulan;
        $tahun = (int)$request->tahun;

        // --- CRUCIAL FIX 1: Tentukan rentang tanggal dengan benar ---
        // Buat objek Carbon di awal bulan yang dipilih
        $date = Carbon::createFromFormat('F Y', $bulan . ' ' . $tahun, 'Asia/Jakarta');
        $startOfMonth = $date->copy()->startOfMonth();
        $endOfMonth = $date->copy()->endOfMonth();

        // 1. FIX: Hapus data lama jika sudah ada (Memaksa Re-generate)
        Penggajian::where('bulan', $bulan)->where('tahun', $tahun)->delete(); 
        
        // 2. Hitung Hari Kerja Total (Senin-Jumat)
        $hariKerjaTotal = 0;
        $currentDate = $startOfMonth->copy();
        while ($currentDate->lte($endOfMonth)) {
            if ($currentDate->isWeekday()) {
                $hariKerjaTotal++;
            }
            $currentDate->addDay();
        }
        
        $karyawanList = Karyawan::all();

        DB::beginTransaction();
        try {
            foreach ($karyawanList as $karyawan) {
                
                // 3. FIX: Hitung Alpha (Filter Absensi berdasarkan bulan/tahun yang dipilih)
                $absensiData = Absensi::where('karyawan_id', $karyawan->id)
                                    ->whereBetween('tanggal', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
                                    ->get();

                $totalAlpha = $absensiData->where('status', 'Alpha')->count();
                $totalHadir = $absensiData->where('status', 'Hadir')->count(); // Data Hadir juga dihitung

                // 🔹 LOGIKA POTONGAN ALPHA (FIX PERHITUNGAN)
                $gajiPokok = (float)$karyawan->gaji;
                
                if ($hariKerjaTotal > 0) {
                    // Potongan = (Gaji Pokok / Total Hari Kerja Efektif) * Total Hari Alpha
                    $gajiPerHari = $gajiPokok / $hariKerjaTotal;
                } else {
                    $gajiPerHari = 0;
                }

                $potonganAlpha = $totalAlpha * $gajiPerHari;
                $gajiBersih = $gajiPokok - $potonganAlpha;

                // 4. Simpan ke Tabel Penggajian
                Penggajian::create([
                    'karyawan_id' => $karyawan->id,
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                    'gaji_pokok' => $gajiPokok,
                    'hari_kerja_total' => $hariKerjaTotal,
                    'total_hadir' => $totalHadir,
                    'total_alpha' => $totalAlpha,
                    'potongan_alpha' => $potonganAlpha,
                    'gaji_bersih' => $gajiBersih,
                ]);
            }

            DB::commit();
            return back()->with('success', 'Berhasil! Data gaji bulan ' . $bulan . ' tahun ' . $tahun . ' telah di-generate ulang.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal Generate Gaji: ' . $e->getMessage());
        }
    }

    public function showSlip($id)
    {
        $gaji = Penggajian::with(['karyawan.divisi'])->findOrFail($id);
        Carbon::setLocale('id');
        return view('admin.penggajian.slip', compact('gaji'));
    }
}