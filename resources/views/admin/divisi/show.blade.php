@extends('layouts.admin')

@section('title', 'Detail Divisi')

@section('content')
<div style="padding: 40px;">
  {{-- HEADER --}}
  <div style="display: flex; justify-content: space-between; align-items: center;">
    <div>
      <h1 style="font-size: 1.8rem; font-weight: 700; color: #38bdf8;">🏢 {{ $divisi->nama_divisi }}</h1>
      <p style="color: #94a3b8; margin-top: 6px;">
        Total Karyawan: 
        <span style="color: #38bdf8; font-weight: 600;">
          {{ $divisi->karyawan->count() }}
        </span>
      </p>
    </div>
    <a href="{{ route('divisi.index') }}" 
      style="background: #334155; color: #e2e8f0; padding: 10px 20px; border-radius: 8px;
             text-decoration: none; font-weight: 600; transition: all .3s;">
      ⬅ Kembali
    </a>
  </div>

  {{-- LIST KARYAWAN --}}
  <div style="margin-top: 30px; background: #1e293b; border-radius: 10px; overflow: hidden;
              box-shadow: 0 4px 20px rgba(0,0,0,0.25);">
    <table style="width: 100%; border-collapse: collapse;">
      <thead>
        <tr style="background: #111827; color: #38bdf8; text-align: left;">
          <th style="padding: 14px 16px;">Nama</th>
          <th>Email</th>
          <th>Jabatan</th>
          <th>Tanggal Masuk</th>
          <th>Gaji</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($divisi->karyawan as $k)
          @php
            $rowColor = $loop->odd ? '#0f172a' : '#162033';
          @endphp
          <tr style="background: {{ $rowColor }}; color: #e2e8f0; transition: all .3s;"
              onmouseover="this.style.background='#1e293b';"
              onmouseout="this.style.background='{{ $rowColor }}';">
            <td style="padding: 12px 16px; font-weight: 500;">{{ $k->nama }}</td>
            <td>{{ $k->email }}</td>
            <td>{{ $k->jabatan }}</td>
            <td>{{ \Carbon\Carbon::parse($k->tanggal_masuk)->translatedFormat('d F Y') }}</td>
            <td>Rp {{ number_format($k->gaji, 0, ',', '.') }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="5" style="text-align:center; padding: 25px; color: #94a3b8;">
              Belum ada karyawan di divisi ini 😅
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
