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
        Schema::table('pengajuan', function (Blueprint $table) {
            $table->unsignedBigInteger('kecamatan_id')->after('id_pengajuan'); // tambahkan kolom
            $table->foreign('kecamatan_id')->references('id_kecamatan')->on('kecamatan')->onDelete('cascade');
        });
        Schema::table('pengajuan', function (Blueprint $table) {
            $table->unsignedBigInteger('desa_kelurahan_id')->after('id_pengajuan'); // tambahkan kolom
            $table->foreign('desa_kelurahan_id')->references('id_desa_kelurahan')->on('desa_kelurahan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan', function (Blueprint $table) {
            $table->dropForeign(['kecamatan_id']); // hapus FK dulu
            $table->dropColumn('kecamatan_id');   // lalu hapus kolom
        });
        Schema::table('pengajuan', function (Blueprint $table) {
            $table->dropForeign(['desa_kelurahan_id']); // hapus FK dulu
            $table->dropColumn('desa_kelurahan_id');   // lalu hapus kolom
        });
    }
};
