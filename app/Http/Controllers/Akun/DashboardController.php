<?php

namespace App\Http\Controllers\Akun;

use App\Models\User;
use App\Models\Lokasi;
use App\Models\DataAduan;
use App\Models\DataSurvei;
use App\Models\Pengajuan;
use App\Models\Pemasangan;
use App\Models\Status;
use App\Models\StatusAduan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
        public function visual(){
        
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
            ->join('pengajuan_lokasi as pl', 'p.id_pengajuan', '=', 'pl.pengajuan_id')
            ->join('pengajuan_status as ps', 'ps.pengajuan_id', '=', 'p.id_pengajuan')
            ->join('status as s', 's.id_status', '=', 'ps.status_id')
            ->join('lokasi as l', 'pl.lokasi_id', '=', 'l.id_lokasi')
            ->join('kecamatan as k', 'p.kecamatan_id', '=', 'k.id_kecamatan')
            ->select('k.nama_kecamatan', DB::raw('COUNT(DISTINCT l.id_lokasi) as total_wifi'))
            ->where('s.nama_status', 'Disetujui')
            ->groupBy('k.nama_kecamatan')
            ->get();

        $totalKecamatan = DB::table('kecamatan')->count();

        $jumlahKecamatanDalamRekap = $rekapPerKecamatan->count();

        $rekapStatusAktifPerDesa = DB::table('pengajuan as p')
            ->join('desa_kelurahan as d', 'p.desa_kelurahan_id', '=', 'd.id_desa_kelurahan')
            ->join('pengajuan_status as ps', 'ps.pengajuan_id', '=', 'p.id_pengajuan')
            ->join('status as s', 's.id_status', '=', 'ps.status_id')
            ->select(
                'd.nama_desa_kelurahan',
                DB::raw("CASE WHEN p.status_on = 1 THEN 'Aktif' ELSE 'Mati' END as status"),
                DB::raw('COUNT(*) as total')
            )
            ->where('s.nama_status', 'Disetujui')
            ->groupBy('d.nama_desa_kelurahan', 'p.status_on')
            ->orderBy('d.nama_desa_kelurahan')
            ->get();

        $totalDesa = DB::table('desa_kelurahan')->count();

        $jumlahDesaDalamRekap = $rekapStatusAktifPerDesa
            ->pluck('nama_desa_kelurahan')
            ->unique()
            ->count();
        
        $rekapPerDesa = DB::table('pengajuan as p')
            ->join('pengajuan_lokasi as pl', 'p.id_pengajuan', '=', 'pl.pengajuan_id')
            ->join('pengajuan_status as ps', 'ps.pengajuan_id', '=', 'p.id_pengajuan')
            ->join('status as s', 's.id_status', '=', 'ps.status_id')
            ->join('lokasi as l', 'pl.lokasi_id', '=', 'l.id_lokasi')
            ->join('desa_kelurahan as d', 'p.desa_kelurahan_id', '=', 'd.id_desa_kelurahan')
            ->select('d.nama_desa_kelurahan', DB::raw('COUNT(DISTINCT l.id_lokasi) as total_wifi'))
            ->where('s.nama_status', 'Disetujui')
            ->groupBy('d.nama_desa_kelurahan')
            ->get();

        return view('content.05.data_visual', compact('jumlahPengajuan', 'jumlahDiajukan', 'jumlahDisetujui', 
                    'jumlahDitolak', 'rekapTipeKoneksi', 'rekapPerKecamatan', 'rekapPerDesa', 'rekapStatusAktifPerDesa' ,'totalDesa', 'jumlahDesaDalamRekap',  'totalKecamatan', 'jumlahKecamatanDalamRekap'));
    }
    public function tabel(){
        
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
            ->join('pengajuan_lokasi as pl', 'p.id_pengajuan', '=', 'pl.pengajuan_id')
            ->join('pengajuan_status as ps', 'ps.pengajuan_id', '=', 'p.id_pengajuan')
            ->join('status as s', 's.id_status', '=', 'ps.status_id')
            ->join('lokasi as l', 'pl.lokasi_id', '=', 'l.id_lokasi')
            ->join('kecamatan as k', 'p.kecamatan_id', '=', 'k.id_kecamatan')
            ->select('k.nama_kecamatan', DB::raw('COUNT(DISTINCT l.id_lokasi) as total_wifi'))
            ->where('s.nama_status', 'Disetujui')
            ->groupBy('k.nama_kecamatan')
            ->get();

        $totalKecamatan = DB::table('kecamatan')->count();

        $jumlahKecamatanDalamRekap = $rekapPerKecamatan->count();

        $rekapStatusAktifPerDesa = DB::table('pengajuan as p')
            ->join('desa_kelurahan as d', 'p.desa_kelurahan_id', '=', 'd.id_desa_kelurahan')
            ->join('pengajuan_status as ps', 'ps.pengajuan_id', '=', 'p.id_pengajuan')
            ->join('status as s', 's.id_status', '=', 'ps.status_id')
            ->select(
                'd.nama_desa_kelurahan',
                DB::raw("CASE WHEN p.status_on = 1 THEN 'Aktif' ELSE 'Mati' END as status"),
                DB::raw('COUNT(*) as total')
            )
            ->where('s.nama_status', 'Disetujui')
            ->groupBy('d.nama_desa_kelurahan', 'p.status_on')
            ->orderBy('d.nama_desa_kelurahan')
            ->get();

        $totalDesa = DB::table('desa_kelurahan')->count();

        $jumlahDesaDalamRekap = $rekapStatusAktifPerDesa
            ->pluck('nama_desa_kelurahan')
            ->unique()
            ->count();
        
        $rekapPerDesa = DB::table('pengajuan as p')
            ->join('pengajuan_lokasi as pl', 'p.id_pengajuan', '=', 'pl.pengajuan_id')
            ->join('pengajuan_status as ps', 'ps.pengajuan_id', '=', 'p.id_pengajuan')
            ->join('status as s', 's.id_status', '=', 'ps.status_id')
            ->join('lokasi as l', 'pl.lokasi_id', '=', 'l.id_lokasi')
            ->join('desa_kelurahan as d', 'p.desa_kelurahan_id', '=', 'd.id_desa_kelurahan')
            ->select('d.nama_desa_kelurahan', DB::raw('COUNT(DISTINCT l.id_lokasi) as total_wifi'))
            ->where('s.nama_status', 'Disetujui')
            ->groupBy('d.nama_desa_kelurahan')
            ->get();

        return view('content.05.data_tabel', compact('jumlahPengajuan', 'jumlahDiajukan', 'jumlahDisetujui', 
                    'jumlahDitolak', 'rekapTipeKoneksi', 'rekapPerKecamatan', 'rekapPerDesa', 'rekapStatusAktifPerDesa' ,'totalDesa', 'jumlahDesaDalamRekap',  'totalKecamatan', 'jumlahKecamatanDalamRekap'));
    }
    public function pengajuan(){
        $pengguna = DB::table('pengguna')->get();
        $pengajuan = Pengajuan::with(['pengguna', 'kecamatan', 'desakelurahan', 'kategori', 'lokasi', 'status'])->get();
        $kecamatan = DB::table('kecamatan')->get();
        $desa_kelurahan = DB::table('desa_kelurahan')->get();
        $kategori_usulan = DB::table('kategori_usulan')->get();
        $lokasi = DB::table('lokasi')->get();
        return view('content.05.data_pengajuan', compact('pengguna','pengajuan', 'kecamatan', 'desa_kelurahan', 'kategori_usulan', 'lokasi'));
    }
    public function teknisi()
    {
        $pemasangan = Pemasangan::with(['pengajuan', 'provider', 'lokasi'])->get();
        $pengajuan = DB::table('pengajuan')->get();
        $provider = DB::table('provider')->get();
        $lokasi = DB::table('lokasi')->get();
        return view('content.05.data_teknisi' , compact('pemasangan', 'pengajuan', 'provider', 'lokasi'));
    }
    public function akun(){
        $pengguna = User::with('role_id')->get();
        $roles = DB::table('roles')->get();
        $kecamatan = DB::table('kecamatan')->get();
        return view('content.05.data_akun', compact('pengguna', 'roles', 'kecamatan'));
    }
    public function aduan()
    {
        return view('content.05.data_lapor', [
            'aduan' => DataAduan::all(),
            'statusaduan' => StatusAduan::all(),
            'lokasi' => Lokasi::all(),
            'pengajuan' => Pengajuan::with(['status', 'kecamatan']) // relasi status dan kecamatan
                ->whereHas('status', function ($q) {
                    $q->where('nama_status', 'Disetujui');
                })
                ->get(),
        ]);
    }
    public function survei()
    {
        return view('content.05.data_survei', [
            'survei' => DataSurvei::with(['pengajuan', 'status', 'lokasi'])->get(),
            'status' => Status::all(),
            'lokasi' => Lokasi::all(),
            'pengajuanList' => Pengajuan::with(['lokasi', 'status', 'desaKelurahan', 'kecamatan', 'kategori'])
                ->whereHas('status', function ($query) {
                    $query->where('nama_status', 'Diajukan');
                })
                ->get(),
        ]);
    }
}