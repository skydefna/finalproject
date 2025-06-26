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
        Schema::create('data_survei', function (Blueprint $table) {
            $table->bigIncrements('id_survei');
            $table->unsignedBigInteger('pengajuan_id');
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('lokasi_id');
            $table->text('deskripsi');
            $table->date('tanggal_survei');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('pengajuan_id')->references('id_pengajuan')->on('pengajuan')->onDelete('cascade');
            $table->foreign('status_id')->references('id_status')->on('status')->onDelete('cascade');
            $table->foreign('lokasi_id')->references('id_lokasi')->on('lokasi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_survei');
    }
};
