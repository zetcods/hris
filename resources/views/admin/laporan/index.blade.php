@extends('layouts.admin')

@section('title', 'Laporan Masalah')

@section('content')
<div style="padding: 40px;">
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 35px;">
    <h1 style="font-size: 1.9rem; font-weight: 700; color: #f1f5f9;">📢 Laporan Masalah</h1>
  </div>

  <div style="background: #1e293b; border-radius: 12px; overflow: hidden; box-shadow: 0 6px 25px rgba(0,0,0,0.35);">
    <table style="width: 100%; border-collapse: collapse;">
      <thead>
        <tr style="background: #111827; color: #38bdf8; text-align: left; font-size: 0.95rem;">
          <th style="padding: 16px;">No</th>
          <th style="padding: 16px;">Pelapor</th>
          <th style="padding: 16px;">Masalah</th>
          <th style="padding: 16px; width: 30%;">Deskripsi</th>
          <th style="padding: 16px;">Status</th>
          <th style="padding: 16px; text-align: center;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($laporan as $index => $item)
        <tr style="border-bottom: 1px solid #334155; transition: background .3s;">
          <td style="padding: 16px; color: #94a3b8;">{{ $index + 1 }}</td>
          <td style="padding: 16px; font-weight: 500;">
            <div style="color: #e2e8f0;">{{ $item->karyawan->nama }}</div>
            <div style="color: #64748b; font-size: 0.85rem;">{{ $item->karyawan->divisi->nama_divisi ?? '-' }}</div>
          </td>
          <td style="padding: 16px;">
            <div style="color: #f1f5f9; font-weight: 600;">{{ $item->judul }}</div>
            <div style="color: #94a3b8; font-size: 0.85rem;">{{ $item->kategori }}</div>
          </td>
          <td style="padding: 16px; color: #cbd5e1; line-height: 1.5;">
            {{ Str::limit($item->deskripsi, 50) }}
          </td>
          <td style="padding: 16px;">
            @php
                $status = strtolower(trim($item->status));
                $badgeColor = '#94a3b8';
                $badgeBg = 'rgba(148, 163, 184, 0.2)';
                $label = ucfirst($status);

                if ($status == 'pending' || $status == 'menunggu') {
                    $badgeColor = '#f59e0b';
                    $badgeBg = 'rgba(245, 158, 11, 0.2)';
                    $label = 'Pending';
                } elseif ($status == 'diproses') {
                    $badgeColor = '#3b82f6';
                    $badgeBg = 'rgba(59, 130, 246, 0.2)';
                } elseif ($status == 'selesai') {
                    $badgeColor = '#10b981';
                    $badgeBg = 'rgba(16, 185, 129, 0.2)';
                } elseif ($status == 'ditolak') {
                    $badgeColor = '#ef4444';
                    $badgeBg = 'rgba(239, 68, 68, 0.2)';
                }
            @endphp
            <span style="background: {{ $badgeBg }}; color: {{ $badgeColor }}; padding: 5px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; border: 1px solid {{ $badgeColor }};">
                {{ $label }}
            </span>
          </td>
          <td style="padding: 16px; text-align: center;">
            <div style="display: flex; gap: 8px; justify-content: center;">
                
                {{-- Detail --}}
                <a href="{{ route('admin.laporan.detail', $item->id) }}" 
                   style="background: #334155; color: #e2e8f0; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 0.9rem;">
                   👁 Detail
                </a>

                {{-- TOMBOL AKSI (Hanya muncul jika status belum final) --}}
                @if($status == 'pending' || $status == 'menunggu')
                    
                    {{-- Form Process dengan ID Unik --}}
                    <form id="process-form-{{ $item->id }}" action="{{ route('admin.laporan.process', $item->id) }}" method="POST">
                        @csrf
                        <button type="button" onclick="confirmProcess('{{ $item->id }}')" 
                            style="background: #eab308; color: #1e293b; padding: 6px 12px; border-radius: 6px; border: none; cursor: pointer; font-weight: 600;">
                            ⚙ Proses
                        </button>
                    </form>

                @elseif($status == 'diproses')

                    {{-- Form Done dengan ID Unik --}}
                    <form id="done-form-{{ $item->id }}" action="{{ route('admin.laporan.done', $item->id) }}" method="POST">
                        @csrf
                        <button type="button" onclick="confirmDone('{{ $item->id }}')" 
                            style="background: #10b981; color: #fff; padding: 6px 12px; border-radius: 6px; border: none; cursor: pointer; font-weight: 600;">
                            ✅ Selesai
                        </button>
                    </form>

                @endif

            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" style="text-align:center; padding: 30px; color: #94a3b8;">
            Belum ada laporan masuk.
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Fungsi konfirmasi generik
    function showConfirmation(formId, title, text, icon, confirmButtonColor, confirmButtonText) {
        Swal.fire({
            title: title,
            text: text,
            icon: icon,
            showCancelButton: true,
            confirmButtonColor: confirmButtonColor,
            cancelButtonColor: '#64748b',
            confirmButtonText: confirmButtonText,
            cancelButtonText: 'Batal',
            background: '#1e293b',
            color: '#e2e8f0'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(formId).submit();
            }
        });
    }

    // Fungsi Process menerima ID Spesifik
    function confirmProcess(id) {
        showConfirmation(
            'process-form-' + id, // Gunakan ID form yang unik
            'Tandai Diproses?', 
            'Status laporan akan berubah menjadi "Diproses".', 
            'info', 
            '#eab308', 
            'Ya, Proses!'
        );
    }

    // Fungsi Done menerima ID Spesifik
    function confirmDone(id) {
        showConfirmation(
            'done-form-' + id, // Gunakan ID form yang unik
            'Selesaikan Laporan?', 
            'Status laporan akan berubah menjadi "Selesai".', 
            'success', 
            '#10b981', 
            'Ya, Selesai!'
        );
    }
</script>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: "{{ session('success') }}",
        timer: 1500,
        showConfirmButton: false,
        background: '#1e293b',
        color: '#e2e8f0'
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: "{{ session('error') }}",
        background: '#1e293b',
        color: '#e2e8f0'
    });
</script>
@endif

@endsection