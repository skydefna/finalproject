<?php
namespace App\Http\Controllers\Teknisi;

use App\Models\User;
use App\Models\Lokasi;
use App\Models\Status;
use App\Models\Kecamatan;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use App\Models\DesaKelurahan;
use App\Models\KategoriUsulan;
use Illuminate\Support\Facades\Auth;

class PengajuanController
{
    public function keseluruhan(){

    }
    public function pengajuan()
    {
        $pengajuan = Pengajuan::with(['pengguna', 'kecamatan', 'desakelurahan', 'kategori', 'lokasi','status'])->get();
        $pengguna = User::all();
        $kecamatan = Kecamatan::with('desakelurahan')->get();
        $desa_kelurahan = DesaKelurahan::all();
        $kategori_usulan = KategoriUsulan::all();
        $lokasi = Lokasi::all();
        $status = Status::all();
        return view ('content.04.data_pengajuan', compact('pengajuan', 'pengguna', 'kecamatan', 'desa_kelurahan', 'kategori_usulan', 'status'));
    }
}