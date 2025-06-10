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
        Schema::table('pengguna', function (Blueprint $table) {
            // Tambahkan kolom jika belum ada
            if (!Schema::hasColumn('pengguna', 'kecamatan_id')) {
                $table->unsignedBigInteger('kecamatan_id')->after('id_pengguna');

                $table->foreign('kecamatan_id')
                    ->references('id_kecamatan')
                    ->on('kecamatan')
                    ->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pengguna', function (Blueprint $table) {
            if (Schema::hasColumn('pengguna', 'kecamatan_id')) {
                $table->dropForeign(['kecamatan_id']);
                $table->dropColumn('kecamatan_id');
            }
        });
    }
};
