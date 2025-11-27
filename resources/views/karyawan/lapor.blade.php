@extends('layouts.karyawan')

@section('title', 'Lapor Masalah')

@section('content')
<div style="max-width: 1000px; margin: 0 auto;">

    {{-- HEADER --}}
    <div style="margin-bottom: 30px;">
        <h1 style="font-size: 2rem; font-weight: 700; color: #f1f5f9;">📢 Lapor Masalah</h1>
        <p style="color: #94a3b8; margin-top: 5px;">Laporkan kendala atau pelanggaran secara aman. Kami menjaga privasi Anda.</p>
    </div>

    {{-- FORM PENGAJUAN --}}
    <div class="card-box">
        <h3 class="section-title">⚠️ Form Laporan</h3>
        <form action="{{ route('karyawan.lapor.store') }}" method="POST">
            @csrf

            <label>Judul Laporan</label>
            <input type="text" name="judul" class="input-field" placeholder="Singkat padat, misal: WiFi Lantai 2 Mati" required>

            <label style="margin-top: 15px;">Kategori</label>
            <select name="kategori" class="input-field" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="Fasilitas">Fasilitas Kantor</option>
                <option value="Kinerja">Kinerja / Rekan Kerja</option>
                <option value="Etika">Pelanggaran Etika</option>
                <option value="Lainnya">Lainnya</option>
            </select>

            <label style="margin-top: 15px;">Deskripsi Masalah</label>
            <textarea name="deskripsi" class="input-field" rows="5" placeholder="Ceritakan kronologi atau detail masalah..." required></textarea>

            {{-- TOMBOL DISAMAIN BIRU, BUKAN MERAH --}}
            <button type="submit" class="btn-submit">🚩 Kirim Laporan</button>
        </form>
    </div>

    {{-- TABEL RIWAYAT --}}
    <div class="card-box" style="margin-top: 30px;">
        <h3 class="section-title">📂 Laporan Saya</h3>
        <div style="overflow-x: auto;">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayat as $item)
                    <tr>
                        <td>{{ $item->created_at->format('d M Y') }}</td>
                        <td style="font-weight: 600; color: #e2e8f0;">{{ $item->judul }}</td>
                        <td><span style="background: #334155; padding: 4px 10px; border-radius: 6px; font-size: 0.85rem;">{{ $item->kategori }}</span></td>
                        <td>
                            @php
                                $statusColor = match($item->status) {
                                    'pending' => ['bg' => '#f59e0b20', 'text' => '#f59e0b'],
                                    'diproses' => ['bg' => '#3b82f620', 'text' => '#3b82f6'],
                                    'selesai' => ['bg' => '#10b98120', 'text' => '#10b981'],
                                    'ditolak' => ['bg' => '#ef444420', 'text' => '#ef4444'],
                                    default => ['bg' => '#64748b20', 'text' => '#94a3b8']
                                };
                            @endphp
                            <span class="status-badge" style="background: {{ $statusColor['bg'] }}; color: {{ $statusColor['text'] }}; border: 1px solid {{ $statusColor['text'] }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 20px; color: #64748b;">Belum ada laporan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- STYLE DISAMAIN SAMA CUTI & IZIN --}}
<style>
    .card-box { background: #1e293b; padding: 30px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.25); border: 1px solid #334155; }
    .section-title { color: #38bdf8; font-size: 1.1rem; margin-bottom: 20px; font-weight: 600; border-bottom: 1px solid #334155; padding-bottom: 10px; }
    label { color: #cbd5e1; font-weight: 500; margin-bottom: 8px; display: block; font-size: 0.9rem; }
    .input-field { width: 100%; padding: 12px 16px; border-radius: 8px; border: 1px solid #334155; background: #0f172a; color: #e2e8f0; transition: .3s; }
    .input-field:focus { border-color: #38bdf8; outline: none; box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.2); }
    
    /* Button jadi biru/hijau biar konsisten */
    .btn-submit { width: 100%; background: linear-gradient(135deg, #38bdf8, #2563eb); color: white; padding: 12px; border: none; border-radius: 8px; font-weight: 600; margin-top: 20px; cursor: pointer; transition: .3s; box-shadow: 0 4px 15px rgba(56, 189, 248, 0.4); }
    .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(56, 189, 248, 0.6); }

    .custom-table { width: 100%; border-collapse: collapse; }
    .custom-table th { text-align: left; padding: 12px; color: #94a3b8; border-bottom: 1px solid #334155; font-size: 0.9rem; font-weight: 600; }
    .custom-table td { padding: 15px 12px; color: #e2e8f0; border-bottom: 1px solid #334155; font-size: 0.95rem; }
    .status-badge { padding: 5px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
</style>
@endsection 