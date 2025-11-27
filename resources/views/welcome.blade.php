@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<style>
    /* 1. BACKGROUND FULL SCREEN (Space Theme) */
    .hero-section {
        min-height: 100vh;
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        /* Gambar Background HD dari Unsplash */
        background: url('https://images.unsplash.com/photo-1451187580459-43490279c0fa?q=80&w=2072&auto=format&fit=crop') no-repeat center center/cover;
    }

    /* Overlay Gelap Biar Teks Kebaca */
    .hero-overlay {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: linear-gradient(180deg, rgba(15, 23, 42, 0.6) 0%, rgba(15, 23, 42, 0.9) 100%);
        z-index: 1;
    }

    /* 2. KARTU KACA (GLASSMORPHISM) */
    .glass-card {
        position: relative;
        z-index: 10;
        background: rgba(255, 255, 255, 0.03); /* Sangat transparan */
        backdrop-filter: blur(20px);           /* Efek Blur Kuat */
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-top: 1px solid rgba(255, 255, 255, 0.2); /* Highlight atas */
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        padding: 60px 40px;
        border-radius: 24px;
        text-align: center;
        max-width: 900px;
        width: 90%;
        animation: slideUp 1s cubic-bezier(0.16, 1, 0.3, 1);
    }

    /* 3. TYPOGRAPHY KEREN */
    .badge-top {
        display: inline-block;
        padding: 8px 16px;
        border-radius: 50px;
        background: rgba(56, 189, 248, 0.15);
        border: 1px solid rgba(56, 189, 248, 0.3);
        color: #38bdf8;
        font-size: 0.85rem;
        font-weight: 600;
        letter-spacing: 1px;
        margin-bottom: 25px;
        text-transform: uppercase;
    }

    .main-title {
        font-size: 4rem;
        font-weight: 800;
        line-height: 1.1;
        margin-bottom: 20px;
        color: white;
    }

    /* Teks Gradasi */
    .gradient-text {
        background: linear-gradient(to right, #38bdf8, #a855f7, #ec4899);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .sub-desc {
        font-size: 1.15rem;
        color: #cbd5e1;
        line-height: 1.7;
        max-width: 650px;
        margin: 0 auto 45px;
        font-weight: 300;
    }

    /* 4. BUTTONS */
    .btn-group {
        display: flex;
        justify-content: center;
        gap: 20px;
        flex-wrap: wrap;
    }

    .btn-hero {
        padding: 16px 45px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .btn-primary-glow {
        background: linear-gradient(135deg, #2563eb, #7c3aed);
        color: white;
        box-shadow: 0 10px 30px rgba(124, 58, 237, 0.4);
    }

    .btn-primary-glow:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(124, 58, 237, 0.6);
    }

    .btn-outline-glass {
        background: transparent;
        border: 2px solid rgba(255, 255, 255, 0.15);
        color: #e2e8f0;
    }

    .btn-outline-glass:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: #fff;
        color: #fff;
        transform: translateY(-5px);
    }

    /* Animasi Masuk */
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(50px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .main-title { font-size: 2.5rem; }
        .glass-card { padding: 40px 20px; }
    }
</style>

<div class="hero-section">
    <div class="hero-overlay"></div>

    <div class="glass-card">
        <div class="badge-top">✨ Sistem HRIS Generasi Baru</div>
        
        <h1 class="main-title">
            Kelola Tim Jadi Lebih <br>
            <span class="gradient-text">Cerdas & Efisien</span>
        </h1>
        
        <p class="sub-desc">
            Platform all-in-one untuk manajemen absensi, penggajian otomatis, dan penilaian kinerja. 
            Tinggalkan cara lama, beralih ke masa depan.
        </p>
    
        <div class="btn-group">
            <a href="{{ url('login') }}" style="text-decoration: none;">
                <button class="btn-hero btn-primary-glow">
                    🚀 Mulai Sekarang
                </button>
            </a>
    
            <a href="{{ url('about') }}" style="text-decoration: none;">
                <button class="btn-hero btn-outline-glass">
                    Pelajari Fitur
                </button>
            </a>
        </div>
    </div>
</div>
@endsection