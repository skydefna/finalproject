<?php

namespace App\Http\Controllers\Admin;

use App\Models\Lokasi;
use App\Models\DataAduan;
use App\Models\Pengajuan;
use App\Models\StatusAduan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DataAduanController
{
    public function getLokasiByPengajuan($id)
    {
        $pengajuan = Pengajuan::with('lokasi')->find($id);

        if (!$pengajuan) {
            return response()->json([], 404);
        }

        $lokasiList = $pengajuan->lokasi->map(function ($lokasi) {
            return [
                'id_lokasi' => $lokasi->id_lokasi,
                'nama_lokasi' => $lokasi->nama_lokasi
            ];
        });

        return response()->json($lokasiList);
    }
    public function buat(Request $request)
    {
        $validatedData = $request->validate([
            'pengajuan_id' => 'required|exists:pengajuan,id_pengajuan',
            'lokasi_id' => 'required|exists:lokasi,id_lokasi',
            'deskripsi' => 'required|string',
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:20480',
        ], [
            'pengajuan_id.required' => 'Pengajuan harus dipilih.',
            'lokasi_id.required' => 'Lokasi harus dipilih.',
            'deskripsi.required' => 'Deskripsi aduan wajib diisi.',
            'foto.required' => 'Foto aduan wajib diunggah.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format gambar harus JPG, JPEG, atau PNG.',
            'foto.max' => 'Ukuran maksimal gambar adalah 20MB.',
        ]);

        // Ambil ID status default "Menunggu"
        $statusMenunggu = StatusAduan::where('nama_status_aduan', 'Menunggu')->firstOrFail();

        $path = $request->file('foto')->store('foto_aduan', 'public');

        DataAduan::create([
            'pengajuan_id' => $validatedData['pengajuan_id'],
            'lokasi_id' => $validatedData['lokasi_id'],
            'status_id' => $statusMenunggu->id_status,
            'deskripsi' => $validatedData['deskripsi'],
            'foto' => $path,
        ]);

        return redirect()->back()->with('success', 'Aduan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $aduan = DataAduan::findOrFail($id);

        $request->validate([
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format gambar harus JPG, JPEG, atau PNG.',
            'foto.max' => 'Ukuran maksimal gambar adalah 2MB.',
        ]);

        $aduan->deskripsi = $request->deskripsi;

        // Jika ada file baru diunggah
        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($aduan->foto && Storage::disk('public')->exists($aduan->foto)) {
                Storage::disk('public')->delete($aduan->foto);
            }

            // Simpan foto baru
            $aduan->foto = $request->file('foto')->store('foto_aduan', 'public');
        } elseif (!$aduan->foto) {
            // Jika kolom foto kosong (seharusnya tidak terjadi)
            return redirect()->back()->withErrors(['foto' => 'Foto wajib ada untuk aduan ini.']);
        }

        $aduan->save();

        return redirect()->route('admin.aduan')->with('success', 'Aduan berhasil diperbarui.');
    }

    public function hapus($id)
    {
        $aduan = DataAduan::findOrFail($id);

        if ($aduan->foto && Storage::disk('public')->exists($aduan->foto)) {
            Storage::disk('public')->delete($aduan->foto);
        }

        $aduan->delete();

        return redirect()->back()->with('success', 'Aduan berhasil dihapus.');
    }
}