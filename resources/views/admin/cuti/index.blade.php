@extends('layouts.admin')

@section('title', 'Kelola Pengajuan Cuti')

@section('content')
<div style="padding: 40px;">
  {{-- HEADER --}}
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 35px;">
    <h1 style="font-size: 1.9rem; font-weight: 700; color: #f1f5f9;">📅 Kelola Pengajuan Cuti</h1>
  </div>

  {{-- TABLE CONTAINER --}}
  <div style="background: #1e293b; border-radius: 12px; overflow: hidden; box-shadow: 0 6px 25px rgba(0,0,0,0.35);">
    <table style="width: 100%; border-collapse: collapse;">
      <thead>
        <tr style="background: #111827; color: #38bdf8; text-align: left; font-size: 0.95rem;">
          <th style="padding: 16px;">No</th>
          <th style="padding: 16px;">Nama Karyawan</th>
          <th style="padding: 16px;">Tanggal Cuti</th>
          <th style="padding: 16px;">Alasan</th>
          <th style="padding: 16px;">Status</th>
          <th style="padding: 16px; text-align: center;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($cuti as $item)
        <tr style="background: #0f172a; color: #e2e8f0; border-top: 1px solid #1e293b; transition: 0.2s;">
          <td style="padding: 16px;">{{ $loop->iteration }}</td>
          <td style="padding: 16px; font-weight: 600;">
            {{ $item->karyawan->nama }}
            <div style="font-size: 0.8rem; color: #94a3b8; font-weight: 400;">{{ $item->karyawan->divisi->nama_divisi ?? '-' }}</div>
          </td>
          <td style="padding: 16px;">
            {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M') }} - 
            {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}
          </td>
          <td style="padding: 16px;">{{ $item->alasan }}</td>
          
          {{-- STATUS BADGE --}}
          <td style="padding: 16px;">
            @php
              $statusConfig = match($item->status) {
                'menunggu'  => ['bg' => 'rgba(245, 158, 11, 0.2)', 'border' => '#f59e0b', 'color' => '#f59e0b'],
                'disetujui' => ['bg' => 'rgba(16, 185, 129, 0.2)', 'border' => '#10b981', 'color' => '#10b981'],
                'ditolak'   => ['bg' => 'rgba(239, 68, 68, 0.2)',  'border' => '#ef4444', 'color' => '#ef4444'],
                default     => ['bg' => 'rgba(148, 163, 184, 0.2)','border' => '#94a3b8', 'color' => '#94a3b8'],
              };
            @endphp
            <span style="
              background: {{ $statusConfig['bg'] }};
              border: 1px solid {{ $statusConfig['border'] }};
              color: {{ $statusConfig['color'] }};
              padding: 6px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;
              text-transform: uppercase; box-shadow: 0 0 10px {{ $statusConfig['bg'] }};
            ">
              {{ $item->status }}
            </span>
          </td>

          {{-- AKSI --}}
          <td style="padding: 16px; text-align: center;">
            @if($item->status == 'menunggu')
            <div style="display: flex; justify-content: center; gap: 8px;">
                <form action="{{ route('admin.cuti.approve', $item->id) }}" method="POST" class="action-form">
                    @csrf
                    <button type="button" class="btn-action btn-approve">✔ Terima</button>
                </form>
                <form action="{{ route('admin.cuti.reject', $item->id) }}" method="POST" class="action-form">
                    @csrf
                    <button type="button" class="btn-action btn-reject">✖ Tolak</button>
                </form>
            </div>
            @else
                <span style="color: #64748b; font-size: 0.9rem;">Selesai</span>
            @endif
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" style="text-align:center; padding: 30px; color: #94a3b8;">Belum ada pengajuan cuti.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

{{-- STYLE TAMBAHAN KHUSUS TOMBOL --}}
<style>
.btn-action {
    padding: 6px 12px; border-radius: 6px; font-weight: 600; border: none; cursor: pointer; transition: .3s; color: white; font-size: 0.85rem;
}
.btn-approve { background: #10b981; box-shadow: 0 2px 8px rgba(16, 185, 129, 0.4); }
.btn-approve:hover { background: #059669; }
.btn-reject { background: #ef4444; box-shadow: 0 2px 8px rgba(239, 68, 68, 0.4); }
.btn-reject:hover { background: #dc2626; }
</style>

{{-- SCRIPT SWEETALERT --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelectorAll('.btn-approve').forEach(btn => {
    btn.addEventListener('click', function(e) {
        Swal.fire({
            title: 'Setujui Pengajuan?', text: "Cuti akan masuk ke data karyawan.", icon: 'question',
            showCancelButton: true, confirmButtonColor: '#10b981', cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Setujui!', background: '#1e293b', color: '#e2e8f0'
        }).then((result) => { if (result.isConfirmed) this.closest('form').submit(); });
    });
});

document.querySelectorAll('.btn-reject').forEach(btn => {
    btn.addEventListener('click', function(e) {
        Swal.fire({
            title: 'Tolak Pengajuan?', text: "Pengajuan akan dibatalkan.", icon: 'warning',
            showCancelButton: true, confirmButtonColor: '#ef4444', cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Tolak!', background: '#1e293b', color: '#e2e8f0'
        }).then((result) => { if (result.isConfirmed) this.closest('form').submit(); });
    });
});
</script>

@if(session('success'))
<script>Swal.fire({icon:'success', title:'Berhasil!', text:"{{ session('success') }}", showConfirmButton:false, timer:1500, background:'#1e293b', color:'#e2e8f0'});</script>
@endif
@endsection