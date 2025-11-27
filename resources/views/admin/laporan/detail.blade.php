@extends('layouts.admin')

@section('title', 'Detail Laporan Masalah')

@section('content')
<div style="max-width: 800px; margin: 40px auto;">
    <div style="background: #1e293b; padding: 35px; border-radius: 16px; box-shadow: 0 5px 20px rgba(0,0,0,0.3); border: 1px solid #334155;">
        
        {{-- HEADER --}}
        <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid #334155; padding-bottom:20px; margin-bottom:30px;">
            <div>
                <h2 style="color:#f1f5f9; font-size:1.8rem; margin-bottom: 5px; font-weight: 700;">
                    📢 Detail Laporan
                </h2>
                <p style="color:#94a3b8; font-size:0.95rem;">
                    Laporan dari {{ $laporan->karyawan->nama }}
                </p>
            </div>
            
            {{-- BADGE STATUS --}}
            <div>
                @php
                    // Normalisasi status (kecilkan huruf & hapus spasi)
                    $status = strtolower(trim($laporan->status)); 
                    $statusConfig = []; 
                    
                    // FIX: Pakai 'pending'
                    if ($status === 'pending' || $status === 'menunggu') {
                        $statusConfig = ['label' => 'Pending', 'bg' => 'rgba(245, 158, 11, 0.2)', 'border' => '#f59e0b', 'color' => '#f59e0b'];
                    } elseif ($status === 'diproses') {
                        $statusConfig = ['label' => 'Diproses', 'bg' => 'rgba(59, 130, 246, 0.2)', 'border' => '#3b82f6', 'color' => '#3b82f6'];
                    } elseif ($status === 'selesai') {
                        $statusConfig = ['label' => 'Selesai', 'bg' => 'rgba(16, 185, 129, 0.2)', 'border' => '#10b981', 'color' => '#10b981'];
                    } elseif ($status === 'ditolak') {
                        $statusConfig = ['label' => 'Ditolak', 'bg' => 'rgba(239, 68, 68, 0.2)', 'border' => '#ef4444', 'color' => '#ef4444'];
                    } else {
                        $statusConfig = ['label' => ucfirst($status), 'bg' => 'rgba(148, 163, 184, 0.2)','border' => '#94a3b8', 'color' => '#94a3b8'];
                    }
                @endphp
                <span style="
                    background: {{ $statusConfig['bg'] }}; border: 1px solid {{ $statusConfig['border'] }};
                    color: {{ $statusConfig['color'] }}; padding: 8px 16px; border-radius: 20px;
                    font-size: 0.9rem; font-weight: 700; text-transform: uppercase;
                ">{{ $statusConfig['label'] }}</span>
            </div>
        </div>

        {{-- INFORMASI LAPORAN --}}
        <div style="color:#e2e8f0;">
            <p style="color:#64748b; font-size:0.85rem; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Judul Laporan</p>
            <h3 style="font-size:1.5rem; font-weight: 700; margin-bottom: 25px; color: #38bdf8;">
                {{ $laporan->judul }}
            </h3>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 25px;">
                <div>
                    <p style="color:#64748b; font-size:0.85rem; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Kategori</p>
                    <p style="font-size:1.1rem;">{{ $laporan->kategori }}</p>
                </div>
                <div>
                    <p style="color:#64748b; font-size:0.85rem; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Tanggal Lapor</p>
                    <p style="font-size:1.1rem;">{{ $laporan->created_at->translatedFormat('d F Y H:i') }} WIB</p>
                </div>
            </div>

            <p style="color:#64748b; font-size:0.85rem; font-weight: 600; text-transform: uppercase; margin-bottom: 8px; border-top: 1px solid #334155; padding-top: 25px;">Deskripsi Lengkap</p>
            <div style="background:#0f172a; padding:20px; border-radius:12px; border:1px solid #334155; line-height:1.6; color: #cbd5e1; font-size: 1rem;">
                {{ $laporan->deskripsi }}
            </div>
        </div>

        {{-- TOMBOL AKSI (FIX PENDING) --}}
        <div style="margin-top:40px; border-top: 1px solid #334155; padding-top: 20px;">
            <div style="display: flex; justify-content: flex-end; align-items: center; gap: 10px;">
                
                <a href="{{ route('admin.laporan.index') }}" 
                    style="background:#334155; color:#e2e8f0; padding:12px 25px; border-radius:8px; text-decoration:none; font-weight: 600; transition: .3s;">
                    ⬅ Kembali
                </a>

                @php
                    // Ambil status bersih lagi untuk if condition
                    $statusBersih = strtolower(trim($laporan->status));
                @endphp

                {{-- FIX: Cek 'pending' ATAU 'menunggu' --}}
                @if ($statusBersih == 'pending' || $statusBersih == 'menunggu')
                    
                    {{-- Tombol Proses --}}
                    <form id="process-form" action="{{ route('admin.laporan.process', $laporan->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="button" onclick="confirmProcess()" class="btn-action" style="background:#eab308; color:#1e293b;">
                            ⚙ Tandai Diproses
                        </button>
                    </form>

                    {{-- Tombol Tolak --}}
                    <form id="reject-form" action="{{ route('admin.laporan.reject', $laporan->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="button" onclick="confirmReject()" class="btn-action" style="background:#ef4444; color:white;">
                            ✖ Tolak
                        </button>
                    </form>
                    
                @elseif ($statusBersih == 'diproses')
                    
                    {{-- Tombol Selesai --}}
                    <form id="done-form" action="{{ route('admin.laporan.done', $laporan->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="button" onclick="confirmDone()" class="btn-action" style="background:#10b981; color:white;">
                            ✅ Selesai Ditangani
                        </button>
                    </form>

                @else
                    {{-- Debug (Boleh dihapus nanti) --}}
                    {{-- <span style="color:gray;">(Status: {{ $laporan->status }})</span> --}}
                @endif
            </div>
        </div>

    </div>
</div>

<style>
    .btn-action { 
        padding: 12px 25px; border-radius: 8px; font-weight: 600; border: none; 
        cursor: pointer; transition: .3s; font-size: 1rem;
    }
</style>

{{-- SweetAlert JS functions for confirming action --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
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

    function confirmProcess() {
        showConfirmation(
            'process-form',
            'Tandai Diproses?', 
            'Status laporan akan berubah menjadi "Diproses" dan Admin lain akan mengetahuinya.', 
            'info', 
            '#eab308', 
            'Ya, Proses!'
        );
    }

    function confirmReject() {
        showConfirmation(
            'reject-form',
            'Yakin Tolak Laporan?', 
            'Laporan ini akan ditolak dan karyawan akan mendapat notifikasi status "Ditolak".', 
            'warning', 
            '#ef4444', 
            'Ya, Tolak!'
        );
    }

    function confirmDone() {
        showConfirmation(
            'done-form',
            'Selesaikan Laporan?', 
            'Status laporan akan berubah menjadi "Selesai" dan tidak bisa diubah lagi.', 
            'success', 
            '#10b981', 
            'Ya, Selesai!'
        );
    }
</script>

@endsection