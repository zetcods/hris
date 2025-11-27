@extends('layouts.admin')

@section('title', 'Detail Pengajuan Cuti')

@section('content')
<div style="padding: 35px;">

    <a href="{{ route('admin.cuti.index') }}" style="color:#38bdf8;">← Kembali</a>

    <div style="margin-top:25px; background:#1e293b; padding:30px; border-radius:14px;">
        <h2 style="color:#38bdf8; font-size:1.6rem; font-weight:700;">
            Detail Pengajuan Cuti
        </h2>

        <div style="margin-top:20px; display:grid; grid-template-columns:1fr 1fr; gap:25px;">

            <div>
                <p style="color:#94a3b8;">Nama Karyawan</p>
                <h3 style="color:#e2e8f0;">{{ $cuti->karyawan->nama }}</h3>
            </div>

            <div>
                <p style="color:#94a3b8;">NIK</p>
                <h3 style="color:#e2e8f0;">{{ $cuti->karyawan->nik }}</h3>
            </div>

            <div>
                <p style="color:#94a3b8;">Tanggal Mulai</p>
                <h3 style="color:#e2e8f0;">{{ $cuti->tanggal_mulai }}</h3>
            </div>

            <div>
                <p style="color:#94a3b8;">Tanggal Selesai</p>
                <h3 style="color:#e2e8f0;">{{ $cuti->tanggal_selesai }}</h3>
            </div>

            <div>
                <p style="color:#94a3b8;">Status</p>
                <h3 style="color:
                    {{ $cuti->status == 'disetujui' ? '#22c55e' : ($cuti->status == 'ditolak' ? '#ef4444' : '#facc15') }}">
                    {{ ucfirst($cuti->status) }}
                </h3>
            </div>

            <div>
                <p style="color:#94a3b8;">Alasan Cuti</p>
                <h3 style="color:#e2e8f0;">{{ $cuti->alasan }}</h3>
            </div>
        </div>

        <div style="margin-top:25px;">
            @if($cuti->status == 'pending')
            <form action="{{ route('admin.cuti.approve', $cuti->id) }}" method="POST" style="display:inline;">
                @csrf
                <button style="background:#22c55e; padding:10px 20px; border:none; border-radius:8px; color:white;">
                    Setujui
                </button>
            </form>

            <form action="{{ route('admin.cuti.reject', $cuti->id) }}" method="POST" style="display:inline;">
                @csrf
                <button style="background:#ef4444; padding:10px 20px; border:none; border-radius:8px; color:white;">
                    Tolak
                </button>
            </form>
            @endif
        </div>

    </div>
</div>
@endsection
