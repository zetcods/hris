@extends('layouts.app')

@section('title', 'Tentang HRIS')

@section('content')
<style>
    /* 1. BACKGROUND DISAMAKAN DENGAN WELCOME PAGE */
    .about-wrapper {
        min-height: 100vh;
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        padding: 120px 20px 60px;
        /* Menggunakan gambar yang sama dengan welcome.blade.php */
        background: url('https://images.unsplash.com/photo-1451187580459-43490279c0fa?q=80&w=2072&auto=format&fit=crop') no-repeat center center/cover;
        background-attachment: fixed; /* Parallax effect tetap ada */
    }

    /* Overlay sedikit lebih gelap biar teks bacaannya nyaman */
    .about-overlay {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: linear-gradient(180deg, rgba(15, 23, 42, 0.7) 0%, rgba(15, 23, 42, 0.95) 100%);
        z-index: 1;
    }

    /* 2. CONTAINER KACA UTAMA */
    .glass-container {
        position: relative;
        z-index: 10;
        max-width: 1100px;
        width: 100%;
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 24px;
        padding: 60px 50px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        animation: fadeIn 0.8s ease-out;
    }

    /* 3. TYPOGRAPHY */
    .title-gradient {
        font-size: 3rem;
        font-weight: 800;
        text-align: center;
        margin-bottom: 25px;
        background: linear-gradient(to right, #60a5fa, #c084fc, #f472b6);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .desc-text {
        text-align: center;
        color: #cbd5e1;
        font-size: 1.1rem;
        line-height: 1.8;
        max-width: 800px;
        margin: 0 auto 60px;
    }

    /* 4. GRID FITUR */
    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        margin-bottom: 50px;
    }

    .feature-card {
        background: rgba(30, 41, 59, 0.4);
        border: 1px solid rgba(255, 255, 255, 0.05);
        padding: 35px 30px;
        border-radius: 20px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .feature-card:hover {
        transform: translateY(-8px);
        background: rgba(56, 189, 248, 0.08);
        border-color: rgba(56, 189, 248, 0.3);
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }

    .icon-box {
        font-size: 2.5rem;
        margin-bottom: 20px;
        display: inline-block;
        filter: drop-shadow(0 0 10px rgba(255,255,255,0.3));
    }

    .feature-title {
        color: #f8fafc;
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 12px;
    }

    .feature-desc {
        color: #94a3b8;
        font-size: 0.95rem;
        line-height: 1.6;
    }

    /* 5. TOMBOL KEMBALI */
    .btn-back-wrapper {
        text-align: center;
        margin-top: 20px;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 14px 35px;
        border-radius: 50px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.15);
        color: white;
        font-weight: 600;
        transition: 0.3s;
        cursor: pointer;
    }

    .btn-back:hover {
        background: linear-gradient(90deg, #3b82f6, #6366f1);
        border-color: transparent;
        transform: translateX(-5px);
        box-shadow: 0 5px 20px rgba(59, 130, 246, 0.4);
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .glass-container { padding: 40px 20px; }
        .title-gradient { font-size: 2.2rem; }
    }
</style>

<div class="about-wrapper">
    <div class="about-overlay"></div>

    <div class="glass-container">
        {{-- JUDUL HALAMAN --}}
        <h1 class="title-gradient">Tentang Platform</h1>
        
        {{-- DESKRIPSI UTAMA --}}
        <p class="desc-text">
            <b>HRIS (Human Resource Information System)</b> adalah solusi digital terpadu yang dirancang untuk merevolusi cara perusahaan mengelola aset terbesarnya: Sumber Daya Manusia. Kami menggabungkan efisiensi teknologi dengan kebutuhan manajemen modern.
        </p>

        {{-- GRID FITUR --}}
        <div class="features-grid">
            
            <div class="feature-card">
                <span class="icon-box">👥</span>
                <h3 class="feature-title">Manajemen Karyawan</h3>
                <p class="feature-desc">
                    Pusat data karyawan yang aman dan terstruktur. Kelola profil, riwayat jabatan, dan divisi dalam satu dashboard yang intuitif.
                </p>
            </div>

            <div class="feature-card">
                <span class="icon-box">📅</span>
                <h3 class="feature-title">Absensi Digital</h3>
                <p class="feature-desc">
                    Pencatatan kehadiran yang akurat dengan status real-time (Hadir, Izin, Sakit, Cuti). Rekap otomatis setiap akhir bulan.
                </p>
            </div>

            <div class="feature-card">
                <span class="icon-box">💸</span>
                <h3 class="feature-title">Payroll Otomatis</h3>
                <p class="feature-desc">
                    Hitung gaji pokok, tunjangan, dan potongan ketidakhadiran secara instan. Cetak slip gaji digital hanya dengan satu klik.
                </p>
            </div>

             <div class="feature-card">
                <span class="icon-box">🛡️</span>
                <h3 class="feature-title">Keamanan Data</h3>
                <p class="feature-desc">
                    Sistem keamanan berlapis dengan enkripsi password dan pembagian hak akses (Role-Based Access) antara Admin dan Karyawan.
                </p>
            </div>

        </div>

        {{-- TOMBOL KEMBALI --}}
        <div class="btn-back-wrapper">
            <a href="{{ url('/') }}" class="btn-back">
                <span>←</span> Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection