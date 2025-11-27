@extends('layouts.karyawan')

@section('title', 'Profil Karyawan')

@section('content')

<style>
  .section-box {
    background: #1e293b;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.25);
    margin-bottom: 25px;
    border: 1px solid #334155; /* Tambah border */
  }
  label {
    color: #cbd5e1;
    font-weight: 500;
    margin-bottom: 8px;
    display: block;
  }
  .input {
    width: 100%;
    padding: 12px 16px;
    border-radius: 8px;
    border: 1px solid #334155;
    background: #0f172a;
    color: #e2e8f0;
    margin-bottom: 15px;
  }
  .input:focus {
    border-color: #38bdf8;
    outline: none;
  }
  .btn-save {
    background: #38bdf8;
    border: none;
    padding: 12px 20px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    margin-top: 10px;
    color: #0f172a;
    transition: 0.3s;
  }
  .btn-save:hover {
    background: #0ea5e9;
  }
</style>

<h1 style="font-size: 2rem; font-weight: 700; color: #f1f5f9;">
  Profil Saya
</h1>

<p style="color:#94a3b8;margin-top:5px;margin-bottom:25px;">
  Kelola informasi pribadi dan keamanan akun Anda.
</p>

{{-- =========================================
     FORM 1: INFORMASI PRIBADI (updateInfo)
     ========================================= --}}
<div class="section-box">
  <h3 style="color:#38bdf8;margin-bottom:16px; font-size: 1.2rem;">Informasi Pribadi</h3>

  {{-- ACTION diubah ke updateInfo --}}
  <form action="{{ route('karyawan.updateInfo') }}" method="POST">
    @csrf
    
    <label>Nama Lengkap</label>
    {{-- Tambahkan required --}}
    <input type="text" name="nama" class="input" value="{{ old('nama', Auth::guard('karyawan')->user()->nama) }}" required>

    <label>Email</label>
    <input type="email" name="email" class="input" value="{{ old('email', Auth::guard('karyawan')->user()->email) }}" required>

    <label>Jabatan</label>
    <input type="text" class="input" value="{{ Auth::guard('karyawan')->user()->jabatan }}" disabled style="opacity: 0.6; cursor: not-allowed;">

    <label>Divisi</label>
    <input type="text" class="input" value="{{ Auth::guard('karyawan')->user()->divisi->nama_divisi ?? '-' }}" disabled style="opacity: 0.6; cursor: not-allowed;">
    
    <p style="color:#94a3b8; font-size: 0.9rem; margin-top: 5px;">*NIK: {{ Auth::guard('karyawan')->user()->nik }}. Hubungi Admin untuk ubah jabatan atau divisi.</p>

    <button type="submit" class="btn-save">Simpan Perubahan</button>
  </form>
</div>

{{-- =========================================
     FORM 2: KEAMANAN AKUN (updatePassword)
     ========================================= --}}
<div class="section-box">
  <h3 style="color:#ef4444;margin-bottom:16px; font-size: 1.2rem;">Keamanan Akun</h3>

  {{-- ACTION diubah ke updatePassword --}}
  <form action="{{ route('karyawan.updatePassword') }}" method="POST">
    @csrf

    <label>Password Baru</label>
    <input type="password" name="password" class="input" required>

    <label>Konfirmasi Password</label>
    <input type="password" name="password_confirmation" class="input" required>

    <button type="submit" class="btn-save" style="background:#ef4444; color:white;">Ubah Password</button>
  </form>
</div>

{{-- SweetAlert untuk menampilkan error validasi --}}
@if($errors->any())
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
  let message = '';
  @foreach ($errors->all() as $error)
    message += '• {{ $error }}<br>';
  @endforeach
  
  Swal.fire({
    icon: "error",
    title: "Gagal Menyimpan!",
    html: message,
    background: "#1e293b",
    color: "#e2e8f0",
    confirmButtonColor: "#ef4444",
  });
});
</script>
@endif

@endsection