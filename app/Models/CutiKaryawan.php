<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CutiKaryawan extends Model
{
    protected $table = 'cuti_karyawan'; //

    protected $fillable = [
        'karyawan_id',
        'jenis_cuti',
        'tanggal_mulai',
        'tanggal_selesai',
        'alasan',
        'status'
    ];

    // RELASI PENTING BIAR GAK ERROR
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }
}