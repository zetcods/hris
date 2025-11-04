<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use App\Models\Divisi;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawan = Karyawan::latest()->get();
        return view('admin.karyawan.index', compact('karyawan'));
    }

    public function create()
    {
        // ambil semua data divisi dari database
        $divisi = Divisi::all();
        // kirim ke view create
        return view('admin.karyawan.create', compact('divisi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:karyawan',
            'jabatan' => 'required|string|max:100',
            'divisi_id' => 'required|exists:divisi,id',
            'tanggal_masuk' => 'nullable|date',
            'gaji' => 'nullable|numeric',
        ]);

        // simpan data karyawan termasuk relasi divisi
        Karyawan::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'jabatan' => $request->jabatan,
            'divisi_id' => $request->divisi_id,
            'tanggal_masuk' => $request->tanggal_masuk,
            'gaji' => $request->gaji,
        ]);

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil ditambahkan!');
    }

    public function edit(Karyawan $karyawan)
    {
        // ambil juga data divisi biar bisa diedit nanti
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
            'tanggal_masuk' => 'nullable|date',
            'gaji' => 'nullable|numeric',
        ]);

        $karyawan->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'jabatan' => $request->jabatan,
            'divisi_id' => $request->divisi_id,
            'tanggal_masuk' => $request->tanggal_masuk,
            'gaji' => $request->gaji,
        ]);

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil diperbarui!');
    }

    public function destroy(Karyawan $karyawan)
    {
        $karyawan->delete();
        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil dihapus!');
    }
}
