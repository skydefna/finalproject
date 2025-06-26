<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('data_survei', function (Blueprint $table) {
            $table->dropForeign(['status_id']); // jika ada foreign key
            $table->dropColumn('status_id');
        });
    }

    public function down(): void
    {
        Schema::table('data_survei', function (Blueprint $table) {
            $table->unsignedBigInteger('status_id')->nullable();

            // Jika sebelumnya ada relasi foreign key, tambahkan kembali:
            $table->foreign('status_id')->references('id_status')->on('status')->onDelete('set null');
        });
    }
};