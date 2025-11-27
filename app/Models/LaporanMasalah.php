<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanMasalah extends Model
{
    protected $table = 'laporan_masalah';

    protected $fillable = [
        'karyawan_id',
        'judul',
        'kategori',
        'deskripsi',
        'status',
    ];

    public function karyawan()
    {
        return $this->belongsTo(\App\Models\Karyawan::class, 'karyawan_id');
    }
}
