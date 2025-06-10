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
        Schema::table('desa_kelurahan', function (Blueprint $table) {
            $table->unsignedBigInteger('kecamatan_id')->after('id_desa_kelurahan'); // tambahkan kolom
            $table->foreign('kecamatan_id')->references('id_kecamatan')->on('kecamatan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('desa_kelurahan', function (Blueprint $table) {
            $table->dropForeign(['kecamatan_id']); // hapus FK dulu
            $table->dropColumn('kecamatan_id');   // lalu hapus kolom
        });
    }
};
