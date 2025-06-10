<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('status')->insert([
            ['nama_status' => 'Diajukan', 'created_at' => now(), 'updated_at' => now()],
            ['nama_status' => 'Disetujui', 'created_at' => now(), 'updated_at' => now()],
            ['nama_status' => 'Ditolak', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
