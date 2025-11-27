<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Karyawan extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'karyawan';

    protected $fillable = [
        'nik',
        'nama',
        'email',
        'jabatan',
        'divisi_id',
        // --- DATA BARU ---
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'no_hp',
        'alamat',
        // -----------------
        'tanggal_masuk',
        'gaji',
        'password',
        'password_plain',
        'kuota_cuti',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
        'tanggal_lahir' => 'date', // Cast biar jadi format tanggal
    ];

    public function divisi()
    {
        return $this->belongsTo(Divisi::class, 'divisi_id');
    }
}