@extends('layouts.admin')

@section('title', 'Profil Admin')

@section('content')
<div style="max-width: 700px; margin: 40px auto; padding: 0 20px;">
    <h1 style="font-size: 1.9rem; font-weight: 700; color: #f1f5f9; margin-bottom: 30px;">
        👤 Profil Admin
    </h1>
    <p style="color:#94a3b8; margin-bottom: 30px;">Kelola informasi login Administrator standar.</p>

    {{-- CARD UPDATE INFO --}}
    <div style="background: #1e293b; padding: 30px; border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.35); margin-bottom: 30px; border: 1px solid #334155;">
        <h3 style="color:#38bdf8; margin-bottom:20px; font-size: 1.2rem;">Perbarui Informasi Akun</h3>

        <form action="{{ route('admin.profile.update') }}" method="POST">
            @csrf
            
            <label style="color: #cbd5e1; font-weight: 500; margin-bottom: 8px; display: block;">Nama Admin</label>
            <input type="text" name="name" value="{{ old('name', Auth::guard('web')->user()->name) }}" required
                   style="width: 100%; padding: 12px; border-radius: 8px; background: #0f172a; color: #e2e8f0; border: 1px solid #334155; margin-bottom: 20px;">
            
            <label style="color: #cbd5e1; font-weight: 500; margin-bottom: 8px; display: block;">Email</label>
            <input type="email" name="email" value="{{ old('email', Auth::guard('web')->user()->email) }}" required
                   style="width: 100%; padding: 12px; border-radius: 8px; background: #0f172a; color: #e2e8f0; border: 1px solid #334155; margin-bottom: 25px;">
            
            <button type="submit" style="background: #38bdf8; color: #1e293b; padding: 12px 25px; border-radius: 8px; border: none; font-weight: 600; cursor: pointer;">
                Simpan Perubahan
            </button>
        </form>
    </div>

    {{-- CARD UPDATE PASSWORD --}}
    <div style="background: #1e293b; padding: 30px; border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.35); border: 1px solid #334155;">
        <h3 style="color:#ef4444; margin-bottom:20px; font-size: 1.2rem;">Ubah Password</h3>

        <form action="{{ route('admin.password.update') }}" method="POST">
            @csrf
            
            <label style="color: #cbd5e1; font-weight: 500; margin-bottom: 8px; display: block;">Password Lama</label>
            <input type="password" name="current_password" required
                   style="width: 100%; padding: 12px; border-radius: 8px; background: #0f172a; color: #e2e8f0; border: 1px solid #334155; margin-bottom: 20px;">

            <label style="color: #cbd5e1; font-weight: 500; margin-bottom: 8px; display: block;">Password Baru</label>
            <input type="password" name="password" required
                   style="width: 100%; padding: 12px; border-radius: 8px; background: #0f172a; color: #e2e8f0; border: 1px solid #334155; margin-bottom: 20px;">

            <label style="color: #cbd5e1; font-weight: 500; margin-bottom: 8px; display: block;">Konfirmasi Password Baru</label>
            <input type="password" name="password_confirmation" required
                   style="width: 100%; padding: 12px; border-radius: 8px; background: #0f172a; color: #e2e8f0; border: 1px solid #334155; margin-bottom: 25px;">
            
            <button type="submit" style="background: #ef4444; color: white; padding: 12px 25px; border-radius: 8px; border: none; font-weight: 600; cursor: pointer;">
                Ubah Password
            </button>
        </form>
    </div>
</div>

@endsection