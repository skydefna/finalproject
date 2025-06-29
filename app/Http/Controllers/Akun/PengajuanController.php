<?php

namespace App\Http\Controllers\Akun;

use App\Models\Lokasi;
use App\Models\Status;
use App\Models\Kecamatan;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use App\Models\DesaKelurahan;

class PengajuanController
{
    public function getDesa(Request $request)
    {
        $desa_kelurahan = DesaKelurahan::where('kecamatan_id', $request->kecamatan_id)->get();
        return response()->json($desa_kelurahan);
    }
    public function create(Request $request)
    {
        $request->validate([
            'pengguna_id' => 'required|exists:pengguna,id_pengguna',
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
            'pengguna_id.required' => 'Nama pengguna wajib dipilih.',
            'pengguna_id.exists' => 'Pengguna yang dipilih tidak ditemukan.',
            
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

        $lokasi = Lokasi::create([
            'nama_lokasi' => $request['nama_lokasi'],
            'latitude' => $request['latitude'],
            'longitude' => $request['longitude'],
        ]);
        $status = Status::where('nama_status', 'Diajukan')->firstOrFail();

        $pengajuan = Pengajuan::create([
            'nama_pic_lokasi' => $request['nama_pic_lokasi'],
            'pengusul' => $request['pengusul'],
            'kontak_pic_lokasi' => $request['kontak_pic_lokasi'],
            'kategori_id' => $request['kategori_id'],
            'alamat_aktual' => $request['alamat_aktual'],
            'tanggal_usul' => $request['tanggal_usul'],
            'kecamatan_id' => $request['kecamatan_id'],
            'desa_kelurahan_id' => $request['desa_kelurahan_id'],
            'pengguna_id' => $request['pengguna_id'],
        ]);
        
        $pengajuan->lokasi()->sync([$lokasi->id_lokasi]);
        $pengajuan->status()->attach($status->id_status);

        return redirect()->route('akun.pengajuan')->with('success', 'Pengajuan Berhasil Terkirim.');
    }
    public function edit(Request $request, $id)
    {
        $request->validate([
            'pengguna_id' => 'required|exists:pengguna,id_pengguna',
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
        ]);

        $pengajuan = Pengajuan::findOrFail($id);
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
            'pengguna_id' => $request['pengguna_id'],
        ]);

        return redirect()->route('akun.pengajuan')->with('success', 'Pengajuan berhasil diperbarui.');
    }
    public function showEditForm($id)
    {
        $pengajuan = Pengajuan::with('lokasi')->findOrFail($id);
        $kecamatan = Kecamatan::all();
        $desa_kelurahan = DesaKelurahan::where('kecamatan_id', $pengajuan->kecamatan_id)->get();

        return view('admin.pengajuan.edit', [
            'data' => $pengajuan,
            'kecamatan' => $kecamatan,
            'desa_kelurahan' => $desa_kelurahan,
        ]);
    }
    public function toggleStatus($id)
    {
        $pengajuan = Pengajuan::findOrFail($id);
        $pengajuan->status_on = !$pengajuan->status_on;
        $pengajuan->save();

        return back()->with('success', 'Status berhasil diubah');
    }
    public function delete($id)
    {
        // Cari data pengajuan berdasarkan ID
        $pengajuan = Pengajuan::findOrFail($id);

        // Hapus data
        $pengajuan->delete();

        // Redirect kembali dengan pesan
        return redirect()->back()->with('success', 'Data pengajuan berhasil dihapus.');
    }
}
