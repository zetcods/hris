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

            // Tambahkan col password kalau BELUM ADA
            if (!Schema::hasColumn('karyawan', 'password')) {
                $table->string('password')->nullable();
            }

            // Tambahkan col password_plain kalau BELUM ADA
            if (!Schema::hasColumn('karyawan', 'password_plain')) {
                $table->string('password_plain')->nullable();
            }

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('karyawan', function (Blueprint $table) {

            if (Schema::hasColumn('karyawan', 'password')) {
                $table->dropColumn('password');
            }

            if (Schema::hasColumn('karyawan', 'password_plain')) {
                $table->dropColumn('password_plain');
            }

        });
    }
};
