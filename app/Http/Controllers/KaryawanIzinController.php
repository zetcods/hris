<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IzinKaryawan;

class KaryawanIzinController extends Controller
{
    public function index()
    {
        $data = IzinKaryawan::where('karyawan_id', auth()->id())->get();
        return view('karyawan.izin', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jenis' => 'required',
            'keterangan' => 'nullable|string',
        ]);

        IzinKaryawan::create([
            'karyawan_id' => auth()->guard('karyawan')->id(),
            'tanggal' => $request->tanggal,
            'jenis' => $request->jenis,
            'keterangan' => $request->keterangan,
        ]);

        return back()->with('success', 'Pengajuan izin berhasil dikirim!');
    }
}
