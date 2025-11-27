@extends('layouts.admin')

@section('title', 'Kelola Izin & Sakit')

@section('content')
<div style="padding: 40px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 35px;">
        <h1 style="font-size: 1.9rem; font-weight: 700; color: #f1f5f9;">🚑 Kelola Izin & Sakit</h1>
    </div>

    <div style="background: #1e293b; border-radius: 12px; overflow: hidden; box-shadow: 0 6px 25px rgba(0,0,0,0.35);">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #111827; color: #38bdf8; text-align: left; font-size: 0.95rem;">
                    <th style="padding: 16px;">No</th>
                    <th style="padding: 16px;">Nama</th>
                    <th style="padding: 16px;">Jenis</th>
                    <th style="padding: 16px;">Tanggal</th>
                    <th style="padding: 16px;">Keterangan</th>
                    <th style="padding: 16px;">Status</th>
                    <th style="padding: 16px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($izin as $item)
                <tr style="background: #0f172a; color: #e2e8f0; border-top: 1px solid #1e293b;">
                    <td style="padding: 16px;">{{ $loop->iteration }}</td>
                    <td style="padding: 16px; font-weight: 600;">{{ $item->karyawan->nama }}</td>
                    <td style="padding: 16px;">
                        @if($item->jenis == 'Sakit')
                            <span style="color: #ef4444; font-weight: bold;">🤒 Sakit</span>
                        @else
                            <span style="color: #3b82f6; font-weight: bold;">📝 Izin</span>
                        @endif
                    </td>
                    <td style="padding: 16px;">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</td>
                    <td style="padding: 16px;">{{ $item->keterangan }}</td>
                    
                    <td style="padding: 16px;">
                        @php
                            // FIX: Menghilangkan spasi non-ASCII di sekitar '=>'
                            $statusConfig = match($item->status) {
                                'menunggu' => ['bg' => 'rgba(245, 158, 11, 0.2)', 'border' => '#f59e0b', 'color' => '#f59e0b'],
                                'disetujui' => ['bg' => 'rgba(16, 185, 129, 0.2)', 'border' => '#10b981', 'color' => '#10b981'],
                                'ditolak' => ['bg' => 'rgba(239, 68, 68, 0.2)', 'border' => '#ef4444', 'color' => '#ef4444'],
                                default => ['bg' => 'rgba(148, 163, 184, 0.2)','border' => '#94a3b8', 'color' => '#94a3b8'],
                            };
                        @endphp
                        <span style="
                            background: {{ $statusConfig['bg'] }};
                            border: 1px solid {{ $statusConfig['border'] }};
                            color: {{ $statusConfig['color'] }};
                            padding: 6px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;
                            text-transform: uppercase;
                        ">
                            {{ $item->status }}
                        </span>
                    </td>

                    <td style="padding: 16px; text-align: center;">
                        <div style="display: flex; justify-content: center; gap: 8px;">
                            {{-- TOMBOL DETAIL --}}
                            <a href="{{ route('admin.izin.detail', $item->id) }}" 
                                style="background: #3b82f6; color: #fff; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 0.9rem;"
                                title="Lihat Detail">
                                👀
                            </a>
                            
                            @if($item->status == 'menunggu')
                            <form action="{{ route('admin.izin.approve', $item->id) }}" method="POST">
                                @csrf <button type="button" class="btn-action btn-approve">✔</button>
                            </form>
                            <form action="{{ route('admin.izin.reject', $item->id) }}" method="POST">
                                @csrf <button type="button" class="btn-action btn-reject">✖</button>
                            </form>
                            @else
                                <span style="color: #64748b;">-</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" style="text-align:center; padding: 30px; color: #94a3b8;">Tidak ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- COPY STYLE & SCRIPT YANG SAMA --}}
<style>
.btn-action { padding: 6px 12px; border-radius: 6px; font-weight: 600; border: none; cursor: pointer; transition: .3s; color: white; }
.btn-approve { background: #10b981; box-shadow: 0 2px 8px rgba(16, 185, 129, 0.4); }
.btn-approve:hover { background: #059669; }
.btn-reject { background: #ef4444; box-shadow: 0 2px 8px rgba(239, 68, 68, 0.4); }
.btn-reject:hover { background: #dc2626; }
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelectorAll('.btn-approve').forEach(btn => {
    btn.addEventListener('click', function() { Swal.fire({title:'Setujui?', icon:'question', showCancelButton:true, confirmButtonColor:'#10b981', background:'#1e293b', color:'#e2e8f0'}).then(r => { if(r.isConfirmed) this.closest('form').submit() }) });
});
document.querySelectorAll('.btn-reject').forEach(btn => {
    btn.addEventListener('click', function() { Swal.fire({title:'Tolak?', icon:'warning', showCancelButton:true, confirmButtonColor:'#ef4444', background:'#1e293b', color:'#e2e8f0'}).then(r => { if(r.isConfirmed) this.closest('form').submit() }) });
});
</script>
@if(session('success'))
<script>Swal.fire({icon:'success', title:'Berhasil', text:"{{ session('success') }}", timer:1500, showConfirmButton:false, background:'#1e293b', color:'#e2e8f0'});</script>
@endif
@endsection