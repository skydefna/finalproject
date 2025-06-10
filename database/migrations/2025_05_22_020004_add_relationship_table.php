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
        Schema::table('kecamatan', function (Blueprint $table) {
            $table->dropForeign(['desa_kelurahan_id']); // hapus foreign key-nya dulu
            $table->dropColumn('desa_kelurahan_id');    // baru hapus kolomnya
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
