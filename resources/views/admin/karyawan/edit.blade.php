@extends('layouts.admin')

@section('title', 'Edit Karyawan')

@section('content')
<div style="max-width: 700px; margin: 40px auto; background: #1e293b; padding: 35px; border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.25);">
  <h1 style="font-size: 1.8rem; font-weight: 700; color: #38bdf8; margin-bottom: 25px;">✏️ Edit Karyawan</h1>

  {{-- FORM EDIT KARYAWAN --}}
  <form action="{{ route('karyawan.update', $karyawan->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div style="display: flex; flex-direction: column; gap: 18px;">
      {{-- NAMA --}}
      <div>
        <label for="nama" style="color: #e2e8f0; font-weight: 500;">Nama Lengkap</label>
        <input type="text" id="nama" name="nama" value="{{ old('nama', $karyawan->nama) }}" class="input" required>
      </div>

      {{-- EMAIL --}}
      <div>
        <label for="email" style="color: #e2e8f0; font-weight: 500;">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email', $karyawan->email) }}" class="input" required>
      </div>

      {{-- JABATAN --}}
      <div>
        <label for="jabatan" style="color: #e2e8f0; font-weight: 500;">Jabatan</label>
        <input type="text" id="jabatan" name="jabatan" value="{{ old('jabatan', $karyawan->jabatan) }}" class="input" required>
      </div>

      {{-- DIVISI (Dropdown dari Database) --}}
      <div>
        <label for="divisi_id" style="color: #e2e8f0; font-weight: 500;">Divisi</label>
        <select id="divisi_id" name="divisi_id" class="input" required>
          <option value="">-- Pilih Divisi --</option>
          @foreach ($divisi as $d)
            <option value="{{ $d->id }}" {{ $karyawan->divisi_id == $d->id ? 'selected' : '' }}>
              {{ $d->nama_divisi }}
            </option>
          @endforeach
        </select>
      </div>

      {{-- TANGGAL MASUK --}}
      <div>
        <label for="tanggal_masuk" style="color: #e2e8f0; font-weight: 500;">Tanggal Masuk</label>
        <input type="date" id="tanggal_masuk" name="tanggal_masuk" 
               value="{{ old('tanggal_masuk', $karyawan->tanggal_masuk) }}" class="input">
      </div>

      {{-- GAJI --}}
      <div>
        <label for="gaji" style="color: #e2e8f0; font-weight: 500;">Gaji</label>
        <input type="number" id="gaji" name="gaji" value="{{ old('gaji', $karyawan->gaji) }}" class="input" required>
      </div>
    </div>

    {{-- BUTTON --}}
    <div style="margin-top: 25px; display: flex; justify-content: flex-end; gap: 10px;">
      <a href="{{ route('karyawan.index') }}" 
         style="background: #334155; color: #e2e8f0; padding: 10px 20px; border-radius: 8px;
                text-decoration: none; font-weight: 500; transition: .3s;">
         Batal
      </a>
      <button type="submit" 
              style="background: linear-gradient(90deg, #38bdf8, #3b82f6); color: #fff;
                     padding: 10px 25px; border: none; border-radius: 8px; font-weight: 600;
                     cursor: pointer; transition: .3s;">
        Simpan Perubahan
      </button>
    </div>
  </form>
</div>

{{-- ALERT SUCCESS --}}
@if(session('success'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
Swal.fire({
  icon: 'success',
  title: 'Berhasil!',
  text: "{{ session('success') }}",
  showConfirmButton: false,
  timer: 1600,
  background: '#1e293b',
  color: '#e2e8f0'
});
</script>
@endif
@endsection
