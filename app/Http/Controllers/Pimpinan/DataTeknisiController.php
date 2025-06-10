<?php

namespace App\Http\Controllers\Pimpinan;

use App\Models\Lokasi;
use App\Models\Provider;
use App\Models\Pengajuan;
use App\Models\Pemasangan;
use Illuminate\Http\Request;

class DataTeknisiController
{
    public function teknisi()
    {
        $pemasangan = Pemasangan::with(['pengajuan', 'provider', 'lokasi'])->get();
        $pengajuan = Pengajuan::all();
        $provider = Provider::all();
        $lokasi = Lokasi::all();
        return view ('content.03.data_teknisi', compact('pemasangan', 'pengajuan', 'provider', 'lokasi'));
    }
}
