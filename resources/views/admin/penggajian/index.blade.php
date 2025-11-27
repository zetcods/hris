@extends('layouts.admin')

@section('title', 'Data Penggajian')

@section('content')
<div style="padding: 40px;">
    <h1 style="font-size: 1.9rem; font-weight: 700; color: #f1f5f9; margin-bottom: 25px;">
        💰 Data Penggajian
    </h1>

    {{-- FORM GENERATE GAJI --}}
    <div style="background: #1e293b; padding: 25px; border-radius: 12px; margin-bottom: 30px; border: 1px solid #334155;">
        <h3 style="color: #38bdf8; font-size: 1.1rem; margin-bottom: 15px;">Generate Gaji Bulanan</h3>
        
        <form action="{{ route('admin.penggajian.generate') }}" method="POST" style="display: flex; gap: 15px; align-items: center;">
            @csrf
            
            {{-- Dropdown Bulan --}}
            <select name="bulan" required style="padding: 10px; border-radius: 6px; background: #0f172a; border: 1px solid #475569; color: #fff;">
                @foreach ($listBulan as $b)
                    <option value="{{ $b }}" {{ $bulan == $b ? 'selected' : '' }}>{{ $b }}</option>
                @endforeach
            </select>
            
            {{-- Dropdown Tahun --}}
            <select name="tahun" required style="padding: 10px; border-radius: 6px; background: #0f172a; border: 1px solid #475569; color: #fff;">
                @foreach ($listTahun as $t)
                    <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
                @endforeach
            </select>
            
            {{-- Tombol Generate --}}
            <button type="submit" style="background: #10b981; color: #fff; padding: 10px 20px; border-radius: 6px; border: none; font-weight: 600; cursor: pointer;">
                ⚙ Generate
            </button>
        </form>
    </div>

    {{-- TABEL SLIP GAJI --}}
    <h2 style="font-size: 1.5rem; color: #cbd5e1; margin-bottom: 15px;">Slip Gaji Bulan {{ $bulan }} {{ $tahun }}</h2>

    <div style="background: #1e293b; border-radius: 12px; overflow: hidden; box-shadow: 0 6px 25px rgba(0,0,0,0.35);">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #111827; color: #38bdf8; text-align: left; font-size: 0.95rem;">
                    <th style="padding: 14px 16px;">NIK</th>
                    <th>Nama Karyawan</th>
                    <th>Gaji Pokok</th>
                    <th>Potongan Alpha</th>
                    <th>Gaji Bersih</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($gaji as $item)
                <tr style="background: #0f172a; color: #e2e8f0; border-top: 1px solid #1e293b;">
                    <td style="padding: 12px 16px;">{{ $item->karyawan->nik }}</td>
                    <td style="padding: 12px 16px;">{{ $item->karyawan->nama }}</td>
                    <td style="color: #10b981; font-weight: 600;">Rp {{ number_format($item->gaji_pokok, 0, ',', '.') }}</td>
                    <td style="color: #ef4444; font-weight: 600;">Rp {{ number_format($item->potongan_alpha, 0, ',', '.') }}</td>
                    <td style="color: #38bdf8; font-weight: 700;">Rp {{ number_format($item->gaji_bersih, 0, ',', '.') }}</td>
                    
                    {{-- PERBAIKAN KOLOM AKSI (Menjadi Tombol Cetak) --}}
                    <td style="text-align: center;">
                        <a href="{{ route('admin.penggajian.slip', $item->id) }}" 
                           target="_blank" 
                           style="background: #3b82f6; color: #fff; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 0.9rem;">
                           Cetak Slip
                        </a>
                    </td>
                    
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center; padding: 25px; color: #94a3b8;">Belum ada data gaji untuk periode ini. Silakan generate di atas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Script SweetAlert (pastikan sudah di-load di layouts.admin) --}}
@if(session('success'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}", showConfirmButton: false, timer: 2000, background: '#1e293b', color: '#e2e8f0' });
</script>
@endif
@endsection