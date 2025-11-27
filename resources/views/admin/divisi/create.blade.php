@extends('layouts.admin')

@section('title', 'Tambah Divisi')

@section('content')
<div style="max-width: 600px; margin: 40px auto; padding: 0 20px;">
    <h1 style="font-size: 1.9rem; font-weight: 700; color: #f1f5f9; margin-bottom: 25px;">
        ➕ Tambah Divisi
    </h1>

    <div style="background: #1e293b; padding: 30px; border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.35); border: 1px solid #334155;">
        <form action="{{ route('divisi.store') }}" method="POST">
            @csrf
            
            <label for="nama_divisi" style="color: #cbd5e1; font-weight: 500; margin-bottom: 8px; display: block;">Nama Divisi</label>
            <input 
                type="text" 
                id="nama_divisi"
                name="nama_divisi" 
                value="{{ old('nama_divisi') }}" 
                required 
                placeholder="Misal: Marketing, IT Support"
                style="width: 100%; padding: 12px 16px; border-radius: 8px; border: 1px solid #334155; 
                       background: #0f172a; color: #e2e8f0; margin-bottom: 5px; transition: .3s;"
            >
            @error('nama_divisi')
              <p style="color:#ef4444; margin-top:4px; font-size: 0.9rem;">{{ $message }}</p>
            @enderror

            {{-- BARU: OPSI ROLE --}}
            <label for="role" style="color: #cbd5e1; font-weight: 500; margin-top: 20px; margin-bottom: 8px; display: block;">Role Akses Divisi</label>
            <select 
                id="role"
                name="role" 
                required 
                style="width: 100%; padding: 12px 16px; border-radius: 8px; border: 1px solid #334155; 
                       background: #0f172a; color: #e2e8f0; margin-bottom: 5px; transition: .3s; cursor: pointer;"
            >
                <option value="karyawan" {{ old('role') == 'karyawan' ? 'selected' : '' }}>Karyawan (Akses Dashboard Karyawan)</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin (Akses Dashboard Admin)</option>
            </select>
            @error('role')
              <p style="color:#ef4444; margin-top:4px; font-size: 0.9rem;">{{ $message }}</p>
            @enderror

            <div style="margin-top: 25px; display: flex; justify-content: flex-end; gap: 10px;">
                <a href="{{ route('divisi.index') }}" 
                   style="background: #334155; color: #e2e8f0; padding: 12px 25px; border-radius: 8px;
                          text-decoration: none; font-weight: 600; transition: .3s; font-size: 1rem;">
                   Batal
                </a>
                <button type="submit" 
                        style="background: linear-gradient(90deg, #38bdf8, #3b82f6); color: #fff;
                               padding: 12px 25px; border: none; border-radius: 8px; font-weight: 600;
                               cursor: pointer; font-size: 1rem; transition: .3s;">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection