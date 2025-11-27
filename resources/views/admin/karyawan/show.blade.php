@extends('layouts.admin')

@section('title', 'Detail Karyawan')

@section('content')
<div style="max-width:900px; margin: 40px auto;">
  <div style="background:#1e293b; padding:35px; border-radius:16px; box-shadow: 0 5px 20px rgba(0,0,0,0.3);">
    
    {{-- HEADER DETAIL --}}
    <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid #334155; padding-bottom:20px; margin-bottom:30px;">
        <div>
            <h2 style="color:#38bdf8; font-size:1.8rem; margin-bottom: 5px; font-weight: 700;">📄 Detail Karyawan</h2>
            <p style="color:#94a3b8; font-size:0.95rem;">Informasi lengkap biodata dan akun.</p>
        </div>
        <div style="text-align: right;">
            <span style="display: block; color: #94a3b8; font-size: 0.85rem; margin-bottom: 5px;">Nomor Induk Karyawan</span>
            <span style="background:#0f172a; color:#e2e8f0; padding:8px 16px; border-radius:8px; font-size:1.1rem; border: 1px solid #334155; font-weight: 700; letter-spacing: 1px;">
                {{ $karyawan->nik }}
            </span>
        </div>
    </div>

    {{-- ISI DATA (GRID LAYOUT) --}}
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; color:#e2e8f0;">
        
        {{-- KOLOM KIRI --}}
        <div>
            <div style="margin-bottom: 25px;">
                <p style="color:#64748b; font-size:0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 5px;">Nama Lengkap</p>
                <h3 style="font-size:1.3rem; font-weight: 600;">{{ $karyawan->nama }}</h3>
            </div>

            <div style="margin-bottom: 25px;">
                <p style="color:#64748b; font-size:0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 5px;">Email</p>
                <h3 style="font-size:1.1rem;">{{ $karyawan->email }}</h3>
            </div>

            <div style="margin-bottom: 25px;">
                <p style="color:#64748b; font-size:0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 5px;">No. Handphone</p>
                <h3 style="font-size:1.1rem;">{{ $karyawan->no_hp ?? '-' }}</h3>
            </div>
            
            <div style="margin-bottom: 25px;">
                <p style="color:#64748b; font-size:0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 5px;">Tempat, Tanggal Lahir</p>
                <h3 style="font-size:1.1rem;">
                    {{ $karyawan->tempat_lahir ? $karyawan->tempat_lahir . ', ' : '' }}
                    {{ $karyawan->tanggal_lahir ? $karyawan->tanggal_lahir->translatedFormat('d F Y') : '-' }}
                </h3>
            </div>
        </div>

        {{-- KOLOM KANAN --}}
        <div>
            <div style="margin-bottom: 25px;">
                <p style="color:#64748b; font-size:0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 5px;">Divisi & Jabatan</p>
                <h3 style="font-size:1.1rem;">
                    <span style="color: #38bdf8; font-weight: 700;">{{ $karyawan->divisi->nama_divisi ?? '-' }}</span> — {{ $karyawan->jabatan }}
                </h3>
            </div>

            <div style="margin-bottom: 25px;">
                <p style="color:#64748b; font-size:0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 5px;">Jenis Kelamin</p>
                <h3 style="font-size:1.1rem;">
                    {{ $karyawan->jenis_kelamin == 'L' ? 'Laki-laki ♂' : 'Perempuan ♀' }}
                </h3>
            </div>

            <div style="margin-bottom: 25px;">
                <p style="color:#64748b; font-size:0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 5px;">Tanggal Masuk</p>
                <h3 style="font-size:1.1rem;">
                    {{ $karyawan->tanggal_masuk ? $karyawan->tanggal_masuk->translatedFormat('d F Y') : '-' }}
                </h3>
            </div>

            {{-- FITUR SHOW PASSWORD --}}
            <div style="margin-bottom: 20px; background: #0f172a; padding: 20px; border-radius: 12px; border: 1px solid #334155;">
                <p style="color:#94a3b8; font-size:0.8rem; margin-bottom:10px; text-transform: uppercase; letter-spacing: 1px; font-weight: 700;">Password Akun</p>
                
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <span id="password-text" style="font-family: monospace; font-size: 1.4rem; letter-spacing: 4px; color: #f1f5f9;">••••••••</span>
                    
                    <button onclick="togglePassword()" 
                            style="background: rgba(56,189,248,0.1); border: 1px solid rgba(56,189,248,0.3); color: #38bdf8; cursor: pointer; font-weight: 600; padding: 6px 12px; border-radius: 6px; transition: .3s;">
                        👁️ Show
                    </button>
                </div>
                <small style="color: #64748b; font-size: 0.8rem; display: block; margin-top: 10px; font-style: italic;">
                    *Ini adalah password bawaan saat akun dibuat/reset.
                </small>
            </div>
        </div>
    </div>

    {{-- ALAMAT FULL --}}
    <div style="margin-top: 10px; border-top: 1px solid #334155; padding-top: 25px;">
        <p style="color:#64748b; font-size:0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Alamat Domisili</p>
        <div style="background:#0f172a; padding:20px; border-radius:12px; border:1px solid #334155; line-height:1.6; color: #cbd5e1; font-size: 1rem;">
            {{ $karyawan->alamat ?? 'Alamat belum diisi.' }}
        </div>
    </div>

    {{-- TOMBOL AKSI --}}
    <div style="margin-top:40px; display: flex; justify-content: flex-end; gap: 15px;">
        <a href="{{ route('karyawan.index') }}" 
           style="background:#334155; color:#e2e8f0; padding:12px 25px; border-radius:8px; text-decoration:none; font-weight: 600; transition: .3s;">
           Kembali
        </a>
        <a href="{{ route('karyawan.edit', $karyawan->id) }}" 
           style="background:#eab308; color:#fff; padding:12px 25px; border-radius:8px; text-decoration:none; font-weight:600; box-shadow: 0 4px 15px rgba(234, 179, 8, 0.3);">
           ✏️ Edit Data
        </a>
    </div>

  </div>
</div>

{{-- SCRIPT TOGGLE PASSWORD --}}
<script>
    let isVisible = false;
    const realPassword = "{{ $karyawan->password_plain }}"; // Mengambil dari database

    function togglePassword() {
        const text = document.getElementById('password-text');
        const btn = event.target; // Tombol yang diklik

        if (!isVisible) {
            text.innerText = realPassword;
            text.style.letterSpacing = '1px';
            text.style.color = '#38bdf8'; // Ganti warna pas muncul
            btn.innerText = '🙈 Hide';
        } else {
            text.innerText = '••••••••';
            text.style.letterSpacing = '4px';
            text.style.color = '#f1f5f9'; // Balikin warna putih
            btn.innerText = '👁️ Show';
        }
        isVisible = !isVisible;
    }
</script>
@endsection