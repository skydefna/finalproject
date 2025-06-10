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
        $table->unsignedBigInteger('role_id')->after('id_pengguna'); // tambahkan kolom
        $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
    });
}

public function down(): void
{
    Schema::table('pengguna', function (Blueprint $table) {
        $table->dropForeign(['role_id']); // hapus FK dulu
        $table->dropColumn('role_id');   // lalu hapus kolom
    });
}
};
