@extends('layouts.karyawan')

@section('title', 'Pengajuan Cuti')

@section('content')

<style>
  .box {
    background:#1e293b;
    padding:30px;
    border-radius:16px;
    box-shadow:0 4px 20px rgba(0,0,0,0.25);
    margin-bottom:25px;
    border: 1px solid #334155;
  }
  label { color:#cbd5e1; font-weight:500; margin-bottom:8px; display:block; }
  .input {
    width:100%; padding:12px; border-radius:8px;
    border:1px solid #334155; background:#0f172a; color:#e2e8f0;
    margin-bottom:15px;
  }
  .btn {
    background:#38bdf8; border:none; padding:12px 20px;
    border-radius:8px; font-weight:600; cursor:pointer;
  }
  table {
    width:100%; border-collapse:collapse; margin-top:20px;
  }
  th, td {
    padding:12px; border-bottom:1px solid #334155;
  }
  th { color:#38bdf8; text-align:left; }
  td { color:#e2e8f0; }
  .status-badge {
    padding: 4px 10px; border-radius: 6px; font-size: 0.85rem; font-weight: 600;
  }
</style>

<h1 style="font-size:2rem;font-weight:700;color:#f1f5f9;">Pengajuan Cuti</h1>
<p style="color:#94a3b8;margin-bottom:25px;">Ajukan cuti dan lihat riwayat pengajuan Anda. **Sisa Kuota: {{ Auth::guard('karyawan')->user()->kuota_cuti ?? 12 }} Hari**</p>

<div class="box">
  {{-- ACTION FORM DIARAHKAN KE STORE METHOD --}}
  <form action="{{ route('karyawan.cuti.store') }}" method="POST">
    @csrf

    <label>Tanggal Mulai</label>
    <input type="date" name="tanggal_mulai" class="input" value="{{ old('tanggal_mulai') }}" required>

    <label>Tanggal Selesai</label>
    <input type="date" name="tanggal_selesai" class="input" value="{{ old('tanggal_selesai') }}" required>

    <label>Alasan Cuti</label>
    <textarea name="alasan" class="input" rows="4" required>{{ old('alasan') }}</textarea>

    <button type="submit" class="btn">Ajukan Cuti</button>
  </form>
</div>

<div class="box">
  <h3 style="color:#38bdf8;margin-bottom:15px;">Riwayat Pengajuan Cuti</h3>

  <table>
    <thead>
      <tr>
        <th>Tanggal Mulai</th>
        <th>Tanggal Selesai</th>
        <th>Durasi</th>
        <th>Alasan</th>
        <th>Status</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($data as $item)
      <tr>
        <td>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}</td>
        <td>{{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}</td>
        <td>
            @php
                // Hitung durasi
                $mulai = \Carbon\Carbon::parse($item->tanggal_mulai);
                $selesai = \Carbon\Carbon::parse($item->tanggal_selesai);
                $durasi = $mulai->diffInDays($selesai) + 1;
            @endphp
            {{ $durasi }} Hari
        </td>
        <td>{{ $item->alasan }}</td>
        <td>
          @php
            $statusColor = match($item->status) {
              'menunggu' => ['bg' => '#fbbf2420', 'text' => '#fbbf24'],
              'disetujui' => ['bg' => '#38bdf820', 'text' => '#38bdf8'],
              'ditolak' => ['bg' => '#ef444420', 'text' => '#ef4444'],
            };
          @endphp
          <span class="status-badge" style="background: {{ $statusColor['bg'] }}; color: {{ $statusColor['text'] }}; border: 1px solid {{ $statusColor['text'] }}">
            {{ ucfirst($item->status) }}
          </span>
        </td>
        <td>
            {{-- Tombol Hapus hanya jika status masih menunggu --}}
            @if($item->status == 'menunggu')
                <button 
                  onclick="confirmDelete('cuti-{{ $item->id }}')"
                  style="background: #ef4444; color: white; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-size: 0.85rem;">
                  Batalkan
                </button>
                <form id="cuti-{{ $item->id }}" action="{{ route('karyawan.cuti.destroy', $item->id) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            @else
                -
            @endif
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="6" style="text-align:center; color:#94a3b8;">Belum ada riwayat pengajuan cuti.</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>

{{-- Script SweetAlert Konfirmasi Hapus --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(formId) {
        Swal.fire({
            title: 'Yakin ingin membatalkan?',
            text: "Pengajuan ini akan dihapus dari sistem.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, batalkan!',
            cancelButtonText: 'Tutup',
            background: '#1e293b',
            color: '#e2e8f0'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(formId).submit();
            }
        });
    }
</script>

@endsection