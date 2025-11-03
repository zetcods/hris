@extends('layouts.app')

@section('title', 'Masuk')

@section('split')
<style>
  body {
    background: linear-gradient(120deg, rgba(15,23,42,0.95), rgba(30,58,138,0.85)), 
                url('{{ asset('images/hris-bg.jpg') }}') center/cover no-repeat;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .login-container {
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(15px);
    border: 1px solid rgba(255,255,255,0.15);
    border-radius: 16px;
    padding: 50px 40px;
    width: 100%;
    max-width: 420px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.3);
    text-align: center;
  }

  .login-container h1 {
    font-size: 2rem;
    font-weight: 700;
    color: #e2e8f0;
    margin-bottom: 10px;
  }

  .login-container p {
    color: #cbd5e1;
    font-size: 0.95rem;
    margin-bottom: 35px;
  }

  .login-container label {
    display: block;
    text-align: left;
    color: #e2e8f0;
    font-size: 0.9rem;
    font-weight: 500;
    margin-bottom: 5px;
  }

  .login-container input[type="email"],
  .login-container input[type="password"] {
    width: 100%;
    padding: 12px 15px;
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 8px;
    color: #f8fafc;
    font-size: 0.95rem;
    outline: none;
    margin-bottom: 20px;
    transition: all 0.3s ease;
  }

  .login-container input:focus {
    border-color: #38bdf8;
    box-shadow: 0 0 8px rgba(56,189,248,0.3);
  }

  .login-container .btn-primary {
    width: 100%;
    background: linear-gradient(90deg, #38bdf8, #3b82f6);
    border: none;
    border-radius: 8px;
    padding: 12px;
    font-size: 1rem;
    font-weight: 600;
    color: white;
    cursor: pointer;
    transition: 0.3s ease;
    box-shadow: 0 5px 15px rgba(56,189,248,0.3);
  }

  .login-container .btn-primary:hover {
    background: linear-gradient(90deg, #3b82f6, #2563eb);
    transform: translateY(-2px);
  }

  .login-container .options {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
  }

  /* --- FIX bagian checkbox dan label biar sejajar --- */
  .login-container .remember-group {
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .login-container .remember-group input {
    width: 16px;
    height: 16px;
    accent-color: #38bdf8;
    cursor: pointer;
  }

  .login-container .remember-group label {
    margin-bottom: 0;
    color: #cbd5e1;
    font-size: 0.9rem;
  }

  .login-container a {
    color: #38bdf8;
    font-size: 0.9rem;
    text-decoration: none;
  }

  .login-container a:hover {
    text-decoration: underline;
  }

  .login-container .register {
    margin-top: 25px;
    color: #cbd5e1;
    font-size: 0.9rem;
  }

  .login-container .register a {
    color: #38bdf8;
    font-weight: 600;
  }

  @media (max-width: 500px) {
    .login-container {
      padding: 40px 25px;
    }
  }
</style>

<div class="login-container">
  <h1>Selamat Datang di HRIS</h1>
  <p>Masuk untuk mengelola data karyawan Anda.</p>

  <form method="POST" action="{{ route('login') }}">
    @csrf
    <div>
      <label for="email">Alamat E-mail</label>
      <input id="email" type="email" name="email" required autofocus>
    </div>

    <div>
      <label for="password">Kata Sandi</label>
      <input id="password" type="password" name="password" required>
    </div>

    <div class="options">
      <div class="remember-group">
        <input type="checkbox" id="remember" name="remember">
        <label for="remember">Ingat Saya</label>
      </div>
      <a href="#">Lupa Kata Sandi?</a>
    </div>

    <button type="submit" class="btn-primary">Masuk Sekarang</button>
  </form>

</div>
@endsection
