<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Divisi;
use App\Models\Absensi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $totalKaryawan = Karyawan::count();
        $totalDivisi = Divisi::count();

        // 🔹 Hitung absensi hanya dalam bulan ini
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $totalAbsensiBulanIni = Absensi::whereBetween('tanggal', [$startOfMonth, $endOfMonth])->count();

        // 🔹 Ambil daftar divisi
        $listDivisi = Divisi::all();

        // 🔹 Grafik karyawan per divisi
        $karyawanPerDivisi = Divisi::withCount('karyawan')->get();

        // 🔹 Grafik absensi per status (bulan ini)
        $absensiStat = Absensi::select('status', DB::raw('COUNT(*) as total'))
            ->whereBetween('tanggal', [$startOfMonth, $endOfMonth])
            ->groupBy('status')
            ->get();

        return view('admin.dashboard', compact(
            'totalKaryawan',
            'totalDivisi',
            'listDivisi',
            'totalAbsensiBulanIni',
            'karyawanPerDivisi',
            'absensiStat'
        ));
    }
}
