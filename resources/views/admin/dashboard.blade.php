@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
  <div style="padding: 40px;">
    <h1 style="font-size: 2.2rem; font-weight: 700; color: #f1f5f9;">
      Selamat Datang, {{ Auth::user()->name }} 👋
    </h1>
    <p style="color: #94a3b8; margin-top: 5px;">
      Ringkasan aktivitas HRIS bulan {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
    </p>

    {{-- 📦 Kartu Statistik --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 25px; margin-top: 40px;">
      @foreach ([
        ['Total Karyawan', $totalKaryawan],
        ['Total Divisi', $totalDivisi],
        ['Total Absensi Bulan Ini', $totalAbsensiBulanIni],
        ['Total Gaji Karyawan', 'Rp ' . number_format(\App\Models\Karyawan::sum('gaji'), 0, ',', '.')]
      ] as [$label, $value])
      <div style="background: linear-gradient(180deg,#1e293b,#0f172a); padding: 25px; border-radius: 16px;
                  box-shadow: 0 4px 20px rgba(0,0,0,0.3); text-align:center; transition:.3s;">
        <h3 style="color:#38bdf8;font-size:1rem;font-weight:600;">{{ $label }}</h3>
        <p style="font-size:2rem;font-weight:700;margin-top:10px;color:#f8fafc;">{{ $value }}</p>
      </div>
      @endforeach
    </div>

    {{-- 📂 Daftar Divisi --}}
    <div style="background:#1e293b;padding:30px;border-radius:16px;margin-top:50px;
                box-shadow:0 4px 20px rgba(0,0,0,0.3);">
      <h3 style="color:#38bdf8;font-size:1.3rem;font-weight:600;margin-bottom:15px;">
        📂 Daftar Divisi
      </h3>
      @if($listDivisi->count() > 0)
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:10px;">
          @foreach ($listDivisi as $div)
            <div style="background:#0f172a;padding:10px 15px;border-radius:8px;
                        color:#e2e8f0;text-align:center;border:1px solid #334155;">
              {{ $div->nama_divisi }}
            </div>
          @endforeach
        </div>
      @else
        <p style="color:#94a3b8;">Belum ada divisi yang terdaftar.</p>
      @endif
    </div>

    {{-- 📊 Grafik --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(450px,1fr));gap:35px;margin-top:50px;align-items:center;">

      {{-- Bar Chart --}}
      <div style="background:#1e293b;padding:30px;border-radius:16px;box-shadow:0 4px 20px rgba(0,0,0,0.3);">
        <h3 style="color:#38bdf8;font-size:1.2rem;font-weight:600;margin-bottom:20px;text-align:center;">
          👥 Jumlah Karyawan per Divisi
        </h3>
        <div style="height:360px;"><canvas id="chartKaryawan"></canvas></div>
      </div>

      {{-- Doughnut Chart --}}
      <div style="background:#1e293b;padding:30px;border-radius:16px;box-shadow:0 4px 20px rgba(0,0,0,0.3);">
        <h3 style="color:#38bdf8;font-size:1.2rem;font-weight:600;margin-bottom:20px;text-align:center;">
          🕒 Statistik Absensi Bulan Ini
        </h3>
        <div style="height:360px;display:flex;justify-content:center;align-items:center;">
          <canvas id="chartAbsensi" style="max-width:300px;"></canvas>
        </div>
      </div>
    </div>
  </div>

  {{-- Chart.js --}}
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // 🎯 Data Grafik Karyawan
      const karyawanLabels = {!! json_encode($karyawanPerDivisi->pluck('nama_divisi')) !!};
      const karyawanData = {!! json_encode($karyawanPerDivisi->pluck('karyawan_count')) !!};

      new Chart(document.getElementById('chartKaryawan'), {
        type: 'bar',
        data: {
          labels: karyawanLabels,
          datasets: [{
            label: 'Jumlah Karyawan',
            data: karyawanData,
            backgroundColor: 'rgba(56,189,248,0.3)',
            borderColor: '#38bdf8',
            borderWidth: 2,
            borderRadius: 6,
            hoverBackgroundColor: 'rgba(56,189,248,0.6)'
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: { labels: { color: '#e2e8f0' }, position: 'bottom' }
          },
          scales: {
            x: {
              ticks: { color: '#cbd5e1' },
              grid: { color: 'rgba(255,255,255,0.05)' }
            },
            y: {
              ticks: { color: '#cbd5e1' },
              grid: { color: 'rgba(255,255,255,0.05)' }
            }
          }
        }
      });

      // 🌀 Data Grafik Absensi
      const absensiLabels = {!! json_encode($absensiStat->pluck('status')) !!};
      const absensiData = {!! json_encode($absensiStat->pluck('total')) !!};

      new Chart(document.getElementById('chartAbsensi'), {
        type: 'doughnut',
        data: {
          labels: absensiLabels,
          datasets: [{
            data: absensiData,
            backgroundColor: [
              'rgba(56,189,248,0.35)',
              'rgba(34,197,94,0.35)',
              'rgba(250,204,21,0.35)',
              'rgba(239,68,68,0.35)'
            ],
            borderColor: '#0f172a',
            borderWidth: 2
          }]
        },
        options: {
          responsive: true,
          cutout: '70%',
          plugins: {
            legend: {
              position: 'bottom',
              labels: { color: '#e2e8f0', padding: 15, boxWidth: 20 }
            }
          }
        }
      });
    });
  </script>
@endsection
