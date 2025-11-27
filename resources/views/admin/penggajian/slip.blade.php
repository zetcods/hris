<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Slip Gaji {{ $gaji->karyawan->nama }} - {{ $gaji->bulan }} {{ $gaji->tahun }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        /* Gaya Dasar */
        body { font-family: 'Poppins', sans-serif; background: #e2e8f0; color: #1e293b; padding: 20px; }
        .slip { max-width: 700px; margin: 0 auto; background: #fff; padding: 30px; border: 1px solid #ccc; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .header { text-align: center; border-bottom: 2px solid #1e293b; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { font-size: 1.5rem; margin: 0; }
        
        /* Grid Info Karyawan */
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 25px; font-size: 0.95rem; }
        
        /* Tabel Detail */
        .detail-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .detail-table th, .detail-table td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        .detail-table th { background: #f4f4f4; }
        
        /* Baris Total */
        .total-row td { font-weight: 700; background: #38bdf8; color: #fff; }
        
        /* Tombol Cetak */
        .print-btn-container { text-align: center; margin-top: 30px; }
        .print-btn { background: #3b82f6; color: white; padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; }

        /* Media Print (Menghilangkan elemen saat dicetak) */
        @media print {
            body { background: none; padding: 0; }
            .slip { box-shadow: none; border: none; }
            .print-btn-container { display: none; }
        }
    </style>
</head>
<body>

<div class="slip">
    <div class="header">
        <h1>SLIP GAJI KARYAWAN</h1>
        <p>Periode: **{{ $gaji->bulan }} {{ $gaji->tahun }}**</p>
    </div>

    {{-- Info Karyawan --}}
    <div class="info-grid">
        <div>
            <p><strong>NIK:</strong> {{ $gaji->karyawan->nik }}</p>
            <p><strong>Nama:</strong> {{ $gaji->karyawan->nama }}</p>
            <p><strong>Jabatan:</strong> {{ $gaji->karyawan->jabatan }}</p>
        </div>
        <div>
            <p><strong>Divisi:</strong> {{ $gaji->karyawan->divisi->nama_divisi ?? '-' }}</p>
            <p><strong>Tgl Masuk:</strong> {{ $gaji->karyawan->tanggal_masuk ? $gaji->karyawan->tanggal_masuk->format('d M Y') : '-' }}</p>
            <p><strong>Hari Kerja Efektif:</strong> {{ $gaji->hari_kerja_total }} Hari</p>
        </div>
    </div>

    {{-- Detail Perhitungan --}}
    <table class="detail-table">
        <thead>
            <tr>
                <th>KOMPONEN</th>
                <th>JUMLAH</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Gaji Pokok</td>
                <td>Rp {{ number_format($gaji->gaji_pokok, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Potongan Ketidakhadiran ({{ $gaji->total_alpha }} Hari Alpha)</td>
                <td style="color: #ef4444;">(Rp {{ number_format($gaji->potongan_alpha, 0, ',', '.') }})</td>
            </tr>
            
            <tr class="total-row">
                <td style="background: #1e293b; color: #fff; font-size: 1.1rem;">TOTAL DITERIMA (Gaji Bersih)</td>
                <td style="background: #1e293b; color: #38bdf8; font-size: 1.1rem; font-weight: 800;">Rp {{ number_format($gaji->gaji_bersih, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
    
    <p style="text-align: right; margin-top: 30px; font-size: 0.9rem;">
        HRIS System, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
        <span style="font-style: italic;">Disiapkan oleh,</span><br><br><br>
        (HRD Manager)
    </p>

    <div class="print-btn-container">
        <button onclick="window.print()" class="print-btn">🖨️ Cetak Slip Ini</button>
    </div>
</div>

</body>
</html>