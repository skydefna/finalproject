<?php

namespace App\Http\Controllers\Teknisi;

use App\Models\User;
use App\Models\Lokasi;
use App\Models\Status;
use App\Models\Provider;
use App\Models\Kecamatan;
use App\Models\Pengajuan;
use App\Models\Pemasangan;
use Illuminate\Http\Request;
use App\Models\DesaKelurahan;
use App\Models\KategoriUsulan;
use Illuminate\Support\Facades\Storage;

class DataTeknisiController
{
    public function teknisi()
    {
        $pemasangan = Pemasangan::with(['pengajuan', 'provider', 'lokasi'])->get();
        $pengajuan = Pengajuan::whereHas('status', function ($query) {
            $query->where('nama_status', 'Disetujui');
        })->get();
        $provider = Provider::all();
        $lokasi = Lokasi::all();
        return view ('content.04.menu_teknisi', compact('pemasangan', 'pengajuan', 'provider', 'lokasi'));
    }
    public function getLokasi($id)
    {
        $pengajuan = Pengajuan::with('lokasi', 'status')
        ->where('id_pengajuan', $id)
        ->whereHas('status', function ($query) {
            $query->where('nama_status', 'Disetujui');
        })->first();

        if (!$pengajuan) {
            return response()->json([], 404);
        }

        return response()->json($pengajuan->lokasi ?? []);
    }
    public function submit(Request $request)
    {
        $validatedData = $request->validate([
            'pengajuan_id' => 'required|exists:pengajuan,id_pengajuan',
            'ip_assigment' => 'required|string|min:6|max:16',
            'tipe_alat' => 'required|string|max:100',
            'tanggal_pemasangan' => 'required|date',
            'dokumentasi_pemasangan' => 'required|array|max:5',
            'dokumentasi_pemasangan.*' => 'image|mimes:jpg,jpeg,png|max:20480',
            'lokasi_id' => 'exists:lokasi,id_lokasi',
            'provider_id' => 'exists:provider,id_provider',
        ]);
        
        $paths = [];

        if ($request->hasFile('dokumentasi_pemasangan')) {
            foreach ($request->file('dokumentasi_pemasangan') as $file) {
                $paths[] = $file->store('dokumentasi', 'public');
            }
        }

        // Simpan ke database
        $pemasangan = Pemasangan::create([
            'pengajuan_id' => $validatedData['pengajuan_id'],
            'ip_assigment' => $validatedData['ip_assigment'],            
            'tipe_alat' => $validatedData['tipe_alat'],
            'tanggal_pemasangan' => $validatedData['tanggal_pemasangan'],
            'dokumentasi_pemasangan' => json_encode($paths), // pastikan kolom ini bertipe TEXT
        ]);

        $pemasangan->lokasi()->attach($request->lokasi_id);
        $pemasangan->provider()->attach($request->provider_id);

        return redirect()->route('teknisi.data')->with('success', 'Data berhasil disimpan');
    }
    public function update(Request $request, $id)
    {
        $pemasangan = Pemasangan::findOrFail($id);
        $provider = $pemasangan->provider()->first();

        $validatedData = $request->validate([
            'ip_assigment' => 'required|string|min:6|max:16',
            'tipe_alat' => 'required|string|max:100',
            'provider_id' => 'required|exists:provider,id_provider',
            'tanggal_pemasangan' => 'required|date',
            'dokumentasi_pemasangan.*' => 'nullable|image|mimes:jpg,jpeg,png|max:20480',
        ]);

        // Update kolom biasa
        $pemasangan->update([
            'ip_assigment' => $validatedData['ip_assigment'],            
            'tipe_alat' => $validatedData['tipe_alat'],
            'tanggal_pemasangan' => $validatedData['tanggal_pemasangan'],
        ]);

        $pemasangan->provider()->sync([$validatedData['provider_id']]);

        // Jika ada dokumentasi baru
        if ($request->hasFile('dokumentasi_pemasangan')) {
            // Optional: hapus dokumentasi lama
            if ($pemasangan->dokumentasi_pemasangan) {
                foreach (json_decode($pemasangan->dokumentasi_pemasangan) as $old) {
                    Storage::disk('public')->delete($old);
                }
            }

            $paths = [];
            foreach ($request->file('dokumentasi_pemasangan') as $file) {
                $paths[] = $file->store('dokumentasi', 'public');
            }

            $pemasangan->update([
                'dokumentasi_pemasangan' => json_encode($paths)
            ]);
        }

        return redirect()->route('teknisi.data')->with('success', 'Data berhasil diperbarui');
    }
    public function delete($id)
    {
        // Cari data pengajuan berdasarkan ID
        $pemasangan = Pemasangan::findOrFail($id);

        // Hapus data
        $pemasangan->delete();

        // Redirect kembali dengan pesan
        return redirect()->back()->with('success', 'Data pengajuan berhasil dihapus.');
    }
}
