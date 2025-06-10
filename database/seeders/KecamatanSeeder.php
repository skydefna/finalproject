<?php

namespace Database\Seeders;

use App\Models\Desa_kelurahan;
use App\Models\Kecamatan;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KecamatanSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $kecamatan = ['Banua Lawas', 'Pugaan', 'Kelua', 'Muara Harus', 'Muara Uya', 'Tanjung', 'Haruai', 'Upau', 'Jaro', 'Bintang Ara', 'Murung Pudak', 'Tanta'];
        
        foreach ($kecamatan as $db) {
            Kecamatan::create([
                'nama_kecamatan'    => $db
            ]);
        }
    }
}