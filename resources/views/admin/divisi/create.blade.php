@extends('layouts.admin')

@section('title', 'Tambah Divisi')

@section('content')
<div class="p-6" style="max-width: 600px;">
  <h1 style="font-size: 1.8rem; font-weight: 700; color: #f1f5f9;">Tambah Divisi</h1>

  <form action="{{ route('divisi.store') }}" method="POST" style="margin-top: 30px;">
    @csrf
    <input type="text" name="nama_divisi" placeholder="Nama Divisi" required class="input">
    @error('nama_divisi')
      <p style="color:#ef4444; margin-top:4px;">{{ $message }}</p>
    @enderror

    <button type="submit" class="btn-primary" style="margin-top: 15px;">Simpan</button>
    <a href="{{ route('divisi.index') }}" class="btn-outline" style="margin-left: 10px;">Batal</a>
  </form>
</div>
@endsection
