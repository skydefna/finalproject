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
        Schema::create('pengajuan_status', function (Blueprint $table) {
            $table->unsignedBigInteger('pengajuan_id');
            $table->unsignedBigInteger('status_id');
            $table->timestamps();

            $table->foreign('pengajuan_id')->references('id_pengajuan')->on('pengajuan')->onDelete('cascade');
            $table->foreign('status_id')->references('id_status')->on('status')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_status');
    }
};
