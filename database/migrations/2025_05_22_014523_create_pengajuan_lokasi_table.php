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
        Schema::create('pengajuan_lokasi', function (Blueprint $table) {
            $table->unsignedBigInteger('pengajuan_id');
            $table->unsignedBigInteger('lokasi_id');
            $table->timestamps();

            $table->foreign('pengajuan_id')->references('id_pengajuan')->on('pengajuan')->onDelete('cascade');
            $table->foreign('lokasi_id')->references('id_lokasi')->on('lokasi')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_lokasi');
    }
};
