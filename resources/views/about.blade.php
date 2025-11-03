@extends('layouts.app')

@section('title', 'Tentang HRIS')

@section('content')
  <h1 style="font-size:2.8rem; margin-bottom:20px;
      background:linear-gradient(to right,#60a5fa,#a78bfa);
      -webkit-background-clip:text; -webkit-text-fill-color:transparent;">
      Tentang HRIS
  </h1>

  <p style="max-width:700px; color:#cbd5e1; line-height:1.7; margin-bottom:40px;">
    HRIS (Human Resource Information System) adalah sistem manajemen sumber daya manusia berbasis web
    yang membantu perusahaan dalam mengelola data karyawan, absensi, penggajian, dan penilaian kinerja secara efisien.
    <br><br>
    Dengan desain modern dan antarmuka yang intuitif, HRIS mempermudah tim HR untuk memantau aktivitas SDM
    secara real-time dan akurat.
  </p>

  <a href="{{ url('/') }}">
    <button style="padding:12px 35px; border-radius:30px; border:none;
      background:linear-gradient(90deg,#3b82f6,#6366f1); color:white; font-weight:600; cursor:pointer;">
      ← Kembali ke Beranda
    </button>
  </a>
@endsection
