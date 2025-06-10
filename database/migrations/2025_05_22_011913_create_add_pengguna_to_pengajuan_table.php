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
            $table->unsignedBigInteger('pengguna_id')->after('id_pengajuan'); // tambahkan kolom
            $table->foreign('pengguna_id')->references('id_pengguna')->on('pengguna')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan', function (Blueprint $table) {
            $table->dropForeign(['pengguna_id']); // hapus FK dulu
            $table->dropColumn('pengguna_id');   // lalu hapus kolom
        });
    }
};
