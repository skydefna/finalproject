<?php

namespace App\Http\Controllers\Pengguna;

use App\Models\User;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController
{
    public function beranda()
    {
        // Jumlah Pengajuan Disetujui
        $jumlahDisetujui = DB::table('pengajuan_status')
            ->where('status_id', 2) // 2 = Disetujui
            ->where('is_active', true)
            ->count();

        // Rekap Per Kecamatan (hanya yang disetujui)
        $rekapPerKecamatan = DB::table('pengajuan as p')
            ->join('pengajuan_status as ps', 'p.id_pengajuan', '=', 'ps.pengajuan_id')
            ->join('pengajuan_lokasi as pl', 'p.id_pengajuan', '=', 'pl.pengajuan_id')
            ->join('lokasi as l', 'pl.lokasi_id', '=', 'l.id_lokasi')
            ->join('kecamatan as k', 'p.kecamatan_id', '=', 'k.id_kecamatan')
            ->where('ps.status_id', 2)
            ->where('ps.is_active', true)
            ->select('k.nama_kecamatan', DB::raw('COUNT(DISTINCT l.id_lokasi) as total_wifi'))
            ->groupBy('k.nama_kecamatan')
            ->get();

        // Rekap Per Desa/Kelurahan (hanya yang disetujui)
        $rekapPerDesa = DB::table('pengajuan as p')
            ->join('pengajuan_status as ps', 'p.id_pengajuan', '=', 'ps.pengajuan_id')
            ->join('pengajuan_lokasi as pl', 'p.id_pengajuan', '=', 'pl.pengajuan_id')
            ->join('lokasi as l', 'pl.lokasi_id', '=', 'l.id_lokasi')
            ->join('desa_kelurahan as d', 'p.desa_kelurahan_id', '=', 'd.id_desa_kelurahan')
            ->where('ps.status_id', 2)
            ->where('ps.is_active', true)
            ->select('d.nama_desa_kelurahan', DB::raw('COUNT(DISTINCT l.id_lokasi) as total_wifi'))
            ->groupBy('d.nama_desa_kelurahan')
            ->get();

        $pengajuan = Pengajuan::with(['lokasi', 'kategori', 'status', 'kecamatan', 'desakelurahan'])->get();
        return view('content.01.beranda', compact('pengajuan', 'jumlahDisetujui', 'rekapPerKecamatan', 'rekapPerDesa'));
    }
    public function menu()
    {
        $pengguna = Auth::user();
        $pengajuan = Pengajuan::with(['pengguna', 'lokasi', 'kecamatan', 'desakelurahan', 'kategori', 'status'])
                    ->where('pengguna_id', $pengguna->id_pengguna)
                    ->get();
        $kecamatan = DB::table('kecamatan')->get();
        $desa_kelurahan = DB::table('desa_kelurahan')->get();
        $kategori_usulan = DB::table('kategori_usulan')->get();
        $lokasi = DB::table('lokasi')->get();
        $status = DB::table('status')->get();
        $adminUsers = User::where('role_id', '01')->get(); // Tambahkan ini
        return view('content.01.pengajuan', compact('pengguna', 'pengajuan', 'kecamatan', 'desa_kelurahan', 'kategori_usulan', 'lokasi', 'status', 'adminUsers'));
    }
}