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
        Schema::table('data_aduan', function (Blueprint $table) {
            // kalau ingin hapus kolom lama
            $table->dropForeign(['pengguna_id']);
            $table->dropColumn('pengguna_id');

            // tambahkan kolom baru
            $table->unsignedBigInteger('pengajuan_id');
            $table->foreign('pengajuan_id')->references('id_pengajuan')->on('pengajuan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
