@extends('layouts.admin')

@section('title', 'Data Karyawan')

@section('content')
<div style="padding: 40px;">
  
  {{-- HEADER --}}
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
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

  {{-- SEARCH & FILTER --}}
  <div style="background: #1e293b; padding: 20px; border-radius: 12px; margin-bottom: 25px; border: 1px solid #334155;">
    <form action="{{ route('karyawan.index') }}" method="GET" style="display: flex; gap: 15px; flex-wrap: wrap; align-items: center;">
        
        {{-- Input Search --}}
        <div style="flex: 1; min-width: 200px;">
            <input type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Cari Nama, NIK, atau Email..." 
                    style="width: 100%; padding: 12px 15px; border-radius: 8px; background: #0f172a; border: 1px solid #475569; color: #fff; outline: none;">
        </div>

        {{-- Dropdown Divisi --}}
        <div style="min-width: 200px;">
            <select name="divisi_id" style="width: 100%; padding: 12px 15px; border-radius: 8px; background: #0f172a; border: 1px solid #475569; color: #fff; outline: none; cursor: pointer;">
                <option value="">Semua Divisi</option>
                @foreach($divisi as $d)
                    <option value="{{ $d->id }}" {{ request('divisi_id') == $d->id ? 'selected' : '' }}>
                        {{ $d->nama_divisi }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Tombol Cari --}}
        <button type="submit" style="background: #38bdf8; color: #0f172a; padding: 12px 25px; border-radius: 8px; font-weight: 600; border: none; cursor: pointer; transition: .3s;">
            🔍 Cari
        </button>

        {{-- Tombol Reset --}}
        @if(request('search') || request('divisi_id'))
            <a href="{{ route('karyawan.index') }}" style="background: #ef4444; color: #fff; padding: 12px 20px; border-radius: 8px; font-weight: 600; text-decoration: none; display: flex; align-items: center;">
                ✖ Reset
            </a>
        @endif
    </form>
  </div>

  {{-- TABLE --}}
  <div style="background: #1e293b; border-radius: 12px; overflow: hidden; box-shadow: 0 6px 25px rgba(0,0,0,0.35);">
    <table style="width: 100%; border-collapse: collapse;">
      <thead>
        <tr style="background: #111827; color: #38bdf8; text-align: left; font-size: 0.95rem;">
          <th style="padding: 14px 16px;">NIK</th>
          <th>Nama & Email</th>
          <th>Divisi</th>
          <th>Jabatan</th>
          <th>No. HP</th>
          <th style="text-align: center;">Aksi</th>
        </tr>
      </thead>

      <tbody>
        @forelse ($karyawan as $k)
          @php $rowColor = $loop->odd ? '#0f172a' : '#162033'; @endphp

          <tr 
            style="background: {{ $rowColor }}; color: #e2e8f0; border-top: 1px solid #1e293b; transition: 0.25s;"
            onmouseover="this.style.background='#1e293b';"
            onmouseout="this.style.background='{{ $rowColor }}';">

            <td style="padding: 12px 16px; font-weight: 600;">{{ $k->nik }}</td>
            
            <td style="padding: 12px 16px;">
                <div style="font-weight: 600; font-size: 1rem;">{{ $k->nama }}</div>
                <div style="font-size: 0.85rem; color: #94a3b8; margin-top: 2px;">{{ $k->email }}</div>
            </td>
            
            <td>
                <span style="background: rgba(56,189,248,0.1); color: #38bdf8; padding: 4px 10px; border-radius: 6px; font-size: 0.85rem; border: 1px solid rgba(56,189,248,0.2);">
                    {{ $k->divisi->nama_divisi ?? '-' }}
                </span>
            </td>

            <td>{{ $k->jabatan }}</td>
            <td>{{ $k->no_hp ?? '-' }}</td>

            {{-- AKSI --}}
            <td style="text-align: center; padding: 12px;">
              <div style="display: flex; justify-content: center; gap: 8px;">
                  
                  {{-- Detail --}}
                  <a href="{{ route('karyawan.show', $k->id) }}" 
                      style="background: #0ea5e9; color: #fff; padding: 8px 12px; border-radius: 6px; text-decoration: none; font-size: 0.9rem;" 
                      title="Lihat Detail">
                      📄
                  </a>

                  {{-- Edit --}}
                  <a href="{{ route('karyawan.edit', $k->id) }}" 
                      style="background: #eab308; color: #fff; padding: 8px 12px; border-radius: 6px; text-decoration: none; font-size: 0.9rem;" 
                      title="Edit Data">
                      ✏️
                  </a>

                  {{-- Delete --}}
                  <button type="button" class="btn-delete" data-id="{{ $k->id }}" 
                      style="background: #ef4444; color: #fff; padding: 8px 12px; border-radius: 6px; border: none; cursor: pointer; font-size: 0.9rem;" 
                      title="Hapus Data">
                      🗑️
                  </button>
              </div>

              <form id="delete-form-{{ $k->id }}" action="{{ route('karyawan.destroy', $k->id) }}" method="POST" style="display: none;">
                @csrf @method('DELETE')
              </form>
            </td>
          </tr>

        @empty
          <tr>
            <td colspan="6" style="padding: 50px; text-align: center; color: #94a3b8;">
                @php
                    $isFiltered = request('search') || request('divisi_id');
                @endphp

                @if ($totalKaryawan == 0)
                    {{-- KONDISI 1: Database kosong --}}
                    <div style="font-size: 3rem; margin-bottom: 10px;">💾</div>
                    <h3 style="font-size: 1.2rem; color: #cbd5e1;">Belum Ada Data Karyawan</h3>
                    <p>Silakan klik tombol "+ Tambah Karyawan" di atas untuk memulai.</p>
                @elseif ($isFiltered)
                    {{-- KONDISI 2: Data ada, tapi search/filter tidak menemukan hasil --}}
                    <div style="font-size: 3rem; margin-bottom: 10px;">🕵️‍♂️</div>
                    <h3 style="font-size: 1.2rem; color: #cbd5e1;">Data Tidak Ditemukan</h3>
                    <p>Coba kata kunci lain, ganti Divisi, atau klik **Reset** di atas.</p>
                @endif
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

{{-- SCRIPT SWEETALERT DELETE --}}
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

{{-- ALERT SUCCESS & ERROR --}}
@if(session('success'))
<script>
Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}", showConfirmButton: false, timer: 1600, background: '#1e293b', color: '#e2e8f0' });
</script>
@endif

@if(session('error'))
<script>
Swal.fire({ icon: 'error', title: 'Gagal!', text: "{{ session('error') }}", background: '#1e293b', color: '#e2e8f0', confirmButtonColor: '#ef4444' });
</script>
@endif

@endsection