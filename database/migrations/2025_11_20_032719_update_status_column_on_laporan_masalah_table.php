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
        // Alternatif 1: Ubah ke tipe data ENUM yang benar
        Schema::table('laporan_masalah', function (Blueprint $table) {
            $table->enum('status', ['pending', 'diproses', 'selesai'])
                  ->default('pending')
                  ->change(); 
        });

        /*
        // Alternatif 2 (jika Alternatif 1 masih gagal, gunakan VARCHAR)
        Schema::table('laporan_masalah', function (Blueprint $table) {
            $table->string('status', 50)->default('pending')->change();
        });
        */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Jika kamu memilih Alternatif 1, ini rollback-nya (hanya untuk testing)
        Schema::table('laporan_masalah', function (Blueprint $table) {
            $table->string('status')->default('pending')->change(); // Kembalikan ke string default
        });
    }
};