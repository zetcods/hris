<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title') - HRIS Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    /* ========== GLOBAL STYLE ========== */
    * {
      margin: 0; padding: 0; box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      min-height: 100vh;
      background-color: #0f172a;
      color: #e2e8f0;
      display: flex;
      flex-direction: column;
    }

    a {
      text-decoration: none;
      color: inherit;
    }

    /* ========== HEADER NAVBAR ========== */
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

    .logout-btn {
      background: #ef4444;
      border: none;
      color: #fff;
      padding: 8px 18px;
      border-radius: 6px;
      font-weight: 600;
      cursor: pointer;
      transition: 0.3s;
      margin-left: 25px;
    }

    .logout-btn:hover {
      background: #dc2626;
    }

    /* biar konten gak ketutupan header */
    main {
      padding-top: 90px;
      flex: 1;
      padding-left: 40px;
      padding-right: 40px;
    }

    .input {
  width: 100%;
  padding: 10px 14px;
  margin-bottom: 10px;
  border-radius: 6px;
  border: 1px solid #334155;
  background: #1e293b;
  color: #e2e8f0;
  outline: none;
}
.input:focus {
  border-color: #38bdf8;
}

    /* ========== FOOTER ========== */
    footer {
      background-color: #1e293b;
      color: #94a3b8;
      text-align: center;
      padding: 15px;
      font-size: 0.9rem;
      letter-spacing: 0.3px;
    }
  </style>
  @stack('styles')
</head>

<body>
  {{-- HEADER UNTUK ADMIN --}}
  <header class="main-header">
    <div class="container">
      <div class="logo">
        <a href="{{ url('/admin/dashboard') }}">HRIS<span> Admin</span></a>
      </div>
      <nav>
  <a href="{{ url('/admin/dashboard') }}">Dashboard</a>
  <a href="{{ route('karyawan.index') }}">Data Karyawan</a>
  <a href="{{ route('divisi.index') }}">Data Divisi</a>
  <a href="{{ route('absensi.index') }}">Absensi</a>
  <a href="#">Penggajian</a>
  <form action="{{ route('logout') }}" method="POST" style="display:inline;">
    @csrf
    <button type="submit" class="logout-btn">Logout</button>
  </form>
</nav>

    </div>
  </header>

  {{-- KONTEN --}}
  <main>
    @yield('content')
  </main>

  {{-- FOOTER --}}
  <footer>
    © {{ date('Y') }} ZETA DiCrafters — Axel Xaven Utama
  </footer>

  @stack('scripts')
  
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>
  Swal.fire({
    title: 'Berhasil!',
    text: "{{ session('success') }}",
    icon: 'success',
    confirmButtonColor: '#38bdf8',
  });
</script>
@endif

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 1800
            });
        });
    </script>
@endif

@if (session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}",
                showConfirmButton: true
            });
        });
    </script>
@endif


</body>
</html>
