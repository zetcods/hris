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
        Schema::create('karyawan', function (Blueprint $table) {
            $table->id();

            // 🟦 Tambahkan kolom NIK DI SINI
            $table->string('nik')->unique();

            $table->string('nama');
            $table->string('email')->unique();
            $table->string('jabatan');
            $table->foreignId('divisi_id')->constrained('divisi')->onDelete('cascade');
            $table->date('tanggal_masuk')->nullable();
            $table->decimal('gaji', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawan');
    }
};
