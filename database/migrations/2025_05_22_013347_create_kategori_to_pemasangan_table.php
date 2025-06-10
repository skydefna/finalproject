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
            $table->unsignedBigInteger('kategori_id')->after('id_pengajuan'); // tambahkan kolom
            $table->foreign('kategori_id')->references('id_kategori')->on('kategori_usulan')->onDelete('cascade');
        });

        Schema::table('kategori_usulan', function (Blueprint $table) {
            $table->unsignedBigInteger('pengajuan_id')->after('id_kategori'); // tambahkan kolom
            $table->foreign('pengajuan_id')->references('id_pengajuan')->on('pengajuan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan', function (Blueprint $table) {
            $table->dropForeign(['kategori_id']); // hapus FK dulu
            $table->dropColumn('kategori_id');   // lalu hapus kolom
        });
        Schema::table('kategori_usulan', function (Blueprint $table) {
            $table->dropForeign(['pengajuan_id']); // hapus FK dulu
            $table->dropColumn('pengajuan_id');   // lalu hapus kolom
        });
    }
};
