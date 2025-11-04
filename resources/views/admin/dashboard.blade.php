@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
  <h1 style="font-size: 2rem; font-weight: 700; color: #f1f5f9;">Selamat Datang, {{ Auth::user()->name }} 👋</h1>
  <p style="color: #94a3b8; margin-top: 5px;">Berikut ringkasan sistem HRIS hari ini:</p>

  <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 25px; margin-top: 40px;">
    <div style="background: #1e293b; padding: 25px; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.2);">
      <h3 style="color: #38bdf8; font-size: 1rem; font-weight: 600;">Total Karyawan</h3>
      <p style="font-size: 2rem; font-weight: 700; margin-top: 10px;">120</p>
    </div>

    <div style="background: #1e293b; padding: 25px; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.2);">
      <h3 style="color: #38bdf8; font-size: 1rem; font-weight: 600;">Absensi Hari Ini</h3>
      <p style="font-size: 2rem; font-weight: 700; margin-top: 10px;">98</p>
    </div>

    <div style="background: #1e293b; padding: 25px; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.2);">
      <h3 style="color: #38bdf8; font-size: 1rem; font-weight: 600;">Total Gaji Bulan Ini</h3>
      <p style="font-size: 2rem; font-weight: 700; margin-top: 10px;">Rp 350jt</p>
    </div>
  </div>
@endsection
