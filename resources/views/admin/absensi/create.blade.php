@extends('layouts.admin')

@section('title', 'Tambah Absensi')

@section('content')
<div style="padding: 40px;">
  <h1 style="font-size: 1.9rem; font-weight: 700; color: #f1f5f9;">
    🕒 Tambah Data Absensi
  </h1>

  <form action="{{ route('absensi.store') }}" method="POST" style="margin-top: 30px; background: #1e293b; padding: 30px; border-radius: 12px; box-shadow: 0 6px 25px rgba(0,0,0,0.35);">
    @csrf

    {{-- Karyawan --}}
    <label for="karyawan_id" style="color: #e2e8f0; font-weight: 500;">Karyawan</label>
    <select name="karyawan_id" id="karyawan_id" required
      style="width: 100%; padding: 10px; border-radius: 8px; background: #0f172a; color: #f1f5f9; border: 1px solid #334155; margin-bottom: 20px;">
      <option value="">-- Pilih Karyawan --</option>
      @foreach ($karyawan as $k)
        <option value="{{ $k->id }}">{{ $k->nama }}</option>
      @endforeach
    </select>

    {{-- Tanggal --}}
    <label for="tanggal" style="color: #e2e8f0; font-weight: 500;">Tanggal</label>
    <input type="date" name="tanggal" id="tanggal" required
      style="width: 100%; padding: 10px; border-radius: 8px; background: #0f172a; color: #f1f5f9; border: 1px solid #334155; margin-bottom: 20px;">

    {{-- Status --}}
    <label for="status" style="color: #e2e8f0; font-weight: 500;">Status</label>
    <select name="status" id="status" required
      style="width: 100%; padding: 10px; border-radius: 8px; background: #0f172a; color: #f1f5f9; border: 1px solid #334155; margin-bottom: 20px;">
      <option value="">-- Pilih Status --</option>
      <option value="Hadir">Hadir</option>
      <option value="Izin">Izin</option>
      <option value="Sakit">Sakit</option>
      <option value="Cuti">Cuti</option>
      <option value="Alpha">Alpha</option>
    </select>

    {{-- Keterangan --}}
    <label for="keterangan" style="color: #e2e8f0; font-weight: 500;">Keterangan</label>
    <textarea name="keterangan" id="keterangan" rows="3"
      style="width: 100%; padding: 10px; border-radius: 8px; background: #0f172a; color: #f1f5f9; border: 1px solid #334155; margin-bottom: 30px;"></textarea>

    <button type="submit" 
      style="background: linear-gradient(90deg, #38bdf8, #3b82f6);
             color: #fff; padding: 12px 24px; border-radius: 8px; font-weight: 600;
             text-decoration: none; border: none; cursor: pointer;
             box-shadow: 0 3px 10px rgba(56,189,248,0.3); transition: all .3s ease;">
      💾 Simpan Absensi
    </button>
  </form>
</div>
@endsection
