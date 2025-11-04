@extends('layouts.admin')

@section('title', 'Edit Absensi')

@section('content')
<div style="padding: 40px;">
  <h1 style="font-size: 1.9rem; font-weight: 700; color: #f1f5f9;">✏️ Edit Data Absensi</h1>

  <form action="{{ route('absensi.update', $absensi->id) }}" method="POST" 
        style="margin-top: 30px; background: #1e293b; padding: 30px; border-radius: 12px; box-shadow: 0 6px 25px rgba(0,0,0,0.35);">
    @csrf
    @method('PUT')

    <label for="karyawan_id" style="color: #e2e8f0; font-weight: 500;">Karyawan</label>
    <select name="karyawan_id" id="karyawan_id" required
      style="width: 100%; padding: 10px; border-radius: 8px; background: #0f172a; color: #f1f5f9; border: 1px solid #334155; margin-bottom: 20px;">
      @foreach ($karyawan as $k)
        <option value="{{ $k->id }}" {{ $absensi->karyawan_id == $k->id ? 'selected' : '' }}>
          {{ $k->nama }}
        </option>
      @endforeach
    </select>

    <label for="tanggal" style="color: #e2e8f0; font-weight: 500;">Tanggal</label>
    <input type="date" name="tanggal" id="tanggal" value="{{ $absensi->tanggal }}" required
      style="width: 100%; padding: 10px; border-radius: 8px; background: #0f172a; color: #f1f5f9; border: 1px solid #334155; margin-bottom: 20px;">

    <label for="status" style="color: #e2e8f0; font-weight: 500;">Status</label>
    <select name="status" id="status" required
      style="width: 100%; padding: 10px; border-radius: 8px; background: #0f172a; color: #f1f5f9; border: 1px solid #334155; margin-bottom: 20px;">
      @foreach (['Hadir', 'Izin', 'Sakit', 'Cuti', 'Alpha'] as $status)
        <option value="{{ $status }}" {{ $absensi->status == $status ? 'selected' : '' }}>{{ $status }}</option>
      @endforeach
    </select>

    <label for="keterangan" style="color: #e2e8f0; font-weight: 500;">Keterangan</label>
    <textarea name="keterangan" id="keterangan" rows="3"
      style="width: 100%; padding: 10px; border-radius: 8px; background: #0f172a; color: #f1f5f9; border: 1px solid #334155; margin-bottom: 30px;">{{ $absensi->keterangan }}</textarea>

    <button type="submit"
      style="background: linear-gradient(90deg, #38bdf8, #3b82f6);
             color: #fff; padding: 12px 24px; border-radius: 8px; font-weight: 600;
             border: none; cursor: pointer; box-shadow: 0 3px 10px rgba(56,189,248,0.3); transition: all .3s ease;">
      💾 Update Absensi
    </button>
    <a href="{{ route('absensi.index') }}" 
         style="background: #334155; color: #e2e8f0; padding: 10px 24px; border-radius: 8px;
                text-decoration: none; font-weight: 500; transition: .3s;">
         Batal
      </a>
  </form>
</div>
@endsection
