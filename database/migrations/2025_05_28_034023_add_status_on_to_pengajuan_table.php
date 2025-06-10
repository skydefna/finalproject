<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Dalam migration
        Schema::table('pengajuan', function (Blueprint $table) {
            $table->boolean('status_on')->default(0); // Default ON
        });
    }

    public function down()
    {
        Schema::table('pengajuan', function (Blueprint $table) {
            $table->dropColumn('status_on');
        });
    }
};
