<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penggajian', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('karyawan_id');
            $table->string('bulan', 20);
            $table->integer('tahun');
            
            // Komponen Gaji
            $table->decimal('gaji_pokok', 15, 2);
            $table->integer('hari_kerja_total'); // Hari kerja efektif bulan itu
            
            // Data Absensi
            $table->integer('total_hadir')->default(0);
            $table->integer('total_alpha')->default(0);

            // Perhitungan
            $table->decimal('potongan_alpha', 15, 2)->default(0);
            $table->decimal('gaji_bersih', 15, 2);

            $table->timestamps();

            // Unique index untuk mencegah penggajian ganda di bulan yang sama
            $table->unique(['karyawan_id', 'bulan', 'tahun']);
            $table->foreign('karyawan_id')->references('id')->on('karyawan')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penggajian');
    }
};