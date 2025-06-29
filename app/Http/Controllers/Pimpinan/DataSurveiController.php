<?php

namespace App\Http\Controllers\Pimpinan;

use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class DataSurveiController
{
    public function updateStatus(Request $request, $pengajuanId)
    {
        $request->validate([
            'status_id' => 'required|exists:status,id_status',
        ]);

        $pengajuan = Pengajuan::findOrFail($pengajuanId);

        // Pastikan nama kolom sesuai di tabel pivot
        DB::table('pengajuan_status')
            ->where('pengajuan_id', $pengajuanId)
            ->delete();

        $pengajuan->status()->attach($request->status_id, [
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->kirimNotifStatusPengajuan($pengajuanId);

        return redirect()->back()->with('success', 'Status berhasil diperbarui');
    }
    private function kirimNotifStatusPengajuan($pengajuanId)
    {
        $pengajuan = DB::table('pengajuan')
            ->join('pengguna', 'pengajuan.pengguna_id', '=', 'pengguna.id_pengguna')
            ->join('pengajuan_status', 'pengajuan.id_pengajuan', '=', 'pengajuan_status.pengajuan_id')
            ->join('status', 'pengajuan_status.status_id', '=', 'status.id_status')
            ->where('pengajuan.id_pengajuan', $pengajuanId)
            ->select('pengguna.no_kontak', 'pengguna.nama_pengguna', 'status.nama_status')
            ->first();

        if (!$pengajuan || !$pengajuan->no_kontak) return;

        $nomor = preg_replace('/^0/', '62', $pengajuan->no_kontak);
        $pesan = "*Halo $pengajuan->nama_pengguna*,\n\nStatus pengajuan Anda telah diperbarui menjadi *$pengajuan->nama_status* oleh Diskominfo Kabupaten Tabalong.\n\nSilakan cek kembali di sistem.";

        try {
            $token = config('services.fonnte.token');
            Http::withHeaders([
                'Authorization' => $token
            ])->asForm()->post('https://api.fonnte.com/send', [
                'target'  => $nomor,
                'message' => $pesan,
                'countryCode' => '62',
            ]);
        } catch (\Throwable $e) {
            Log::error("Gagal kirim notifikasi WA: " . $e->getMessage());
        }
    }
}
