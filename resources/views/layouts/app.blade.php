<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title') - HRIS</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    /* ---------------------------
       RESET & GLOBAL STYLES
    --------------------------- */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      min-height: 100vh;
      background-color: #0f172a; /* Deep navy base */
      color: #e2e8f0;
      display: flex;
      flex-direction: column;
    }

    a {
      text-decoration: none;
      color: inherit;
    }

    /* ---------------------------
       HEADER NAVBAR
    --------------------------- */
    .main-header {
      position: fixed;
      top: 0;
      width: 100%;
      height: 70px;
      background: rgba(15, 23, 42, 0.9);
      backdrop-filter: blur(10px);
      display: flex;
      align-items: center;
      z-index: 999;
      box-shadow: 0 2px 15px rgba(0, 0, 0, 0.25);
    }

    .main-header .container {
      width: 100%;
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .main-header .logo a {
      font-size: 1.6rem;
      font-weight: 700;
      color: #ffffff;
      letter-spacing: 0.5px;
      transition: color 0.3s ease;
    }

    .main-header .logo span {
      color: #38bdf8;
    }

    .main-header nav a {
      color: #e2e8f0;
      font-weight: 500;
      margin-left: 25px;
      font-size: 0.95rem;
      transition: all 0.3s ease;
      position: relative;
    }

    .main-header nav a::after {
      content: "";
      position: absolute;
      bottom: -5px;
      left: 0;
      width: 0%;
      height: 2px;
      background: #38bdf8;
      transition: 0.3s ease;
    }

    .main-header nav a:hover {
      color: #38bdf8;
    }

    .main-header nav a:hover::after {
      width: 100%;
    }

    /* biar isi konten gak ketutupan header */
    .page-default, .split {
      padding-top: 70px;
    }

    /* ---------------------------
       BUTTON STYLES
    --------------------------- */
    .btn-primary {
      background: linear-gradient(90deg, #38bdf8, #3b82f6);
      color: #fff;
      border: none;
      padding: 12px 28px;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 600;
      transition: all 0.3s ease;
      box-shadow: 0 3px 10px rgba(56,189,248,0.3);
    }

    .btn-primary:hover {
      background: linear-gradient(90deg, #3b82f6, #2563eb);
      transform: translateY(-2px);
    }

    .btn-outline {
      border: 2px solid #38bdf8;
      color: #38bdf8;
      background: transparent;
      padding: 12px 28px;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .btn-outline:hover {
      background: #38bdf8;
      color: #0f172a;
    }

    /* ---------------------------
       LAYOUT NORMAL (Welcome, About)
    --------------------------- */
    main.page-default {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      text-align: center;
      padding: 60px 20px;
      background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    }

    footer {
      background-color: #1e293b;
      color: #94a3b8;
      text-align: center;
      padding: 15px;
      font-size: 0.9rem;
      letter-spacing: 0.3px;
    }

    /* ---------------------------
       SPLIT LAYOUT (Login, Register)
    --------------------------- */
    .split {
      display: flex;
      width: 100%;
      height: 100vh;
    }

    .split .left {
      flex: 1;
      background: #f1f5f9;
      color: #0f172a;
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 0 80px;
      box-shadow: 4px 0 20px rgba(0,0,0,0.1);
    }

    .split .right {
      flex: 1;
      position: relative;
      color: white;
      display: flex;
      justify-content: center;
      align-items: flex-end;
      text-align: center;
      overflow: hidden;
    }

    .split .right::before {
      content: "";
      position: absolute;
      inset: 0;
      background: linear-gradient(120deg, rgba(15,23,42,0.8), rgba(37,99,235,0.7));
      z-index: 1;
    }

    .split .right img {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      z-index: 0;
      filter: brightness(70%);
    }

    .split .right p {
      font-size: 1.4rem;
      line-height: 1.6;
      padding: 0 40px 80px;
      z-index: 2;
      font-weight: 500;
    }

    .split .right span {
      color: #fbbf24;
      font-weight: 600;
    }

    @media (max-width: 992px) {
      .split {
        flex-direction: column;
      }
      .split .right {
        display: none;
      }
      .split .left {
        width: 100%;
        padding: 40px;
      }
    }
  </style>
  @stack('styles')
</head>
<body>
  {{-- HEADER NAVBAR --}}
  <header class="main-header">
    <div class="container">
      <div class="logo">
        <a href="{{ url('/') }}">HRIS<span>.</span></a>
      </div>
      <nav>
        <a href="{{ url('/') }}">Home</a>
        <a href="{{ url('about') }}">Tentang</a>
        <a href="{{ url('login') }}">Login</a>
      </nav>
    </div>
  </header>

  {{-- Cek apakah pakai layout split --}}
  @hasSection('split')
    @yield('split')
  @else
    {{-- layout default --}}
    <main class="page-default">
      <div class="content">
        @yield('content')
      </div>
    </main>

    <footer>
      © {{ date('Y') }} ZETA DiCrafters | Axel Xaven Utama
    </footer>
  @endif

@if(session('success'))
  <script>
    alert("{{ session('success') }}");
  </script>
@endif


  @stack('scripts')

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('logout_success'))
<script>
Swal.fire({
  title: 'Logout Berhasil!',
  text: "{{ session('logout_success') }}",
  icon: 'success',
  confirmButtonColor: '#db362a',
});
</script>
@endif

</body>
</html>
