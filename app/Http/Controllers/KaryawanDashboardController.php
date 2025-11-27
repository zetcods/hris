<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage; // Wajib: Untuk menyimpan file
use App\Models\CutiKaryawan;   
use App\Models\IzinKaryawan;   
use App\Models\LaporanMasalah; 
use App\Models\Karyawan;

class KaryawanDashboardController extends Controller
{
    // 1. DASHBOARD
    public function index()
    {
        $id = Auth::guard('karyawan')->id();

        $totalCuti = CutiKaryawan::where('karyawan_id', $id)->count();
        $totalIzin = IzinKaryawan::where('karyawan_id', $id)->count();
        $totalLapor = LaporanMasalah::where('karyawan_id', $id)->count();
        
        $totalPengajuan = $totalCuti + $totalIzin + $totalLapor;

        return view('karyawan.dashboard', compact('totalPengajuan'));
    }

    // 2. PROFILE VIEW
    public function profile()
    {
        return view('karyawan.profile');
    }

    // --- UPDATE INFO (NAMA & EMAIL) ---
    public function updateInfo(Request $request)
    {
        $user = Auth::guard('karyawan')->user();

        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:karyawan,email,'.$user->id,
        ]);

        Karyawan::where('id', $user->id)->update([
            'nama' => $request->nama,
            'email' => $request->email,
        ]);

        return back()->with('success', 'Informasi profil berhasil diperbarui!');
    }

    // --- UPDATE PASSWORD (KHUSUS) ---
    public function updatePassword(Request $request)
    {
        $user = Auth::guard('karyawan')->user();

        $request->validate([
            'password' => 'required|min:6|confirmed',
        ], [
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.required' => 'Password baru wajib diisi.'
        ]);

        Karyawan::where('id', $user->id)->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Password berhasil diubah! Silakan login ulang nanti.');
    }

    // 3. CUTI
    public function cuti()
    {
        $data = CutiKaryawan::where('karyawan_id', Auth::guard('karyawan')->id())
                        ->latest()
                        ->get();      
        return view('karyawan.cuti', compact('data'));
    }

    public function cutiStore(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'required|string',
        ]);

        CutiKaryawan::create([
            'karyawan_id' => Auth::guard('karyawan')->id(),
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'alasan' => $request->alasan,
            'status' => 'menunggu',
        ]);

        return back()->with('success', 'Pengajuan Cuti berhasil dikirim!');
    }

    // 4. IZIN (FIXED WITH FILE UPLOAD)
    public function izin()
    {
        $data = IzinKaryawan::where('karyawan_id', Auth::guard('karyawan')->id())
                        ->latest()
                        ->get();
        return view('karyawan.izin', compact('data'));
    }

    public function izinStore(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jenis' => 'required|in:Izin,Sakit',
            'keterangan' => 'required|string',
            'bukti_foto' => 'nullable|file|image|max:2048', // Validasi foto, max 2MB
        ]);

        $buktiPath = null;
        if ($request->hasFile('bukti_foto')) {
            // Simpan file ke storage/app/public/bukti_izin
            $buktiPath = $request->file('bukti_foto')->store('bukti_izin', 'public');
            // Catatan: Pastikan kamu sudah jalankan 'php artisan storage:link'
        }


        IzinKaryawan::create([
            'karyawan_id' => Auth::guard('karyawan')->id(),
            'tanggal' => $request->tanggal,
            'jenis' => $request->jenis,
            'keterangan' => $request->keterangan,
            'bukti' => $buktiPath, // Simpan path file ke kolom 'bukti'
            'status' => 'menunggu',
        ]);

        return back()->with('success', 'Pengajuan Izin/Sakit berhasil dikirim!');
    }

    // 5. LAPORAN
    public function lapor()
    {
        $riwayat = LaporanMasalah::where('karyawan_id', Auth::guard('karyawan')->id())
                                 ->latest()
                                 ->get();
        return view('karyawan.lapor', compact('riwayat'));
    }

    public function laporStore(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string',
            'deskripsi' => 'required|string',
        ]);

        LaporanMasalah::create([
            'karyawan_id' => Auth::guard('karyawan')->id(),
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Laporan berhasil dikirim!');
    }
}