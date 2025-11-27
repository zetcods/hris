<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('karyawan', function (Blueprint $table) {
            if (!Schema::hasColumn('karyawan', 'kuota_cuti')) {
                $table->integer('kuota_cuti')->default(12)->after('password_plain');
            }
        });
    }

    public function down(): void
    {
        Schema::table('karyawan', function (Blueprint $table) {
            if (Schema::hasColumn('karyawan', 'kuota_cuti')) {
                $table->dropColumn('kuota_cuti');
            }
        });
    }
};
