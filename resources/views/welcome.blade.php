@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
  <h1 style="
      font-size:3rem;
      background:linear-gradient(to right,#60a5fa,#a78bfa);
      background-clip:text;
      -webkit-background-clip:text;
      -webkit-text-fill-color:transparent;
    ">
      Selamat Datang di HRIS
  </h1>

  <p style="color:#cbd5e1; max-width:600px; margin:20px auto 40px;">
    Kelola data karyawan, absensi, dan penggajian dengan sistem yang modern dan terintegrasi.
  </p>

  <div style="display:flex; justify-content:center; gap:20px; flex-wrap:wrap;">
    <a href="{{ url('login') }}">
      <button style="
        padding:12px 35px;
        border-radius:30px;
        border:none;
        background:linear-gradient(90deg,#3b82f6,#6366f1);
        color:white;
        font-weight:600;
        cursor:pointer;
        transition:0.3s;
      ">
        Masuk Sekarang
      </button>
    </a>

    <a href="{{ url('about') }}">
      <button style="
        padding:12px 35px;
        border-radius:30px;
        border:2px solid #94a3b8;
        background:transparent;
        color:#e2e8f0;
        font-weight:600;
        cursor:pointer;
        transition:0.3s;
      ">
        Tentang HRIS
      </button>
    </a>
  </div>
@endsection
