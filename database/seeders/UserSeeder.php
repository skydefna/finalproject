<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pengguna')->insert([
            'role_id' => '05',
            'kecamatan_id' => null,
            'nama_pengguna' => 'defa',
            'username' => 'superadmin',
            'password' => Hash::make('admin123'),
        ]);
    }
}
