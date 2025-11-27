@extends('layouts.app')

@section('title', 'Masuk')

@section('split')
<style>
    /* 1. BACKGROUND FULL SCREEN (Sama dengan Welcome/About) */
    body {
        background: url('https://images.unsplash.com/photo-1451187580459-43490279c0fa?q=80&w=2072&auto=format&fit=crop') no-repeat center center/cover;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Poppins', sans-serif;
        margin: 0;
    }

    /* Overlay Gelap */
    body::before {
        content: "";
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: linear-gradient(180deg, rgba(15, 23, 42, 0.6) 0%, rgba(15, 23, 42, 0.9) 100%);
        z-index: -1;
    }

    /* 2. KARTU LOGIN KACA */
    .login-card {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-top: 1px solid rgba(255, 255, 255, 0.2);
        padding: 40px;
        border-radius: 24px;
        width: 100%;
        max-width: 400px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        animation: scaleIn 0.6s ease-out;
    }

    /* Header Login */
    .login-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .login-header h1 {
        color: #fff;
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .login-header p {
        color: #94a3b8;
        font-size: 0.9rem;
    }

    /* 3. INPUT FIELDS */
    .input-group {
        margin-bottom: 20px;
    }

    .input-group label {
        display: block;
        color: #cbd5e1;
        font-size: 0.9rem;
        margin-bottom: 8px;
        font-weight: 500;
    }

    .form-control {
        width: 100%;
        padding: 12px 15px;
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        color: #fff;
        font-size: 1rem;
        transition: 0.3s;
        outline: none;
    }

    .form-control:focus {
        border-color: #38bdf8;
        background: rgba(15, 23, 42, 0.8);
        box-shadow: 0 0 0 4px rgba(56, 189, 248, 0.1);
    }

    /* Placeholder color */
    ::placeholder { color: #475569; }

    /* 4. BUTTON & LINKS */
    .btn-login {
        width: 100%;
        padding: 14px;
        background: linear-gradient(135deg, #3b82f6, #6366f1);
        border: none;
        border-radius: 12px;
        color: white;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: 0.3s;
        margin-top: 10px;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
    }

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.6);
    }

    .options {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        font-size: 0.85rem;
    }

    .remember-me {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #cbd5e1;
        cursor: pointer;
    }

    .forgot-link {
        color: #38bdf8;
        text-decoration: none;
        transition: 0.3s;
    }
    .forgot-link:hover { text-decoration: underline; color: #7dd3fc; }

    .back-home {
        text-align: center;
        margin-top: 25px;
        display: block;
        color: #64748b;
        font-size: 0.9rem;
        transition: 0.3s;
    }
    .back-home:hover { color: #fff; }

    /* ERROR ALERT STYLE */
    .alert-error {
        background: rgba(239, 68, 68, 0.15);
        border: 1px solid rgba(239, 68, 68, 0.3);
        color: #fca5a5;
        padding: 12px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    @keyframes scaleIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }
</style>

<div class="login-card">
    
    <div class="login-header">
        <h1>Selamat Datang</h1>
        <p>Silakan masuk untuk melanjutkan akses.</p>
    </div>

    {{-- ALERT ERROR --}}
    @if(session('error') || $errors->any())
    <div class="alert-error">
        <span>⚠️</span>
        <div>
            {{ session('error') ?? $errors->first() }}
        </div>
    </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        
        {{-- INPUT USERNAME/NIK --}}
        <div class="input-group">
            <label for="login">Email atau NIK</label>
            <input id="login" type="text" name="login" class="form-control" 
                   placeholder="ex: 12345678 atau admin@hris.com" 
                   value="{{ old('login') }}" required autofocus>
        </div>

        {{-- INPUT PASSWORD --}}
        <div class="input-group">
            <label for="password">Kata Sandi</label>
            <input id="password" type="password" name="password" class="form-control" 
                   placeholder="••••••••" required>
        </div>

        {{-- OPTIONS --}}
        <div class="options">
            <label class="remember-me">
                <input type="checkbox" name="remember">
                Ingat Saya
            </label>
            <a href="#" class="forgot-link">Lupa Sandi?</a>
        </div>

        <button type="submit" class="btn-login">
            🚀 Masuk Sekarang
        </button>
    </form>

    <a href="{{ url('/') }}" class="back-home">
        ← Kembali ke Beranda
    </a>
</div>

{{-- SCRIPT SWEETALERT --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
  Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: "{{ session('success') }}",
    background: '#1e293b',
    color: '#e2e8f0',
    confirmButtonColor: '#38bdf8',
    timer: 2000,
    showConfirmButton: false
  });
</script>
@endif
@endsection