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
        Schema::table('pengajuan_izin', function (Blueprint $table) {
            // Tambahkan kolom 'bukti' setelah 'keterangan'
            if (!Schema::hasColumn('pengajuan_izin', 'bukti')) {
                $table->string('bukti')->nullable()->after('keterangan');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_izin', function (Blueprint $table) {
            if (Schema::hasColumn('pengajuan_izin', 'bukti')) {
                $table->dropColumn('bukti');
            }
        });
    }
};