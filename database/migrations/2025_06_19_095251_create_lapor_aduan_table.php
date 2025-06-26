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
        Schema::create('data_aduan', function (Blueprint $table) {
            $table->bigIncrements('id_aduan');
            $table->unsignedBigInteger('pengguna_id'); // FK ke tabel pengguna
            $table->text('deskripsi');
            $table->unsignedBigInteger('kategori_id'); // FK ke kategori aduan
            $table->string('lokasi');
            $table->string('foto');
            $table->enum('status', ['Menunggu', 'Diproses', 'Selesai'])->default('Menunggu');
            $table->text('tanggapan')->nullable();
            $table->timestamps();

            // Foreign Key
            $table->foreign('pengguna_id')->references('id_pengguna')->on('pengguna')->onDelete('cascade');
            $table->foreign('kategori_id')->references('id_kategori_aduan')->on('kategori_aduan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lapor_aduan');
    }
};
