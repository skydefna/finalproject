<?php
namespace App\Http\Controllers\Pimpinan;

use App\Models\Lokasi;
use App\Models\Status;
use App\Models\Kecamatan;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use App\Models\DesaKelurahan;
use App\Models\KategoriUsulan;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

class DataPengajuanController
{
    public function pengajuan()
    {
        $pengguna = Auth::user();
        $pengajuan = Pengajuan::with(['pengguna', 'kecamatan', 'desakelurahan', 'kategori', 'lokasi', 'status'])->get();
        $kecamatan = Kecamatan::with('desakelurahan')->get();
        $desa_kelurahan = DesaKelurahan::all();
        $kategori_usulan = KategoriUsulan::all();
        $lokasi = Lokasi::all();
        $status = Status::all();

        return view('content.03.data_pengajuan', compact(
            'pengguna',
            'pengajuan',
            'kecamatan',
            'desa_kelurahan',
            'kategori_usulan',
            'lokasi',
            'status'
        ));
    }
    public function updateStatus(Request $request, $pengajuanId)
    {
        $request->validate([
            'status_id' => 'required|exists:status,id_status',
        ]);

        $pengajuan = Pengajuan::findOrFail($pengajuanId);

        // Nonaktifkan status lama
        DB::table('pengajuan_status')
            ->where('pengajuan_id', $pengajuanId)
            ->delete();

        // Tambahkan status baru
        $pengajuan->status()->attach($request->status_id, [
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Status berhasil diperbarui');
    }
}