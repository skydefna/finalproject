<?php
namespace App\Http\Controllers\Admin;

use App\Models\Lokasi;
use App\Models\Status;
use App\Models\Kecamatan;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use App\Models\DesaKelurahan;
use App\Models\KategoriUsulan;
use App\Exports\PengajuanExport;
use App\Models\User as ModelsUser;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

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

    public function edit(Request $request, $id)
    {
        $request->validate([
            'pengguna_id' => 'exists:pengguna,id_pengguna',
            'nama_pic_lokasi' => 'sometimes|required|string|max:100',
            'pengusul' => 'sometimes|required|string|max:100',
            'nama_lokasi' => 'required|string|max:100',
            'alamat_aktual' => 'required|string|max:100',
            'kecamatan_id' => 'required|exists:kecamatan,id_kecamatan',
            'desa_kelurahan_id' => 'required|exists:desa_kelurahan,id_desa_kelurahan',
            'kontak_pic_lokasi' => 'required|string|max:15',
            'kategori_id' => 'required|exists:kategori_usulan,id_kategori',
            'tanggal_usul' => 'required|date',
            'latitude' => 'required|string',
            'longitude' => 'required|string',
        ], [
            // Pesan khusus
            'nama_pic_lokasi.required' => 'Nama PIC lokasi harus diisi.',
            'pengusul.required' => 'Pengusul harus diisi.',
            'nama_lokasi.required' => 'Nama lokasi harus diisi.',
            'alamat_aktual.required' => 'Alamat aktual wajib diisi.',
            'kecamatan_id.required' => 'Kecamatan harus dipilih.',
            'kecamatan_id.exists' => 'Kecamatan yang dipilih tidak ditemukan.',
            'desa_kelurahan_id.required' => 'Desa/Kelurahan harus dipilih.',
            'desa_kelurahan_id.exists' => 'Desa/Kelurahan yang dipilih tidak ditemukan.',
            'kontak_pic_lokasi.required' => 'Nomor kontak PIC lokasi wajib diisi.',
            'kontak_pic_lokasi.max' => 'Nomor kontak maksimal 15 karakter.',
            'kategori_id.required' => 'Kategori usulan harus dipilih.',
            'kategori_id.exists' => 'Kategori yang dipilih tidak ditemukan.',
            'tanggal_usul.required' => 'Tanggal usul wajib diisi.',
            'tanggal_usul.date' => 'Format tanggal usul tidak valid.',
            'latitude.required' => 'Latitude lokasi wajib diisi.',
            'longitude.required' => 'Longitude lokasi wajib diisi.',
        ]);

        $pengajuan = Pengajuan::findOrFail($id);
        $user = $pengajuan->pengguna;        
        $lokasi = $pengajuan->lokasi()->first();

        // Update lokasi
        if ($lokasi) {
            $lokasi->update([
                'nama_lokasi' => $request['nama_lokasi'],
                'latitude' => $request['latitude'],
                'longitude' => $request['longitude'],
            ]);
        }

        // Update pengajuan
        $pengajuan->update([
            'nama_pic_lokasi' => $request['nama_pic_lokasi'],
            'pengusul' => $request['pengusul'],
            'kontak_pic_lokasi' => $request['kontak_pic_lokasi'],
            'kategori_id' => $request['kategori_id'],
            'alamat_aktual' => $request['alamat_aktual'],
            'tanggal_usul' => $request['tanggal_usul'],
            'kecamatan_id' => $request['kecamatan_id'],
            'desa_kelurahan_id' => $request['desa_kelurahan_id'],
        ]);

        return redirect()->route('admin.pengajuan')->with('success', 'Pengajuan berhasil diperbarui.');
    }

    public function export(Request $request)
    {
        $status = $request->status;
        $user = Auth::user(); // Ambil user yang sedang login

        return Excel::download(new PengajuanExport($status, $user->kecamatan_id), 'pengajuan.xlsx');
    }

    public function toggleStatusAdmin($id)
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