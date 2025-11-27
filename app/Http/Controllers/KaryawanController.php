<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Divisi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; // Tambahkan ini

class KaryawanController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil total semua karyawan (unfiltered)
        $totalKaryawan = Karyawan::count();

        // 2. Mulai Query
        $query = Karyawan::with('divisi');

        // 3. Terapkan Filter Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('nik', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        // 4. Terapkan Filter Divisi
        if ($divisi_id = $request->input('divisi_id')) {
            $query->where('divisi_id', $divisi_id);
        }

        // 5. Eksekusi Query dan ambil data Divisi untuk dropdown
        $karyawan = $query->latest()->get();
        $divisi = Divisi::all(); // Untuk dropdown filter

        // Tambahkan totalKaryawan ke compact
        return view('admin.karyawan.index', compact('karyawan', 'divisi', 'totalKaryawan'));
    }

    public function create()
    {
        $divisi = Divisi::all();
        $nik = $this->generateNik();
        return view('admin.karyawan.create', compact('divisi', 'nik'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|unique:karyawan,nik',
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:karyawan',
            'jabatan' => 'required|string|max:100',
            'divisi_id' => 'required|exists:divisi,id',
            'no_hp' => 'required|numeric', // Validasi HP
            'jenis_kelamin' => 'required|in:L,P', // Validasi Gender
            'alamat' => 'required|string',
            'tanggal_masuk' => 'nullable|date',
            'gaji' => 'nullable|numeric',
            // Tambahkan validasi untuk kolom yang kamu tambahkan sebelumnya
            // 'tempat_lahir'      => 'nullable|string|max:100',
            // 'tanggal_lahir'     => 'nullable|date',
        ]);

        $randomPassword = Str::upper(Str::random(8));

        Karyawan::create([
            'nik'               => $request->nik,
            'nama'              => $request->nama,
            'email'             => $request->email,
            'jabatan'           => $request->jabatan,
            'divisi_id'         => $request->divisi_id,
            
            // DATA BARU (pastikan form create sudah diupdate)
            // 'tempat_lahir'      => $request->tempat_lahir,
            // 'tanggal_lahir'     => $request->tanggal_lahir,
            'jenis_kelamin'     => $request->jenis_kelamin,
            'no_hp'             => $request->no_hp,
            'alamat'            => $request->alamat,

            'tanggal_masuk'     => $request->tanggal_masuk,
            'gaji'              => $request->gaji,
            'password'          => Hash::make($randomPassword),
            'password_plain'    => $randomPassword
        ]);

        return redirect()->route('karyawan.index')
            ->with('success', 'Karyawan berhasil dibuat! Password default: ' . $randomPassword);
    }

    public function edit(Karyawan $karyawan)
    {
        $divisi = Divisi::all();
        return view('admin.karyawan.edit', compact('karyawan', 'divisi'));
    }

    public function update(Request $request, Karyawan $karyawan)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:karyawan,email,' . $karyawan->id,
            'jabatan' => 'required|string|max:100',
            'divisi_id' => 'required|exists:divisi,id',
            'no_hp' => 'required|numeric',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string',
            'gaji' => 'nullable|numeric',
        ]);

        $karyawan->update([
            'nama'          => $request->nama,
            'email'         => $request->email,
            'jabatan'       => $request->jabatan,
            'divisi_id'     => $request->divisi_id,
            
            // DATA BARU (pastikan form edit sudah diupdate)
            // 'tempat_lahir'      => $request->tempat_lahir,
            // 'tanggal_lahir'     => $request->tanggal_lahir,
            'jenis_kelamin'     => $request->jenis_kelamin,
            'no_hp'             => $request->no_hp,
            'alamat'            => $request->alamat,

            'tanggal_masuk' => $request->tanggal_masuk,
            'gaji'          => $request->gaji,
        ]);

        return redirect()->route('karyawan.index')
            ->with('success', 'Data karyawan berhasil diperbarui!');
    }

    public function destroy(Karyawan $karyawan)
    {
        $karyawan->delete();
        return redirect()->route('karyawan.index')
            ->with('success', 'Karyawan berhasil dihapus!');
    }

    public function show(Karyawan $karyawan)
    {
        $karyawan->load('divisi');
        
        return view('admin.karyawan.show', compact('karyawan'));
    }

    private function generateNik()
    {
        do {
            $nik = 'NIK' . date('Y') . strtoupper(Str::random(6));
        } while (Karyawan::where('nik', $nik)->exists());

        return $nik;
    }
}