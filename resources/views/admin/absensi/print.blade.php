<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Absensi - HRIS</title>

    <style>
        body { 
            font-family: "Segoe UI", Arial, sans-serif; 
            padding: 20px; 
            font-size: 13px;
            color: #000;
        }

        /* Header */
        .header {
            text-align: center;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 2px solid #000;
        }

        .header h1 {
            margin: 0;
            font-size: 22px;
            letter-spacing: 1px;
        }

        .header h3 {
            margin: 2px 0;
            font-size: 14px;
            color: #444;
        }

        h2, h4 { 
            text-align: center; 
            margin: 5px 0; 
        }

        /* Table */
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 20px; 
        }

        th, td { 
            border: 1px solid #000; 
            padding: 8px; 
            font-size: 12px; 
        }

        th { 
            background-color: #eaeaea;
            text-align: center;
        }

        .text-center { text-align: center; }

        /* Footer */
        .footer {
            margin-top: 40px;
            text-align: right;
            font-size: 12px;
            color: #333;
        }

        /* Signature */
        .signature-block {
            margin-top: 60px;
            width: 200px;
            float: right;
            text-align: center;
            font-size: 12px;
        }

        @media print {
            .no-print { display: none; }
            body { padding: 0; }
        }
    </style>
</head>

<body onload="window.print()">

    <button onclick="window.print()" 
        class="no-print" 
        style="margin-bottom: 20px; padding: 10px; cursor: pointer;">
        🖨️ Cetak Halaman
    </button>

    <!-- Header Perusahaan -->
    <div class="header">
        <h1>HRIS PERUSAHAAN</h1>
        <h3>{{ $namaWebsite ?? 'By Axel Xaven Utama' }}</h3>
    </div>

    <h2><b>REKAP ABSENSI KARYAWAN</b></h2>
    <h4>Periode: {{ \Carbon\Carbon::createFromDate($tahun, $bulan)->translatedFormat('F Y') }}</h4>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Tanggal</th>
                <th>Nama Karyawan</th>
                <th>Status</th>
                <th>Keterangan</th>
            </tr>
        </thead>

        <tbody>
            @forelse($absensi as $index => $a)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($a->tanggal)->translatedFormat('d/m/Y') }}</td>
                <td>{{ $a->karyawan->nama ?? '-' }}</td>
                <td class="text-center" style="font-weight: bold;">{{ $a->status }}</td>
                <td>{{ $a->keterangan ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Tidak ada data absensi pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ date('d F Y H:i') }}
    </div>

    <!-- Optional Signature -->
    <div class="signature-block">
        <p>Mengetahui,</p>
        <br><br><br>
        <p><b>(.......................................)</b></p>
        <p>HR / Admin</p>
    </div>

</body>
</html>
