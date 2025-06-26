<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StatusAduanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('status_aduan')->insert([
            ['nama_status_aduan' => 'Menunggu', 'created_at' => now(), 'updated_at' => now()],
            ['nama_status_aduan' => 'Diproses', 'created_at' => now(), 'updated_at' => now()],
            ['nama_status_aduan' => 'Selesai', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
