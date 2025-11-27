<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login Karyawan</title>
</head>
<body style="
  background:#0f172a;
  display:flex;
  justify-content:center;
  align-items:center;
  height:100vh;
  color:white;
  font-family:sans-serif;
">

  <div style="
    width:350px;
    background:#1e293b;
    padding:30px;
    border-radius:12px;
    box-shadow:0 4px 15px rgba(0,0,0,0.4);
  ">
    
    <h2 style="text-align:center;margin-bottom:20px;color:#38bdf8;">Login Karyawan</h2>

    <form action="{{ route('karyawan.login') }}" method="POST">
      @csrf

      <label>NIK</label>
      <input type="text" name="nik" required
        style="width:100%;padding:10px;margin-top:5px;margin-bottom:15px;
               background:#0f172a;border:1px solid #334155;border-radius:8px;color:white;">
      @error('nik')
        <p style="color:#ef4444;">{{ $message }}</p>
      @enderror

      <label>Password</label>
      <input type="password" name="password" required
        style="width:100%;padding:10px;margin-top:5px;margin-bottom:20px;
               background:#0f172a;border:1px solid #334155;border-radius:8px;color:white;">

      <button type="submit"
        style="
          width:100%;padding:12px;background:#38bdf8;color:#0f172a;
          border:none;border-radius:8px;font-weight:700;
          cursor:pointer;transition:.2s;
        "
        onmouseover="this.style.background='#7dd3fc'"
        onmouseout="this.style.background='#38bdf8'">
        Login
      </button>

    </form>

  </div>

</body>
</html>
