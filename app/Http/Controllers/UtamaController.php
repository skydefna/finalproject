<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class UtamaController extends Controller
{
    public function beranda()
    {

        $jumlahPengajuan = Pengajuan::count();

        $jumlahDiajukan = DB::table('pengajuan_status')
            ->where('status_id', 1) // diasumsikan 1 = Diajukan
            ->where('is_active', true)
            ->count();

        $jumlahDisetujui = DB::table('pengajuan_status')
            ->where('status_id', 2) // 2 = Disetujui
            ->where('is_active', true)
            ->count();

        $jumlahDitolak = DB::table('pengajuan_status')
            ->where('status_id', 3) // 3 = Ditolak
            ->where('is_active', true)
            ->count();
        
        $rekapTipeKoneksi = DB::table('pemasangan_provider as pp')
            ->join('provider as p', 'pp.provider_id', '=', 'p.id_provider')
            ->join('pemasangan as ps', 'pp.pemasangan_id', '=', 'ps.id_pemasangan')
            ->join('pengajuan_lokasi as pl', 'ps.pengajuan_id', '=', 'pl.pengajuan_id')
            ->join('lokasi as l', 'pl.lokasi_id', '=', 'l.id_lokasi')
            ->select(
                'p.nama_provider as tipe_koneksi',
                DB::raw('GROUP_CONCAT(DISTINCT l.nama_lokasi SEPARATOR ", ") as nama_lokasi'),
                DB::raw('COUNT(DISTINCT l.id_lokasi) as total')
            )
            ->groupBy('p.nama_provider')
            ->get();

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

        $totalKecamatan = DB::table('kecamatan')->count();

        $jumlahKecamatanDalamRekap = $rekapPerKecamatan->count();

        $rekapStatusAktifPerDesa = DB::table('pengajuan as p')
            ->join('desa_kelurahan as d', 'p.desa_kelurahan_id', '=', 'd.id_desa_kelurahan')
            ->select(
                'd.nama_desa_kelurahan',
                DB::raw("CASE WHEN p.status_on = 1 THEN 'Aktif' ELSE 'Mati' END as status"),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('d.nama_desa_kelurahan', 'p.status_on')
            ->orderBy('d.nama_desa_kelurahan')
            ->get();

        $totalDesa = DB::table('desa_kelurahan')->count();

        $jumlahDesaDalamRekap = $rekapStatusAktifPerDesa
            ->pluck('nama_desa_kelurahan')
            ->unique()
            ->count();
        
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
        return view('utama', compact('pengajuan', 'jumlahPengajuan', 'jumlahDiajukan', 'jumlahDisetujui', 
                    'jumlahDitolak', 'rekapTipeKoneksi', 'rekapPerKecamatan', 'rekapPerDesa', 'rekapStatusAktifPerDesa' ,'totalDesa', 'jumlahDesaDalamRekap',  'totalKecamatan', 'jumlahKecamatanDalamRekap'));
    }
}
