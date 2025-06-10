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
        Schema::table('pemasangan', function (Blueprint $table) {
            $table->unsignedBigInteger('pengajuan_id')->after('id_pemasangan'); // tambahkan kolom
            $table->foreign('pengajuan_id')->references('id_pengajuan')->on('pengajuan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('pengguna', function (Blueprint $table) {
            $table->dropForeign(['pengajuan_id']); // hapus FK dulu
            $table->dropColumn('pengajuan_id');   // lalu hapus kolom
    });
    }
};
