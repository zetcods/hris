<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('karyawan', function (Blueprint $table) {
        // Menambahkan kolom foto_profil yang boleh kosong (nullable)
        // Tempatkan setelah kolom email (atau sesuaikan dengan struktur tabelmu)
        $table->string('foto_profil')->nullable()->after('email'); 
    });
}

public function down()
{
    Schema::table('karyawan', function (Blueprint $table) {
        $table->dropColumn('foto_profil');
    });
}
};
