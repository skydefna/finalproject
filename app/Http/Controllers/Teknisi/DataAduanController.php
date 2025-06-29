<?php

namespace App\Http\Controllers\Teknisi;

use App\Models\Lokasi;
use App\Models\DataAduan;
use App\Models\Pengajuan;
use App\Models\StatusAduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class DataAduanController
{
    public function aduan()
    {
        return view('content.04.data_lapor', [
            'aduan' => DataAduan::all(),
            'statusaduan' => StatusAduan::all(),
            'lokasi' => Lokasi::all(),
            'pengajuan' => Pengajuan::all(),
        ]);
    }
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_id' => 'required|exists:status_aduan,id_status',
        ]);

        $aduan = DataAduan::with(['pengajuan', 'statusaduan'])->findOrFail($id);
        $aduan->status_id = $request->status_id;
        $aduan->save();

        // 🔄 Reload relasi setelah simpan
        $aduan->load('statusaduan', 'pengajuan');

        // ✅ Kirim notifikasi
        $this->kirimNotifStatusAduan($aduan);

        return redirect()->back()->with('success', 'Status berhasil diperbarui.');
    }

    private function kirimNotifStatusAduan($aduan)
    {
        $pengajuan = $aduan->pengajuan;

        $nama = $pengajuan->nama_pic_lokasi ?? 'Pelapor';
        $kontak = $pengajuan->kontak_pic_lokasi ?? null;
        $status = $aduan->statusaduan->nama_status_aduan ?? 'Tidak diketahui';

        if (!$kontak) return;

        $nomor = preg_replace('/^0/', '62', $kontak);
        $pesan = "*Halo $nama*,\n\nStatus aduan Anda telah diperbarui menjadi *$status* oleh Diskominfo Kabupaten Tabalong.\n\nTerima kasih telah melapor.";

        try {
            $token = config('services.fonnte.token');
            Http::withHeaders([
                'Authorization' => $token
            ])->asForm()->post('https://api.fonnte.com/send', [
                'target' => $nomor,
                'message' => $pesan,
                'countryCode' => '62',
            ]);
        } catch (\Throwable $e) {
            Log::error('Gagal kirim WA aduan: ' . $e->getMessage());
        }
    }
}
