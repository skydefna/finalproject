<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kecamatan;
use App\Models\DesaKelurahan;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Desa_kelurahan;
use Illuminate\Database\Seeder;

class DesaKelurahanSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $desa_kelurahan = [
            1 => ['Bangkiling', 'Bangkiling Raya', 'Banua Lawas', 'Banua Rantau', 'Batang Banyu', 'Bungin', 'Habau', 'Habau Hulu', 'Hapalah', 'Hariang', 'Pematang', 'Purai', 'Sungai Anyar', 'Sungai Durian', 'Talan'],
            2 => ['Halangan', 'Jirak', 'Pampanan', 'Pugaan', 'Sungai Rukam I', 'Sungai Rukam II', 'Tamuti'], 
            3 => ['Ampukung', 'Bahungin', 'Binturu', 'Karangan Putih', 'Masintan', 'Paliat', 'Pasar Panas', 'Pudak Setegal', 'Sungai Buluh', 'Takulat', 'Telaga Itar', 'Pulau'], 
            4 => ['Harus', 'Madang', 'Manduin', 'Mantuil', 'Murung Karangan', 'Padangin', 'Tantaringin'],
            5 => ['Binjai', 'Kampung Baru', 'Kupang Nunding', 'Lumbang', 'Mangkupum', 'Muara Uya', 'Palapi', 'Pasar Batu', 'Ribang', 'Salikung', 'Santuun', 'Simpung Layung', 'Sungai Kumap', 'Uwie'], 
            6 => ['Banyu Tajun', 'Garunggung', 'Juai', 'Kambitin', 'Kambitin Raya', 'Kitang', 'Mahe Seberang', 'Pemarangan Kiwa', 'Puain Kiwa', 'Sungai Pimping', 'Wayau', 'Agung', 'Hikun', 'Jangkung', 'Tanjung'],
            7 => ['Bongkang', 'Catur Karya', 'Halong', 'Hayup', 'Kembang Kuning', 'Lokbatu', 'Mahe Pasar', 'Marindi', 'Nawin', 'Seradang', 'Suput', 'Suriyan', 'Wirang'],
            8 => ['Bilas', 'Kaong', 'Kinarum', 'Masingai I', 'Masingai II', 'Pangelak'],
            9 => ['Garagata', 'Jaro', 'Lano', 'Muang', 'Nalui', 'Namun', 'Purui', 'Solan', 'Teratau'], 
            10 => ['Argo Mulyo', 'Bintang Ara', 'Bumi Makmur', 'Burum', 'Dambung Raya', 'Hegar Manah', 'Panaan', 'Usih', 'Waling'], 
            11 => ['Kapar', 'Kasiu', 'Kasiu Raya', 'Maburai', 'Masukau', 'Belimbing', 'Belimbing Raya', 'Mabuun', 'Pembataan', 'Sulingan'], 
            12 => ['Barimbun', 'Lukbayur', 'Mangkusip', 'Murung Baru', 'Padang Panjang', 'Padangin', 'Pemarangan Kanan', 'Puain Kanan', 'Pulau Kuu', 'Tamiyang', 'Tanta', 'Tanta Hulu', 'Walangkir', 'Warukin'], 
        ];

            foreach ($desa_kelurahan as $kecamatan_id => $desa_list){
                foreach ($desa_list as $db){
                    DesaKelurahan::create([
                        'nama_desa_kelurahan'   => $db,
                        'kecamatan_id'   => $kecamatan_id,
                    ]);
                }
            }
    }
}