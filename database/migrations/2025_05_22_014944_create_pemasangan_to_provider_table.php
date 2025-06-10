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
        Schema::create('pemasangan_provider', function (Blueprint $table) {
            $table->unsignedBigInteger('pemasangan_id');
            $table->unsignedBigInteger('provider_id');
            $table->timestamps();

            $table->foreign('pemasangan_id')->references('id_pemasangan')->on('pemasangan')->onDelete('cascade');
            $table->foreign('provider_id')->references('id_provider')->on('provider')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemasangan_provider');
    }
};
