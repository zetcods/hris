@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div style="display: flex; min-height: 100vh; background: linear-gradient(135deg, #0f172a, #1e293b); color: #e2e8f0;">
  
  {{-- Sidebar --}}
  <aside style="width: 260px; background: #1e293b; padding: 30px 20px; display: flex; flex-direction: column; justify-content: space-between;">
    <div>
      <h2 style="font-size: 1.4rem; font-weight: 700; color: #38bdf8; margin-bottom: 40px;">HRIS Admin</h2>
      <nav style="display: flex; flex-direction: column; gap: 15px;">
        <a href="#" style="color: #cbd5e1; font-weight: 500; text-decoration: none;">🏠 Dashboard</a>
        <a href="#" style="color: #cbd5e1; font-weight: 500; text-decoration: none;">👥 Data Karyawan</a>
        <a href="#" style="color: #cbd5e1; font-weight: 500; text-decoration: none;">📅 Absensi</a>
        <a href="#" style="color: #cbd5e1; font-weight: 500; text-decoration: none;">💰 Penggajian</a>
        <a href="#" style="color: #cbd5e1; font-weight: 500; text-decoration: none;">⚙️ Pengaturan</a>
      </nav>
    </div>

    <form action="{{ route('logout') }}" method="POST" style="margin-top: 40px;">
      @csrf
      <button type="submit" 
        style="background: #ef4444; border: none; padding: 10px 15px; width: 100%; color: #fff; border-radius: 6px; font-weight: 600; cursor: pointer; transition: 0.3s;">
        Keluar
      </button>
    </form>
  </aside>

  {{-- Konten Utama --}}
  <main style="flex: 1; padding: 40px;">
    <h1 style="font-size: 2rem; font-weight: 700; color: #f1f5f9;">Dashboard Admin</h1>
    <p style="color: #94a3b8; margin-top: 5px;">Selamat datang kembali, <strong>{{ Auth::user()->name }}</strong> 👋</p>

    {{-- Statistik --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-top: 40px;">
      <div style="background: #1e293b; padding: 25px; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.2);">
        <h3 style="color: #38bdf8; font-size: 1rem; font-weight: 600;">Total Karyawan</h3>
        <p style="font-size: 2rem; font-weight: 700; margin-top: 10px;">120</p>
      </div>
      <div style="background: #1e293b; padding: 25px; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.2);">
        <h3 style="color: #38bdf8; font-size: 1rem; font-weight: 600;">Total Absensi Hari Ini</h3>
        <p style="font-size: 2rem; font-weight: 700; margin-top: 10px;">98</p>
      </div>
      <div style="background: #1e293b; padding: 25px; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.2);">
        <h3 style="color: #38bdf8; font-size: 1rem; font-weight: 600;">Gaji Bulan Ini</h3>
        <p style="font-size: 2rem; font-weight: 700; margin-top: 10px;">Rp 350jt</p>
      </div>
    </div>
  </main>
</div>
@endsection
