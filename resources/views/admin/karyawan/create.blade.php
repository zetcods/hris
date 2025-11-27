@extends('layouts.admin')

@section('title', 'Tambah Karyawan')

@section('content')
<div style="max-width: 800px; margin: 40px auto; background: #1e293b; padding: 35px; border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.25);">
  <h1 style="font-size: 1.8rem; font-weight: 700; color: #38bdf8; margin-bottom: 25px;">Tambah Karyawan Lengkap</h1>

  <form action="{{ route('karyawan.store') }}" method="POST">
    @csrf

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
      
      {{-- KOLOM KIRI --}}
      <div style="display: flex; flex-direction: column; gap: 15px;">
        <div>
          <label for="nik" style="color: #e2e8f0;">NIK</label>
          <input type="text" id="nik" name="nik" class="input" value="{{ $nik ?? '' }}" readonly>
        </div>

        <div>
          <label for="nama" style="color: #e2e8f0;">Nama Lengkap</label>
          <input type="text" id="nama" name="nama" class="input" required>
        </div>

        <div>
          <label for="email" style="color: #e2e8f0;">Email</label>
          <input type="email" id="email" name="email" class="input" required>
        </div>

        <div>
          <label for="no_hp" style="color: #e2e8f0;">No. HP / WhatsApp</label>
          <input type="number" id="no_hp" name="no_hp" class="input" placeholder="08..." required>
        </div>

        <div>
           <label for="jenis_kelamin" style="color: #e2e8f0;">Jenis Kelamin</label>
           <select name="jenis_kelamin" class="input" required>
             <option value="">-- Pilih --</option>
             <option value="L">Laki-laki</option>
             <option value="P">Perempuan</option>
           </select>
        </div>
      </div>

      {{-- KOLOM KANAN --}}
      <div style="display: flex; flex-direction: column; gap: 15px;">
        <div>
          <label for="jabatan" style="color: #e2e8f0;">Jabatan</label>
          <input type="text" id="jabatan" name="jabatan" class="input" required>
        </div>

        <div>
          <label for="divisi_id" style="color: #e2e8f0;">Divisi</label>
          <select id="divisi_id" name="divisi_id" class="input" required>
            <option value="">-- Pilih Divisi --</option>
            @foreach ($divisi as $d)
              <option value="{{ $d->id }}">{{ $d->nama_divisi }}</option>
            @endforeach
          </select>
        </div>

        <div style="display: flex; gap: 10px;">
            <div style="flex: 1;">
                <label for="tempat_lahir" style="color: #e2e8f0;">Tempat Lahir</label>
                <input type="text" name="tempat_lahir" class="input">
            </div>
            <div style="flex: 1;">
                <label for="tanggal_lahir" style="color: #e2e8f0;">Tgl Lahir</label>
                <input type="date" name="tanggal_lahir" class="input">
            </div>
        </div>

        <div>
          <label for="tanggal_masuk" style="color: #e2e8f0;">Tanggal Masuk</label>
          <input type="date" id="tanggal_masuk" name="tanggal_masuk" class="input">
        </div>

        <div>
          <label for="gaji" style="color: #e2e8f0;">Gaji Pokok</label>
          <input type="number" id="gaji" name="gaji" class="input" required>
        </div>
      </div>

    </div>

    {{-- ALAMAT FULL WIDTH --}}
    <div style="margin-top: 15px;">
        <label for="alamat" style="color: #e2e8f0;">Alamat Lengkap</label>
        <textarea name="alamat" class="input" rows="3" placeholder="Jl. Mawar No. 12..." required></textarea>
    </div>

    <div style="margin-top: 25px; display: flex; justify-content: flex-end; gap: 10px;">
      <a href="{{ route('karyawan.index') }}" style="background: #334155; color: #e2e8f0; padding: 10px 20px; border-radius: 8px; text-decoration: none;">Batal</a>
      <button type="submit" class="btn-primary" style="padding: 10px 25px;">Simpan Data</button>
    </div>
  </form>
</div>

<style>
    .input { width: 100%; padding: 10px; border-radius: 8px; background: #0f172a; color: #f1f5f9; border: 1px solid #334155; }
    .input:focus { border-color: #38bdf8; outline: none; }
    .btn-primary { background: linear-gradient(90deg, #38bdf8, #3b82f6); color: #fff; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; }
</style>
@endsection