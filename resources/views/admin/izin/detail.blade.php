@extends('layouts.admin')

@section('title', 'Detail Izin / Sakit')

@section('content')
<div style="padding: 40px; max-width: 800px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 35px;">
        <h1 style="font-size: 1.9rem; font-weight: 700; color: #f1f5f9;">
            📄 Detail Izin / Sakit #{{ $izin->id }}
        </h1>
        <a href="{{ route('admin.izin') }}" style="background: #334155; color: #e2e8f0; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600;">
            ← Kembali
        </a>
    </div>

    <div style="background: #1e293b; padding: 30px; border-radius: 16px; box-shadow: 0 5px 20px rgba(0,0,0,0.35); border: 1px solid #334155;">

        {{-- INFO KARYAWAN & PENGAJUAN --}}
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; border-bottom: 1px solid #334155; padding-bottom: 20px; margin-bottom: 20px;">
            <div>
                <p style="color: #cbd5e1; font-size: 0.9rem;">Nama Karyawan</p>
                <h3 style="color: #f1f5f9; font-weight: 600;">{{ $izin->karyawan->nama }}</h3>
            </div>
            <div>
                <p style="color: #cbd5e1; font-size: 0.9rem;">NIK</p>
                <h3 style="color: #f1f5f9; font-weight: 600;">{{ $izin->karyawan->nik }}</h3>
            </div>
            <div>
                <p style="color: #cbd5e1; font-size: 0.9rem;">Divisi</p>
                <h3 style="color: #f1f5f9;">{{ $izin->karyawan->divisi->nama_divisi ?? '-' }}</h3>
            </div>
            <div>
                <p style="color: #cbd5e1; font-size: 0.9rem;">Tanggal Pengajuan</p>
                <h3 style="color: #f1f5f9;">{{ \Carbon\Carbon::parse($izin->tanggal)->translatedFormat('l, d F Y') }}</h3>
            </div>
        </div>

        {{-- JENIS & KETERANGAN --}}
        <div style="margin-bottom: 25px;">
            <p style="color: #cbd5e1; font-size: 0.9rem;">Jenis Pengajuan</p>
            <h3 style="font-size: 1.5rem; font-weight: 700;">
                @if($izin->jenis == 'Sakit')
                    <span style="color: #ef4444;">🤒 {{ $izin->jenis }}</span>
                @else
                    <span style="color: #38bdf8;">📝 {{ $izin->jenis }}</span>
                @endif
            </h3>
        </div>

        <div style="margin-bottom: 30px;">
            <p style="color: #cbd5e1; font-size: 0.9rem;">Keterangan / Alasan</p>
            <p style="background: #0f172a; padding: 15px; border-radius: 8px; color: #e2e8f0; margin-top: 8px; border: 1px solid #334155;">
                {{ $izin->keterangan }}
            </p>
        </div>

        {{-- BUKTI FOTO (Conditional Display) --}}
        @if($izin->jenis == 'Sakit' && $izin->bukti)
            <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #334155;">
                <p style="color: #f59e0b; font-size: 1rem; font-weight: 600; margin-bottom: 15px;">
                    📸 Bukti Foto (Surat Dokter / Lainnya)
                </p>
                {{-- Gunakan Storage::url() untuk mengakses file dari folder public --}}
                <img src="{{ Storage::url($izin->bukti) }}" 
                     alt="Bukti Izin Sakit" 
                     style="max-width: 100%; height: auto; border-radius: 10px; border: 2px solid #38bdf8;">
                <p style="color: #94a3b8; font-size: 0.85rem; margin-top: 10px;">
                    <a href="{{ Storage::url($izin->bukti) }}" target="_blank" style="color: #38bdf8; text-decoration: none;">
                        Lihat Gambar Penuh
                    </a>
                </p>
            </div>
        @elseif($izin->jenis == 'Sakit')
            <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #334155;">
                <p style="color: #ef4444; font-size: 0.9rem; font-weight: 600;">
                    ⚠️ Jenis Sakit, tapi Bukti Foto Tidak Dilampirkan.
                </p>
            </div>
        @endif

        {{-- Tombol Aksi --}}
        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #334155; text-align: right;">
            @if($izin->status == 'menunggu')
                <form action="{{ route('admin.izin.approve', $izin->id) }}" method="POST" style="display:inline-block; margin-right: 10px;">
                    @csrf 
                    <button type="submit" 
                        style="background: #10b981; color: #fff; padding: 10px 20px; border-radius: 8px; font-weight: 600; border: none; cursor: pointer;">
                        ✔ Setujui
                    </button>
                </form>
                <form action="{{ route('admin.izin.reject', $izin->id) }}" method="POST" style="display:inline-block;">
                    @csrf 
                    <button type="submit" 
                        style="background: #ef4444; color: #fff; padding: 10px 20px; border-radius: 8px; font-weight: 600; border: none; cursor: pointer;">
                        ✖ Tolak
                    </button>
                </form>
            @else
                <p style="color: #94a3b8; font-weight: 600;">Status: {{ ucfirst($izin->status) }}</p>
            @endif
        </div>

    </div>
</div>
@endsection