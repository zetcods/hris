<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // PERBAIKAN 1: Ganti 'pengajuan_cuti' jadi 'cuti_karyawan'
        if (Schema::hasTable('cuti_karyawan')) {
            Schema::table('cuti_karyawan', function (Blueprint $table) {
                $table->boolean('is_read')->default(0);
            });
        }

        // Pastikan nama tabel izin sesuai dengan yang kamu buat sebelumnya (pengajuan_izin)
        if (Schema::hasTable('pengajuan_izin')) {
            Schema::table('pengajuan_izin', function (Blueprint $table) {
                $table->boolean('is_read')->default(0);
            });
        }

        // Tabel laporan_masalah sepertinya sudah benar
        if (Schema::hasTable('laporan_masalah')) {
            Schema::table('laporan_masalah', function (Blueprint $table) {
                $table->boolean('is_read')->default(0);
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('cuti_karyawan')) {
            Schema::table('cuti_karyawan', function (Blueprint $table) {
                $table->dropColumn('is_read');
            });
        }

        if (Schema::hasTable('pengajuan_izin')) {
            Schema::table('pengajuan_izin', function (Blueprint $table) {
                $table->dropColumn('is_read');
            });
        }

        if (Schema::hasTable('laporan_masalah')) {
            Schema::table('laporan_masalah', function (Blueprint $table) {
                $table->dropColumn('is_read');
            });
        }
    }
};