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
        Schema::create('pemasangan', function (Blueprint $table) {
            $table->bigIncrements('id_pemasangan');
            $table->date('tanggal_pemasangan');
            $table->string('dokumentasi_pemasangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemasangan');
    }
};
