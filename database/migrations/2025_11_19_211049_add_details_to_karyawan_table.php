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
        $table->string('tempat_lahir')->nullable()->after('divisi_id');
        $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
        $table->enum('jenis_kelamin', ['L', 'P'])->nullable()->after('tanggal_lahir');
        $table->string('no_hp', 20)->nullable()->after('jenis_kelamin');
        $table->text('alamat')->nullable()->after('no_hp');
    });
}

public function down()
{
    Schema::table('karyawan', function (Blueprint $table) {
        $table->dropColumn(['tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'no_hp', 'alamat']);
    });
}
};
