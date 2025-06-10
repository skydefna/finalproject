<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('provider')->insert([
            ['nama_provider' => 'Bakti', 'created_at' => now(), 'updated_at' => now()],
            ['nama_provider' => 'Starlink', 'created_at' => now(), 'updated_at' => now()],
            ['nama_provider' => 'Indihome', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
