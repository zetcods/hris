@extends('layouts.admin')

@section('title', 'Edit Karyawan')

@section('content')
<div style="max-width: 800px; margin: 40px auto; background: #1e293b; padding: 35px; border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.25);">
  <h1 style="font-size: 1.8rem; font-weight: 700; color: #38bdf8; margin-bottom: 25px;">✏️ Edit Karyawan</h1>

  {{-- FORM EDIT KARYAWAN --}}
  <form action="{{ route('karyawan.update', $karyawan->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
      
      {{-- KOLOM KIRI --}}
      <div style="display: flex; flex-direction: column; gap: 15px;">
        <div>
          <label style="color: #e2e8f0;">Nama Lengkap</label>
          <input type="text" name="nama" value="{{ old('nama', $karyawan->nama) }}" class="input" required>
        </div>

        <div>
          <label style="color: #e2e8f0;">Email</label>
          <input type="email" name="email" value="{{ old('email', $karyawan->email) }}" class="input" required>
        </div>

        <div>
          <label style="color: #e2e8f0;">No. HP</label>
          <input type="number" name="no_hp" value="{{ old('no_hp', $karyawan->no_hp) }}" class="input" required>
        </div>

        <div>
           <label style="color: #e2e8f0;">Jenis Kelamin</label>
           <select name="jenis_kelamin" class="input" required>
             <option value="L" {{ $karyawan->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
             <option value="P" {{ $karyawan->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
           </select>
        </div>
        
      </div>

      {{-- KOLOM KANAN --}}
      <div style="display: flex; flex-direction: column; gap: 15px;">
        <div>
          <label style="color: #e2e8f0;">Jabatan</label>
          <input type="text" name="jabatan" value="{{ old('jabatan', $karyawan->jabatan) }}" class="input" required>
        </div>

        <div>
          <label style="color: #e2e8f0;">Divisi</label>
          <select name="divisi_id" class="input" required>
            @foreach ($divisi as $d)
              <option value="{{ $d->id }}" {{ $karyawan->divisi_id == $d->id ? 'selected' : '' }}>
                {{ $d->nama_divisi }}
              </option>
            @endforeach
          </select>
        </div>

        <div style="display: flex; gap: 10px;">
            <div style="flex: 1;">
                <label style="color: #e2e8f0;">Tempat Lahir</label>
                <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $karyawan->tempat_lahir) }}" class="input">
            </div>
            <div style="flex: 1;">
                <label style="color: #e2e8f0;">Tgl Lahir</label>
                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $karyawan->tanggal_lahir ? $karyawan->tanggal_lahir->format('Y-m-d') : '') }}" class="input">
            </div>
        </div>
        
        {{-- FIELD YANG HILANG: TANGGAL MASUK --}}
        <div>
          <label style="color: #e2e8f0;">Tanggal Masuk</label>
          <input type="date" name="tanggal_masuk" 
                 value="{{ old('tanggal_masuk', $karyawan->tanggal_masuk ? $karyawan->tanggal_masuk->format('Y-m-d') : '') }}" 
                 class="input">
        </div>
        {{-- END FIELD YANG HILANG --}}

        <div>
          <label style="color: #e2e8f0;">Gaji Pokok</label>
          <input type="number" name="gaji" value="{{ old('gaji', $karyawan->gaji) }}" class="input" required>
        </div>
      </div>

    </div>

    {{-- ALAMAT FULL WIDTH --}}
    <div style="margin-top: 15px;">
        <label style="color: #e2e8f0;">Alamat Lengkap</label>
        <textarea name="alamat" class="input" rows="3" required>{{ old('alamat', $karyawan->alamat) }}</textarea>
    </div>

    <div style="margin-top: 25px; display: flex; justify-content: flex-end; gap: 10px;">
      <a href="{{ route('karyawan.index') }}" style="background: #334155; color: #e2e8f0; padding: 10px 20px; border-radius: 8px; text-decoration: none;">Batal</a>
      <button type="submit" class="btn-primary" style="padding: 10px 25px;">Update Data</button>
    </div>
  </form>
</div>

<style>
    .input { width: 100%; padding: 10px; border-radius: 8px; background: #0f172a; color: #f1f5f9; border: 1px solid #334155; }
    .input:focus { border-color: #38bdf8; outline: none; }
    .btn-primary { background: linear-gradient(90deg, #38bdf8, #3b82f6); color: #fff; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; }
</style>

{{-- ALERT SUCCESS (Copy dari file sebelumnya) --}}
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