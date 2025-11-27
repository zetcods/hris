<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title') - HRIS System</title>
  
  {{-- Font Premium: Poppins --}}
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <style>
    /* RESET & GLOBAL */
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
    
    body {
      background-color: #0f172a; /* Fallback color */
      color: #e2e8f0;
      overflow-x: hidden;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    a { text-decoration: none; color: inherit; transition: 0.3s; }
    ul { list-style: none; }

    /* --- NAVBAR GLASSMORPHISM --- */
    .navbar {
      position: fixed;
      top: 0;
      width: 100%;
      height: 80px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0 5%;
      z-index: 1000;
      background: rgba(15, 23, 42, 0.6); /* Transparan gelap */
      backdrop-filter: blur(12px); /* Blur efek kaca */
      -webkit-backdrop-filter: blur(12px);
      border-bottom: 1px solid rgba(255, 255, 255, 0.05);
      transition: 0.3s;
    }

    .logo {
      font-size: 1.8rem;
      font-weight: 800;
      color: #fff;
      letter-spacing: 1px;
    }
    .logo span { color: #38bdf8; } /* Titik biru */

    .nav-links { display: flex; gap: 30px; align-items: center; }
    
    .nav-links a {
      font-weight: 500;
      color: #cbd5e1;
      font-size: 0.95rem;
      position: relative;
    }

    .nav-links a:hover { color: #fff; }

    /* Tombol Login di Navbar */
    .btn-nav-login {
      padding: 10px 25px;
      background: rgba(255, 255, 255, 0.1);
      border: 1px solid rgba(255, 255, 255, 0.2);
      border-radius: 50px;
      color: #fff !important;
      font-weight: 600;
      transition: 0.3s;
    }
    .btn-nav-login:hover {
      background: #38bdf8;
      border-color: #38bdf8;
      box-shadow: 0 0 15px rgba(56, 189, 248, 0.5);
    }

    /* --- CONTENT WRAPPER --- */
    main { flex: 1; position: relative; }

    /* --- FOOTER --- */
    footer {
      text-align: center;
      padding: 25px;
      background: #020617;
      color: #64748b;
      font-size: 0.9rem;
      border-top: 1px solid #1e293b;
      z-index: 10;
    }
  </style>
</head>

<body>

  {{-- NAVBAR --}}
  <header class="navbar">
    <a href="{{ url('/') }}" class="logo">HRIS<span>.</span></a>
    
    <nav class="nav-links">
      <a href="{{ url('/') }}">Beranda</a>
      <a href="{{ url('about') }}">Tentang</a>
      <a href="{{ url('login') }}" class="btn-nav-login">Masuk</a>
    </nav>
  </header>

  {{-- CONTENT --}}
  @hasSection('split')
      {{-- Khusus halaman Login/Split Screen --}}
      @yield('split')
  @else
      {{-- Halaman Default --}}
      <main>
        @yield('content')
      </main>
      <footer>
        © {{ date('Y') }} ZETA DiCrafters — Axel Xaven Utama
      </footer>
  @endif

  {{-- SCRIPTS --}}
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
  @if(session('success'))
  <script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: "{{ session('success') }}",
        showConfirmButton: false,
        timer: 2000,
        background: '#1e293b',
        color: '#e2e8f0'
    });
  </script>
  @endif

</body>
</html>