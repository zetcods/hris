@extends('layouts.karyawan')

@section('title', 'Dashboard Karyawan')

@section('content')

<style>
  .card {
    background: linear-gradient(180deg, #1e293b, #0f172a);
    padding: 25px;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.3);
    text-align: center;
    transition: .3s ease;
  }
  .card-title {
    font-size: 1rem;
    color: #38bdf8;
    font-weight: 600;
    text-transform: uppercase;
  }
  .value {
    font-size: 2.1rem;
    color: #f8fafc;
    font-weight: 700;
  }

  .menu-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 25px;
    margin-top: 35px;
  }
  .menu-item {
    background: #1e293b;
    border: 1px solid #334155;
    padding: 25px;
    border-radius: 14px;
    text-align: center;
    transition: .25s ease;
  }
  .menu-item:hover {
    border-color: #38bdf8;
    transform: translateY(-3px);
  }
  .menu-item h3 {
    color: #e2e8f0;
    font-size: 1.3rem;
    margin-bottom: 10px;
    font-weight: 600;
  }
  .menu-item p {
    color: #94a3b8;
    font-size: .95rem;
  }
</style>

<h1 style="font-size: 2.2rem; font-weight: 700; color: #f1f5f9;">
  Halo, {{ Auth::guard('karyawan')->user()->nama }} 
</h1>

<p style="color: #94a3b8; margin-top: 5px;">
  Berikut ringkasan aktivitas dan status Anda di HRIS.
</p>

{{-- ===============================
      CARD STATISTIK
================================= --}}
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 25px; margin-top: 40px;">

  <div class="card">
    <h3 class="card-title">NIK</h3>
    <p class="value">{{ Auth::guard('karyawan')->user()->nik }}</p>
  </div>

  <div class="card">
    <h3 class="card-title">Kuota Cuti</h3>
    <p class="value">{{ Auth::guard('karyawan')->user()->kuota_cuti ?? 12 }} Hari</p>
  </div>

  <div class="card">
    <h3 class="card-title">Total Pengajuan</h3>
    <p class="value">{{ $totalPengajuan ?? 0 }}</p>
  </div>

</div>

{{-- ===============================
      MENU FITUR
================================= --}}
<h2 style="font-size: 1.6rem; color: #f1f5f9; margin-top: 50px; font-weight: 600;">
  Fitur Karyawan
</h2>

<div class="menu-grid">

  <a href="{{ route('karyawan.profile') }}" class="menu-item">
    <h3>Informasi Pribadi</h3>
    <p>Lihat dan perbarui informasi Anda.</p>
  </a>

  <a href="{{ route('karyawan.cuti') }}" class="menu-item">
    <h3>Pengajuan Cuti</h3>
    <p>Ajukan cuti kerja dan lihat histori pengajuan.</p>
  </a>

  <a href="{{ route('karyawan.izin') }}" class="menu-item">
    <h3>Izin / Sakit</h3>
    <p>Ajukan izin tidak masuk atau laporan sakit.</p>
  </a>

  <a href="{{ route('karyawan.lapor') }}" class="menu-item">
    <h3>Lapor Masalah</h3>
    <p>Lapor perilaku tidak wajar atau masalah kerja.</p>
  </a>

</div>

@endsection
