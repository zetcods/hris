<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Membuat tabel 'pengajuan_izin'
        Schema::create('pengajuan_izin', function (Blueprint $table) {
            $table->id();
            // Pastikan 'karyawan_id' tipe datanya sama dengan id di tabel karyawan (biasanya bigInteger/unsignedBigInteger)
            $table->unsignedBigInteger('karyawan_id'); 
            
            $table->date('tanggal');
            $table->string('jenis'); // Izin atau Sakit
            $table->text('keterangan')->nullable();
            $table->string('status')->default('menunggu'); // menunggu, disetujui, ditolak
            $table->boolean('is_read')->default(0); // Buat notifikasi (opsional)
            $table->timestamps();

            // Foreign Key (Opsional, biar aman datanya)
            // $table->foreign('karyawan_id')->references('id')->on('karyawan')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_izin');
    }
};