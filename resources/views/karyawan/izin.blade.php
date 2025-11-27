@extends('layouts.karyawan')

@section('title', 'Izin / Sakit')

@section('content')

<style>
  .box {
    background:#1e293b;
    padding:30px;
    border-radius:16px;
    box-shadow:0 4px 20px rgba(0,0,0,0.25);
    margin-bottom:25px;
  }
  label { color:#cbd5e1; font-weight:500; margin-bottom:8px; display:block; }
  .input {
    width:100%; padding:12px; border-radius:8px;
    border:1px solid #334155; background:#0f172a; color:#e2e8f0;
    margin-bottom:15px;
  }
  .btn {
    background:#38bdf8; border:none; padding:12px 20px;
    border-radius:8px; font-weight:600; cursor:pointer;
  }
</style>

<h1 style="font-size:2rem;color:#f1f5f9;font-weight:700;">Izin / Sakit</h1>
<p style="color:#94a3b8;margin-bottom:25px;">Ajukan izin tidak masuk atau laporan sakit.</p>

<div class="box">
  {{-- FIX: action ke route yang benar dan method POST dengan enctype --}}
  <form action="{{ route('karyawan.izin.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <label>Pilih Jenis Izin</label>
    {{-- FIX: Tambahkan name="jenis" dan values sesuai controller --}}
    <select name="jenis" class="input" required>
      <option value="">-- Pilih Jenis --</option>
      <option value="Izin" {{ old('jenis') == 'Izin' ? 'selected' : '' }}>Izin Pribadi</option>
      <option value="Sakit" {{ old('jenis') == 'Sakit' ? 'selected' : '' }}>Sakit</option>
    </select>
    @error('jenis')
      <p style="color:#ef4444; margin-top:4px;">{{ $message }}</p>
    @enderror

    <label>Tanggal</label>
    {{-- FIX: Tambahkan name="tanggal" --}}
    <input type="date" name="tanggal" value="{{ old('tanggal') }}" class="input" required>
    @error('tanggal')
      <p style="color:#ef4444; margin-top:4px;">{{ $message }}</p>
    @enderror

    <label>Keterangan</label>
    {{-- FIX: Tambahkan name="keterangan" --}}
    <textarea name="keterangan" class="input" rows="4" required>{{ old('keterangan') }}</textarea>
    @error('keterangan')
      <p style="color:#ef4444; margin-top:4px;">{{ $message }}</p>
    @enderror

    {{-- BARU: INPUT BUKTI FOTO --}}
    <label style="margin-top: 15px;">Lampiran Surat Dokter / Bukti (Wajib jika Izin Sakit, Max 2MB)</label>
    {{-- FIX: Tambahkan name="bukti_foto" --}}
    <input type="file" name="bukti_foto" class="input">

    @error('bukti_foto')
      <p style="color:#ef4444; margin-top:4px;">{{ $message }}</p>
    @enderror

    <button type="submit" class="btn">Ajukan Izin</button>
  </form>
</div>

{{-- Tambahkan Riwayat Pengajuan --}}
@isset($data)
<div class="box" style="margin-top: 30px;">
    <h3 style="color:#38bdf8;font-size:1.3rem;font-weight:600;margin-bottom:20px;">
        Riwayat Pengajuan Izin / Sakit
    </h3>
    <table style="width:100%; border-collapse:collapse;">
        <thead>
            <tr style="border-bottom:1px solid #334155;">
                <th style="color:#38bdf8; text-align:left; padding:12px;">Tanggal</th>
                <th style="color:#38bdf8; text-align:left;">Jenis</th>
                <th style="color:#38bdf8; text-align:left;">Keterangan</th>
                <th style="color:#38bdf8; text-align:center;">Status</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($data as $item)
            <tr style="border-bottom:1px solid #334155;">
                <td style="color:#e2e8f0; padding:12px;">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}</td>
                <td style="color:#e2e8f0;">{{ $item->jenis }}</td>
                <td style="color:#e2e8f0; max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $item->keterangan }}</td>
                <td style="text-align:center;">
                    @php
                        $color = ['menunggu' => '#facc15', 'disetujui' => '#10b981', 'ditolak' => '#ef4444'][$item->status] ?? '#94a3b8';
                    @endphp
                    <span style="background: {{ $color }}20; color: {{ $color }}; padding: 4px 10px; border-radius: 6px; font-size: 0.85rem; font-weight: 600;">
                        {{ ucfirst($item->status) }}
                    </span>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" style="text-align: center; padding: 20px; color: #94a3b8;">Belum ada riwayat pengajuan izin/sakit.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
@endisset

@endsection