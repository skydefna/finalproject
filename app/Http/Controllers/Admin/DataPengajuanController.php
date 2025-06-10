<?php
namespace App\Http\Controllers\Admin;

use App\Models\Lokasi;
use App\Models\Status;
use App\Models\Kecamatan;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use App\Models\DesaKelurahan;
use App\Models\KategoriUsulan;
use App\Models\User as ModelsUser;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

class DataPengajuanController
{
    public function pengajuan()
    {
        $user = Auth::user();
        $pengajuan = collect(); 

        $kecamatanIds = $user->kecamatan->pluck('id_kecamatan');
        $pengajuan = Pengajuan::with(['pengguna', 'kecamatan', 'desakelurahan', 'kategori', 'lokasi', 'status'])
            ->whereIn('kecamatan_id', $kecamatanIds)
            ->get();
            
        $pengguna = ModelsUser::where('role_id', 1)->get();
        $kecamatan = Kecamatan::with('desakelurahan')->get();
        $desa_kelurahan = DesaKelurahan::all();
        $kategori_usulan = KategoriUsulan::all();
        $lokasi = Lokasi::all();

        return view('content.02.menu_utama', compact('pengajuan', 'pengguna', 'kecamatan', 'desa_kelurahan', 'kategori_usulan'));
    }
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_id' => 'required|integer|exists:status,id_status',
        ]);

        $pengajuan = Pengajuan::findOrFail($id);
        $pengajuan->status()->sync([$request->status_id]);

        // Cek apakah request datang dari AJAX
        if ($request->ajax()) {
            return response()->json([
                'message' => 'Status berhasil diperbarui menjadi Diproses!'
            ]);
        }

        // Jika bukan AJAX (fallback)
        return redirect()->back()->with('success', 'Status berhasil diperbarui.');
    }    
    public function toggleStatus($id)
    {
        $pengajuan = Pengajuan::findOrFail($id);
        $pengajuan->status_on = !$pengajuan->status_on;
        $pengajuan->save();

        return back()->with('success', 'Status berhasil diubah');
    }

    public function hapus($id)
    {
        // Cari data pengajuan berdasarkan ID
        $pengajuan = Pengajuan::findOrFail($id);

        // Hapus data
        $pengajuan->delete();

        // Redirect kembali dengan pesan
        return redirect()->back()->with('success', 'Data pengajuan berhasil dihapus.');
    }
}