<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('divisi', function (Blueprint $table) {
            // Tambahkan kolom role. Defaultnya 'karyawan' agar divisi lama tidak error.
            if (!Schema::hasColumn('divisi', 'role')) {
                $table->enum('role', ['karyawan', 'admin'])
                      ->default('karyawan')
                      ->after('nama_divisi'); 
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('divisi', function (Blueprint $table) {
            if (Schema::hasColumn('divisi', 'role')) {
                $table->dropColumn('role');
            }
        });
    }
};