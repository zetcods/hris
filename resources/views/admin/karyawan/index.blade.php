@extends('layouts.admin')

@section('title', 'Data Karyawan')

@section('content')
<div style="padding: 40px;">
  {{-- HEADER --}}
  <div style="display: flex; justify-content: space-between; align-items: center;">
    <h1 style="font-size: 1.9rem; font-weight: 700; color: #f1f5f9;">
      👥 Data Karyawan
    </h1>
    <a href="{{ route('karyawan.create') }}" 
      style="background: linear-gradient(90deg, #38bdf8, #3b82f6);
             color: #fff; padding: 12px 24px; border-radius: 8px; font-weight: 600;
             text-decoration: none; box-shadow: 0 3px 10px rgba(56,189,248,0.3);
             transition: all .3s ease;">
      + Tambah Karyawan
    </a>
  </div>

  {{-- TABLE CONTAINER --}}
  <div style="margin-top: 35px; background: #1e293b; border-radius: 12px; overflow: hidden; box-shadow: 0 6px 25px rgba(0,0,0,0.35);">
    <table style="width: 100%; border-collapse: collapse;">
      <thead>
        <tr style="background: #111827; color: #38bdf8; text-align: left; font-size: 0.95rem;">
          <th style="padding: 14px 16px;">Nama</th>
          <th>Email</th>
          <th>Jabatan</th>
          <th>Divisi</th>
          <th>Tanggal Masuk</th>
          <th>Gaji</th>
          <th style="text-align: center;">Aksi</th>
        </tr>
      </thead>
      <tbody>
  @foreach ($karyawan as $k)
    @php
      $rowColor = $loop->odd ? '#0f172a' : '#162033';
    @endphp
    <tr 
      style="background: {{ $rowColor }}; color: #e2e8f0; border-top: 1px solid #1e293b; transition: all .25s ease;"
      onmouseover="this.style.background='#1e293b';"
      onmouseout="this.style.background='{{ $rowColor }}';"
    >
      <td style="padding: 12px 16px; font-weight: 500;">{{ $k->nama }}</td>
      <td>{{ $k->email }}</td>
      <td>{{ $k->jabatan }}</td>
      <td>{{ $k->divisi->nama_divisi ?? '-' }}</td>
      <td>{{ \Carbon\Carbon::parse($k->tanggal_masuk)->translatedFormat('d F Y') }}</td>
      <td>Rp {{ number_format($k->gaji, 0, ',', '.') }}</td>
      <td style="text-align: center;">
        <a href="{{ route('karyawan.edit', $k->id) }}" 
           style="background: #2563eb; color: #fff; padding: 6px 12px; border-radius: 6px;
                  text-decoration: none; font-weight: 600; margin-right: 5px; font-size: 0.9rem;
                  box-shadow: 0 2px 5px rgba(37,99,235,0.4); transition: .3s;">
           ✏️ Edit
        </a>
        <button 
          type="button" 
          class="btn-delete" 
          data-id="{{ $k->id }}"
          style="background: #ef4444; color: #fff; padding: 6px 12px; border-radius: 6px;
                 border: none; font-weight: 600; cursor: pointer; font-size: 0.9rem;
                 box-shadow: 0 2px 5px rgba(239,68,68,0.4); transition: .3s;">
          🗑️ Hapus
        </button>
        <form id="delete-form-{{ $k->id }}" 
              action="{{ route('karyawan.destroy', $k->id) }}" 
              method="POST" style="display: none;">
          @csrf
          @method('DELETE')
        </form>
      </td>
    </tr>
  @endforeach
</tbody>

    </table>
  </div>
</div>

{{-- SWEETALERT2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelectorAll('.btn-delete').forEach(btn => {
  btn.addEventListener('click', function() {
    const id = this.dataset.id;
    Swal.fire({
      title: 'Yakin ingin menghapus?',
      text: "Data karyawan akan hilang permanen!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#ef4444',
      cancelButtonColor: '#6b7280',
      confirmButtonText: 'Ya, hapus!',
      cancelButtonText: 'Batal',
      background: '#1e293b',
      color: '#e2e8f0'
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById(`delete-form-${id}`).submit();
      }
    });
  });
});
</script>

{{-- ALERT SUCCESS --}}
@if(session('success'))
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
