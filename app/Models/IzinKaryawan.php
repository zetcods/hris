<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IzinKaryawan extends Model
{
    use HasFactory;

    // Pastikan nama tabel ini sesuai dengan yang ada di database kamu
    // Berdasarkan error migrasi sebelumnya, sepertinya namanya 'pengajuan_izin'
    // Jika ternyata 'izin_karyawan', silakan ganti string di bawah ini.
    protected $table = 'pengajuan_izin'; 

    protected $fillable = [
        'karyawan_id',
        'tanggal',
        'jenis',       // Izin atau Sakit
        'keterangan',
        'bukti',       // (Opsional) jika nanti ada fitur upload surat dokter
        'status',      // menunggu, disetujui, ditolak
        'is_read'      // (Opsional) Untuk fitur notifikasi yang sempat error kemarin
    ];

    /**
     * Relasi ke model Karyawan
     * (Setiap pengajuan izin dimiliki oleh satu karyawan)
     */
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }
}