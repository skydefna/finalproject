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
        Schema::table('kategori_usulan', function (Blueprint $table) {
            // Hapus foreign key dulu
            $table->dropForeign(['pengajuan_id']);

            // Baru hapus kolomnya
            $table->dropColumn('pengajuan_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kategori_usulan', function (Blueprint $table) {
            $table->foreignId('pengajuan_id')->constrained()->onDelete('cascade');
        });
    }
};
