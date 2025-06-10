<?php
namespace App\Http\Controllers\Pengguna;

use App\Models\Lokasi;
use App\Models\Kecamatan;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use App\Models\DesaKelurahan;
use App\Models\KategoriUsulan;
use App\Models\Status;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PengajuanController
{
    public function pengajuan()
    {
        $pengajuan = Pengajuan::where('pengguna_id', Auth::id())
            ->with(['pengguna', 'kecamatan', 'desakelurahan', 'kategori_usulan', 'lokasi', 'status'])
            ->get();
        $pengguna = User::all();
        $kecamatan = Kecamatan::with('desakelurahan')->get();
        $desa_kelurahan = DesaKelurahan::all();
        $kategori_usulan = KategoriUsulan::all();
        $lokasi = Lokasi::all();
        $status = Status::all();

        return view('content.01.pengajuan', compact(
            'pengajuan', 'pengguna', 'kecamatan', 'desa_kelurahan',
            'kategori_usulan', 'lokasi', 'status'
        ));
    }
    public function getDesa(Request $request)
    {
        $desa_kelurahan = Desakelurahan::where('kecamatan_id', $request->kecamatan_id)->get();
        return response()->json($desa_kelurahan);
    }
    public function submit(Request $request)
    {
        $validatedData = $request->validate([
            'nama_pic_lokasi' => 'required|string|max:100',
            'pengusul' => 'required|string|max:100',
            'nama_lokasi' => 'required|string|max:100',
            'alamat_aktual' => 'required|string|max:150',
            'kecamatan_id' => 'required|exists:kecamatan,id_kecamatan',
            'desa_kelurahan_id' => 'required|exists:desa_kelurahan,id_desa_kelurahan',
            'kontak_pic_lokasi' => 'required|string|max:15',
            'kategori_id' => 'required|exists:kategori_usulan,id_kategori',
            'tanggal_usul' => 'required|date',
            'latitude' => 'required|string',
            'longitude' => 'required|string',
        ], [
            'nama_pic_lokasi.required' => 'Nama PIC lokasi harus diisi.',
            'pengusul.required' => 'Pengusul harus diisi.',
            'nama_lokasi.required' => 'Nama lokasi harus diisi.',
            'alamat_aktual.required' => 'Alamat aktual wajib diisi.',
            'alamat_aktual.max' => 'Alamat Aktual maksimal 150 karakter.',
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
        $validatedData['pengguna_id'] = Auth::id();

        $lokasi = Lokasi::create([
            'nama_lokasi' => $validatedData['nama_lokasi'],
            'latitude' => $validatedData['latitude'],
            'longitude' => $validatedData['longitude'],
        ]);

        $status = Status::where('nama_status', 'Diajukan')->firstOrFail();

        $pengajuan = Pengajuan::create([
            'nama_pic_lokasi' => $validatedData['nama_pic_lokasi'],
            'pengusul' => $validatedData['pengusul'],
            'kontak_pic_lokasi' => $validatedData['kontak_pic_lokasi'],
            'kategori_id' => $validatedData['kategori_id'],
            'alamat_aktual' => $validatedData['alamat_aktual'],
            'tanggal_usul' => $validatedData['tanggal_usul'],
            'kecamatan_id' => $validatedData['kecamatan_id'],
            'desa_kelurahan_id' => $validatedData['desa_kelurahan_id'],
            'pengguna_id' => Auth::id(),
        ]);
        Log::info('Sebelum Sync', [
            'pengajuan_id' => $pengajuan->id_pengajuan,
            'lokasi_id' => $lokasi->id_lokasi
        ]);

        $pengajuan->lokasi()->sync([$lokasi->id_lokasi]);

        Log::info('Setelah Sync', [
            'relasi_lokasi' => $pengajuan->lokasi->pluck('id_lokasi')
        ]);

        $pengajuan->status()->attach($status->id_status);

        
        return redirect()->route('tamu.pengajuan')->with('success', 'Pengajuan Berhasil Terkirim.');
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