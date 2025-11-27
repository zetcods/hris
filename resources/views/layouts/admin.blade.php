<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title') - HRIS Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
    body { min-height: 100vh; background: #0f172a; color: #e2e8f0; display: flex; flex-direction: column; }
    a { text-decoration: none; color: inherit; }

    /* --- HEADER --- */
    .main-header {
      position: fixed; top: 0; width: 100%; height: 70px;
      background: rgba(15,23,42,0.95);
      backdrop-filter: blur(10px);
      display: flex; align-items: center;
      z-index: 999;
      box-shadow: 0 2px 15px rgba(0,0,0,0.25);
      border-bottom: 1px solid #1e293b;
    }

    .main-header .container {
      max-width: 1200px; width: 100%;
      margin: 0 auto; padding: 0 40px;
      display: flex; justify-content: space-between; align-items: center;
    }

    .main-header .logo a { font-size: 1.6rem; font-weight: 700; color: #fff; }
    .main-header .logo span { color: #38bdf8; }

    /* --- NAVIGASI --- */
    nav { display: flex; align-items: center; }
    
    /* Style Link Biasa */
    nav > a {
      margin-left: 25px;
      font-weight: 500;
      color: #cbd5e1;
      transition: 0.3s;
      font-size: 0.95rem;
    }
    nav > a:hover { color: #38bdf8; }

    /* --- DROPDOWN MENU (CSS ONLY) --- */
    .dropdown {
      position: relative;
      display: inline-block;
      margin-left: 25px;
    }
    
    .dropdown > a {
      font-weight: 500;
      color: #cbd5e1;
      cursor: pointer;
      padding: 10px 0;
    }
    
    .dropdown:hover > a { color: #38bdf8; }

    .dropdown-content {
      display: none;
      position: absolute;
      background-color: #1e293b;
      min-width: 180px;
      box-shadow: 0 8px 16px rgba(0,0,0,0.4);
      border: 1px solid #334155;
      border-radius: 8px;
      z-index: 1000;
      top: 35px; /* Jarak dari menu induk */
      left: 50%;
      transform: translateX(-50%);
      overflow: hidden;
    }

    .dropdown:hover .dropdown-content { display: block; animation: fadeIn 0.2s; }

    .dropdown-content a {
      color: #e2e8f0;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
      font-size: 0.9rem;
      transition: 0.2s;
      margin-left: 0; /* Reset margin nav biasa */
    }

    .dropdown-content a:hover {
      background-color: #334155;
      color: #38bdf8;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translate(-50%, 10px); }
      to { opacity: 1; transform: translate(-50%, 0); }
    }

    /* --- LOGOUT BUTTON --- */
    .logout-btn {
      background: #ef4444;
      border: none;
      padding: 8px 18px;
      margin-left: 30px;
      color: #fff;
      border-radius: 6px;
      cursor: pointer;
      font-weight: 600;
      transition: 0.3s;
    }
    .logout-btn:hover { background: #dc2626; }

    /* --- MAIN CONTENT FIX --- */
    main {
      flex: 1;
      padding: 40px;
      padding-top: 110px; /* FIX: Biar konten gak ketutupan header */
    }

    /* --- INPUT STYLE (Global) --- */
    .input {
      width: 100%;
      padding: 10px 14px;
      border-radius: 6px;
      border: 1px solid #334155;
      background: #1e293b;
      color: #e2e8f0;
      margin-bottom: 12px;
    }
    .input:focus { border-color: #38bdf8; outline: none; }

    footer {
      background: #1e293b;
      color: #94a3b8;
      padding: 20px; text-align: center;
      font-size: 0.9rem;
      border-top: 1px solid #334155;
    }
  </style>

  @stack('styles')
</head>

<body>

<header class="main-header">
  <div class="container">
    <div class="logo"><a href="{{ route('admin.dashboard') }}">HRIS<span> Admin</span></a></div>

    <nav>
      <a href="{{ route('admin.dashboard') }}">Dashboard</a>

      {{-- DROPDOWN 1: MASTER DATA --}}
      <div class="dropdown">
        <a>Kelola Data ▾</a>
        <div class="dropdown-content">
          <a href="{{ route('karyawan.index') }}">Data Karyawan</a>
          <a href="{{ route('divisi.index') }}">Data Divisi</a>
          <a href="{{ route('admin.penggajian.index') }}">Payroll</a>
        </div>
      </div>

      {{-- DROPDOWN 2: MANAJEMEN (Fitur Baru Disini) --}}
      <div class="dropdown">
        <a>Manajemen ▾</a>
        <div class="dropdown-content">
          <a href="{{ route('absensi.index') }}">Absensi</a>
          <div style="border-top: 1px solid #334155; margin: 5px 0;"></div> {{-- Separator --}}
          <a href="{{ route('admin.cuti') }}">Pengajuan Cuti</a>
          <a href="{{ route('admin.izin') }}">Izin & Sakit</a>
          <a href="{{ route('admin.laporan.index') }}">Laporan Masalah</a>
        </div>
      </div>

      <a href="{{ route('admin.profile') }}">Profil</a>

      <form action="{{ route('logout') }}" method="POST" style="display:inline;">
        @csrf
        <button class="logout-btn">Logout</button>
      </form>
    </nav>
  </div>
</header>

<main>
  @yield('content')
</main>

<footer>© {{ date('Y') }} ZETA DiCrafters — Axel Xaven Utama</footer>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- SweetAlert Logic --}}
@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', () => {
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: "{{ session('success') }}",
        showConfirmButton: false,
        timer: 1800,
        background: '#1e293b',
        color: '#e2e8f0',
        iconColor: '#38bdf8'
    });
});
</script>
@endif

@if(session('error'))
<script>
document.addEventListener('DOMContentLoaded', () => {
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: "{{ session('error') }}",
        confirmButtonColor: '#ef4444',
        background: '#1e293b',
        color: '#e2e8f0',
        iconColor: '#ef4444'
    });
});
</script>
@endif

@stack('scripts')
</body>
</html>