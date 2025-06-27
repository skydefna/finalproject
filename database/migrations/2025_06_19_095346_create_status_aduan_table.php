<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('status_aduan', function (Blueprint $table) {
            $table->bigIncrements('id_aduan');
            $table->string('nama_status_aduan');
            $table->timestamps();
        });

        foreach (['Menunggu', 'Diproses', 'Selesai'] as $status) {
            DB::table('status_aduan')->insert([
                'nama_status_aduan' => $status,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori_aduan');
    }
};
