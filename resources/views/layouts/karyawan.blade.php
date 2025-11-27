<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title') - HRIS Karyawan</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
    body { min-height: 100vh; background: #0f172a; color: #e2e8f0; display: flex; flex-direction: column; }
    a { text-decoration: none; color: inherit; }

    .main-header {
      position: fixed; top: 0; width: 100%; height: 70px;
      background: rgba(15,23,42,0.9);
      backdrop-filter: blur(10px);
      display: flex; align-items: center;
      z-index: 999;
      box-shadow: 0 2px 15px rgba(0,0,0,0.25);
    }

    .main-header .container {
      max-width: 1200px; width: 100%;
      margin: 0 auto; padding: 0 40px;
      display: flex; justify-content: space-between; align-items: center;
    }

    .main-header .logo a {
      font-size: 1.6rem;
      font-weight: 700;
      color: #fff;
    }
    .main-header .logo span { color: #38bdf8; }

    nav a {
      margin-left: 25px;
      font-weight: 500;
      color: #e2e8f0;
      transition: 0.3s ease;
      position: relative;
    }

    nav a:hover { color: #38bdf8; }
    nav a:hover::after {
      width: 100%;
    }

    nav a::after {
      content: "";
      position: absolute;
      bottom: -5px;
      left: 0;
      width: 0%;
      height: 2px;
      background: #38bdf8;
      transition: 0.3s;
    }

    .logout-btn {
      background: #ef4444;
      border: none;
      padding: 8px 18px;
      margin-left: 25px;
      color: #fff;
      border-radius: 6px;
      cursor: pointer;
      font-weight: 600;
    }

    main {
      flex: 1;
      /* FIX: Padding global 40px, tapi atasnya ditimpa jadi 110px biar lewat header */
      padding: 40px;
      padding-top: 110px; 
    }

    footer {
      background: #1e293b;
      color: #94a3b8;
      padding: 15px 0;
      text-align: center;
      margin-top: 20px;
    }
  </style>

  @stack('styles')
</head>

<body>

<header class="main-header">
  <div class="container">

    <div class="logo">
      <a href="{{ route('karyawan.dashboard') }}">HRIS<span> Karyawan</span></a>
    </div>

    <nav>
      <a href="{{ route('karyawan.dashboard') }}">Dashboard</a>
      <a href="{{ route('karyawan.cuti') }}">Cuti</a>
      <a href="{{ route('karyawan.izin') }}">Izin</a>
      <a href="{{ route('karyawan.lapor') }}">Laporan</a>
      <a href="{{ route('karyawan.profile') }}">Profil</a>

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

<footer>
  © {{ date('Y') }} ZETA DiCrafters — Axel Xaven Utama
</footer>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- SweetAlert sukses --}}
@if(session('success'))
<script>
document.addEventListener("DOMContentLoaded", () => {
  Swal.fire({
    icon: "success",
    title: "Berhasil!",
    text: "{{ session('success') }}",
    background: "#1e293b",
    color: "#e2e8f0",
    iconColor: "#38bdf8",
    showConfirmButton: false,
    timer: 1700,
  });
});
</script>
@endif

{{-- SweetAlert error --}}
@if(session('error'))
<script>
document.addEventListener("DOMContentLoaded", () => {
  Swal.fire({
    icon: "error",
    title: "Gagal!",
    text: "{{ session('error') }}",
    background: "#1e293b",
    color: "#e2e8f0",
    confirmButtonColor: "#ef4444",
    iconColor: "#ef4444",
  });
});
</script>
@endif

@stack('scripts')

</body>
</html>