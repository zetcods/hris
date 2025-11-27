@extends('layouts.admin')

@section('title', 'Data Absensi')

@section('content')
<div style="padding: 40px;">
  
  {{-- HEADER: JUDUL & TOMBOL TAMBAH --}}
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h1 style="font-size: 1.9rem; font-weight: 700; color: #f1f5f9;">🕒 Data Absensi</h1>
    <a href="{{ route('absensi.create') }}" 
      style="background: linear-gradient(90deg, #38bdf8, #3b82f6);
             color: #fff; padding: 12px 24px; border-radius: 8px; font-weight: 600;
             text-decoration: none; box-shadow: 0 3px 10px rgba(56,189,248,0.3);
             transition: all .3s ease;">
      + Tambah Absensi
    </a>
  </div>

  {{-- FORM FILTER & CETAK REKAP --}}
  <div style="background: #1e293b; padding: 20px; border-radius: 12px; border: 1px solid #334155; margin-bottom: 35px;">
    <form action="{{ route('absensi.print') }}" method="GET" target="_blank" style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap;">
        
        <label style="color: #cbd5e1; font-weight: 600;">🖨️ Cetak Rekap Bulanan:</label>

        {{-- Pilih Bulan --}}
        <select name="bulan" style="padding: 10px; border-radius: 8px; background: #0f172a; color: white; border: 1px solid #475569; outline: none;">
            @foreach(range(1, 12) as $m)
                <option value="{{ $m }}" {{ date('m') == $m ? 'selected' : '' }}>
                    {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                </option>
            @endforeach
        </select>

        {{-- Pilih Tahun --}}
        <select name="tahun" style="padding: 10px; border-radius: 8px; background: #0f172a; color: white; border: 1px solid #475569; outline: none;">
            @foreach(range(date('Y'), 2023) as $y)
                <option value="{{ $y }}" {{ date('Y') == $y ? 'selected' : '' }}>{{ $y }}</option>
            @endforeach
        </select>

        <button type="submit" 
            style="background: #10b981; color: white; padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; transition: .3s; display: flex; align-items: center; gap: 8px;">
            <span>Cetak</span>
        </button>
    </form>
  </div>

  {{-- TABLE --}}
  <div style="background: #1e293b; border-radius: 12px; overflow: hidden; box-shadow: 0 6px 25px rgba(0,0,0,0.35);">
    <table style="width: 100%; border-collapse: collapse;">
      <thead>
        <tr style="background: #111827; color: #38bdf8; text-align: left; font-size: 0.95rem;">
          <th style="padding: 14px 16px;">Nama Karyawan</th>
          <th>Tanggal</th>
          <th>Status</th>
          <th>Keterangan</th>
          <th style="text-align: center;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($absensi as $a)
        <tr style="background: #0f172a; color: #e2e8f0; border-top: 1px solid #1e293b;">
          <td style="padding: 12px 16px;">{{ $a->karyawan->nama ?? '-' }}</td>
          <td>{{ \Carbon\Carbon::parse($a->tanggal)->translatedFormat('d F Y') }}</td>

          {{-- STATUS DENGAN WARNA TRANSPARAN --}}
          <td>
            @php
              $warna = match($a->status) {
                'Hadir' => 'rgba(16, 185, 129, 0.25)',   // Hijau lembut
                'Sakit' => 'rgba(245, 158, 11, 0.25)',   // Kuning lembut
                'Izin' => 'rgba(59, 130, 246, 0.25)',    // Biru lembut
                'Cuti' => 'rgba(56, 189, 248, 0.25)',    // Cyan lembut
                'Alpha' => 'rgba(239, 68, 68, 0.25)',    // Merah lembut
                default => 'rgba(148, 163, 184, 0.25)',  // Abu lembut
              };

              $border = match($a->status) {
                'Hadir' => '#10b981',
                'Sakit' => '#f59e0b',
                'Izin' => '#3b82f6',
                'Cuti' => '#38bdf8',
                'Alpha' => '#ef4444',
                default => '#94a3b8',
              };
            @endphp

            <span style="
              background: {{ $warna }};
              border: 1px solid {{ $border }};
              color: {{ $border }};
              font-weight: 600;
              padding: 6px 14px;
              border-radius: 20px;
              font-size: 0.85rem;
              text-transform: uppercase;
              backdrop-filter: blur(6px);
              box-shadow: inset 0 0 5px rgba(255,255,255,0.1);
              transition: 0.3s ease;
            ">
              {{ $a->status }}
            </span>
          </td>

          <td>{{ $a->keterangan ?? '-' }}</td>
          <td style="text-align: center;">
            <a href="{{ route('absensi.edit', $a->id) }}" 
               style="background: #2563eb; color: #fff; padding: 6px 12px; border-radius: 6px;
                      text-decoration: none; font-weight: 600; margin-right: 5px;
                      font-size: 0.9rem; box-shadow: 0 2px 5px rgba(37,99,235,0.4); transition: .3s;">
               ✏️ Edit
            </a>
            <button type="button" class="btn-delete" data-id="{{ $a->id }}"
              style="background: #ef4444; color: #fff; padding: 6px 12px; border-radius: 6px;
                     border: none; font-weight: 600; cursor: pointer; font-size: 0.9rem;
                     box-shadow: 0 2px 5px rgba(239,68,68,0.4); transition: .3s;">
              🗑️ Hapus
            </button>
            <form id="delete-form-{{ $a->id }}" action="{{ route('absensi.destroy', $a->id) }}" method="POST" style="display: none;">
              @csrf
              @method('DELETE')
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="5" style="text-align:center; padding: 25px; color: #94a3b8;">Belum ada data absensi 😅</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

{{-- SWEETALERT --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelectorAll('.btn-delete').forEach(btn => {
  btn.addEventListener('click', function() {
    const id = this.dataset.id;
    Swal.fire({
      title: 'Yakin ingin menghapus?',
      text: "Data absensi akan hilang permanen!",
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