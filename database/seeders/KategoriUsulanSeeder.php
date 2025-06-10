<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KategoriUsulanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kategori_usulan')->insert([
            ['nama_kategori' => 'Sekolah', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Fasilitas Umum', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Ruang Terbuka Hijau (RTH)', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
