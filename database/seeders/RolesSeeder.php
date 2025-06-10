<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            ['nama' => 'admin', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'tamu', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'pimpinan', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'teknisi', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
