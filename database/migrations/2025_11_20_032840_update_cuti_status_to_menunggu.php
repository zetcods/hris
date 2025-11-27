<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Wajib: Untuk operasi RAW SQL

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE cuti_karyawan CHANGE status status ENUM('menunggu', 'disetujui', 'ditolak') NOT NULL DEFAULT 'menunggu'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rollback status ke ENUM sebelumnya
        DB::statement("ALTER TABLE cuti_karyawan CHANGE status status ENUM('pending', 'disetujui', 'ditolak') NOT NULL DEFAULT 'pending'");
    }
};