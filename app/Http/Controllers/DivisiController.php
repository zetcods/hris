<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use Illuminate\Http\Request;

class DivisiController extends Controller
{
    public function index()
    {
        // Tetap menggunakan withCount untuk index
        $divisi = \App\Models\Divisi::withCount('karyawan')->get();
        return view('admin.divisi.index', compact('divisi'));
    }

    public function create()
    {
        return view('admin.divisi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_divisi' => 'required|unique:divisi,nama_divisi|max:100',
            'role' => 'required|in:karyawan,admin', // BARU: Validasi Role
        ]);

        Divisi::create([
            'nama_divisi' => $request->nama_divisi,
            'role' => $request->role, // BARU: Simpan Role
        ]);

        return redirect()->route('divisi.index')->with('success', 'Divisi berhasil ditambahkan!');
    }

    public function edit(Divisi $divisi)
    {
        return view('admin.divisi.edit', compact('divisi'));
    }

    public function update(Request $request, Divisi $divisi)
    {
        $request->validate([
            'nama_divisi' => 'required|max:100|unique:divisi,nama_divisi,' . $divisi->id,
            'role' => 'required|in:karyawan,admin', // BARU: Validasi Role
        ]);

        $divisi->update([
            'nama_divisi' => $request->nama_divisi,
            'role' => $request->role, // BARU: Update Role
        ]);

        return redirect()->route('divisi.index')->with('success', 'Divisi berhasil diperbarui!');
    }

    public function destroy(Divisi $divisi)
    {
        $divisi->delete();
        return redirect()->route('divisi.index')->with('success', 'Divisi berhasil dihapus!');
    }

    public function show($id)
    {
        $divisi = \App\Models\Divisi::findOrFail($id);
        $karyawan = \App\Models\Karyawan::where('divisi_id', $divisi->id)->get();

        return view('admin.divisi.show', compact('divisi', 'karyawan'));
    }
}