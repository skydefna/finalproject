<?php

namespace App\Http\Controllers\Akun;

use App\Models\Lokasi;
use App\Models\Pengajuan;
use App\Models\DataSurvei;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DataSurveiController
{
   public function getData($id)
    {
        $pengajuan = Pengajuan::with(['kecamatan', 'desakelurahan', 'lokasi'])
            ->where('id_pengajuan', $id)
            ->first();

        if (!$pengajuan) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        return response()->json([
            'nama_pic_lokasi' => $pengajuan->nama_pic_lokasi,
            'alamat_aktual' => $pengajuan->alamat_aktual,
            'kontak_pic_lokasi' => $pengajuan->kontak_pic_lokasi,
            'kecamatan_id' => $pengajuan->kecamatan_id,
            'desa_kelurahan_id' => $pengajuan->desa_kelurahan_id,
            'nama_kecamatan' => optional($pengajuan->kecamatan)->nama_kecamatan,
            'nama_desa' => optional($pengajuan->desakelurahan)->nama_desa_kelurahan,
            'nama_lokasi' => optional($pengajuan->lokasi->first())->nama_lokasi,
            'latitude'    => optional($pengajuan->lokasi->first())->latitude,
            'longitude'   => optional($pengajuan->lokasi->first())->longitude,
        ]);
    }
    public function byPengajuan($id)
    {
        $pengajuan = Pengajuan::with('lokasi')->find($id);

        return response()->json($pengajuan->lokasi);
    }
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'pengajuan_id'   => 'required|exists:pengajuan,id_pengajuan',
            'nama_surveyor' => 'required|string',
            'deskripsi' => 'required|string',
            'tanggal_survei' => 'required|date',
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:20480',
        ], [
            'pengajuan_id.required'   => 'Anda harus memilih pengajuan.',
            'pengajuan_id.exists'     => 'Data pengajuan tidak valid.',
            'nama_surveyor.required' => 'Nama surveyor wajib diisi.',
            'deskripsi.required' => 'Deskripsi survei wajib diisi.',
            'tanggal_survei.required' => 'Tanggal survei wajib diisi.',
            'foto.required' => 'Foto survei wajib diunggah.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format gambar harus JPG, JPEG, atau PNG.',
            'foto.max' => 'Ukuran maksimal gambar adalah 20MB.',
        ]);

        $path = $request->file('foto')->store('foto_survei', 'public');

        $pengajuan = Pengajuan::with(['lokasi', 'status'])->findOrFail($request->pengajuan_id);

        DataSurvei::create([
            'pengajuan_id' => $pengajuan->id_pengajuan,
            'lokasi_id' => optional($pengajuan->lokasi->first())->id_lokasi,
            'nama_surveyor' => $validatedData['nama_surveyor'],
            'deskripsi' => $validatedData['deskripsi'],
            'tanggal_survei' => $validatedData['tanggal_survei'],
            'foto' => $path,
        ]);

        return redirect()->back()->with('success', 'Data Survei berhasil ditambahkan.');
    }

    public function edit(Request $request, $id)
    {
        $survei = DataSurvei::findOrFail($id);

        $request->validate([
            'nama_surveyor' => 'required|string',
            'deskripsi' => 'required|string',
            'tanggal_survei' => 'required|date',
            'foto' => 'image|mimes:jpg,jpeg,png|max:20480',
        ]);

        $survei->deskripsi = $request->deskripsi;

        // Jika ada file baru diunggah
        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($survei->foto && Storage::disk('public')->exists($survei->foto)) {
                Storage::disk('public')->delete($survei->foto);
            }

            // Simpan foto baru
            $survei->foto = $request->file('foto')->store('foto_survei', 'public');
        } elseif (!$survei->foto) {
            // Jika kolom foto kosong (seharusnya tidak terjadi)
            return redirect()->back()->withErrors(['foto' => 'Foto wajib ada untuk survei ini.']);
        }

        $survei->save();

        return redirect()->route('survei.akun')->with('success', 'Data Survei berhasil diperbarui.');
    }
    public function hapus($id)
    {
        $survei = DataSurvei::findOrFail($id);

        // Hapus file foto jika ada
        if ($survei->foto && Storage::disk('public')->exists($survei->foto)) {
            Storage::disk('public')->delete($survei->foto);
        }

        // Hapus data survei dari database
        $survei->delete();

        return redirect()->back()->with('success', 'Data Survei berhasil dihapus.');
    }
}
